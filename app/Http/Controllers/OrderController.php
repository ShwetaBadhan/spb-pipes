<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class OrderController extends Controller
{


    public function index(Request $request)
{
    // Show only orders created by the logged-in user
    $query = Order::where('salesman_id', Auth::id())
        ->with('salesman')
        ->latest();
    
    // Optional: Add search functionality
    if ($request->has('search') && $request->search != '') {
        $searchTerm = $request->search;
        $query->where(function($q) use ($searchTerm) {
            $q->where('order_number', 'like', '%' . $searchTerm . '%')
              ->orWhere('customer_name', 'like', '%' . $searchTerm . '%');
        });
    }
    
    // Get all orders (no pagination - tabs will filter)
    $orders = $query->get();
    
    return view('admin.pages.order-management.orders', compact('orders'));
}
public function create()
{
    $customers = \App\Models\Customer::all();
    
    // Get products WITH variants in a flat structure
    $products = \App\Models\Product::with('variants')->get()->flatMap(function($product) {
        return $product->variants->map(function($variant) use ($product) {
            return [
                'id' => $product->id,
                'product_name' => $product->name,
                'variant_id' => $variant->id,
                'variant_name' => $variant->name ?? 'Unnamed Variant',
                'selling_price' => $variant->selling_price ?? 0,
                'quantity' => $variant->quantity ?? 0,
            ];
        });
    })->filter(function($item) {
        return $item['variant_id'] && $item['selling_price'] > 0;
    });

    return view('admin.pages.order-management.create', compact('customers', 'products'));
}
    public function store(Request $request)
{
    $validated = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'customer_name' => 'required|string|max:255',
        'customer_phone' => 'nullable|string|max:20',
        'customer_email' => 'nullable|email',
        'customer_address' => 'nullable|string',
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.variant_id' => 'required|exists:product_variants,id', // ✅ REQUIRED
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
        'tax' => 'nullable|numeric|min:0',
        'shipping_cost' => 'nullable|numeric|min:0',
        'notes' => 'nullable|string',
    ]);

    DB::beginTransaction();
    try {
        // ✅ Validate stock availability BEFORE creating order
        $stockErrors = $this->validateOrderStock($validated['items']);
        if (!empty($stockErrors)) {
            throw new \Exception(implode("\n", $stockErrors));
        }

        // Generate order number
        $orderNumber = 'ORD-' . date('ymd') . '-' . str_pad(Order::whereDate('created_at', today())->count() + 1, 5, '0', STR_PAD_LEFT);

        $subtotal = collect($validated['items'])->sum(fn($item) => $item['quantity'] * $item['unit_price']);
        $tax = $validated['tax'] ?? 0;
        $shippingCost = $validated['shipping_cost'] ?? 0;
        $total = $subtotal + $tax + $shippingCost;

        $order = Order::create([
            'order_number' => $orderNumber,
            'salesman_id' => Auth::id(),
            'customer_id' => $validated['customer_id'],
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'customer_email' => $validated['customer_email'] ?? null,
            'customer_address' => $validated['customer_address'] ?? null,
            'status' => 'pending',
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Save order items WITH variant information
        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            $variant = \App\Models\ProductVariant::find($item['variant_id']);
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'], // ✅ Store variant ID
                'product_name' => $product->name,
                'variant_name' => $variant->name, // ✅ Store variant name
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        DB::commit();
        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully! Stock will be deducted when order is confirmed.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Order creation failed: ' . $e->getMessage());
        return back()->withInput()->withErrors(['stock' => $e->getMessage()]);
    }
}

// ✅ Validate stock ONLY from variants (products table has no quantity)
private function validateOrderStock(array $items): array
{
    $errors = [];
    
    foreach ($items as $index => $item) {
        // ⚠️ Products table has NO quantity - MUST use variant
        if (empty($item['variant_id'])) {
            $errors[] = "Item #" . ($index + 1) . ": Variant selection required";
            continue;
        }
        
        $variant = \App\Models\ProductVariant::find($item['variant_id']);
        if (!$variant) {
            $errors[] = "Item #" . ($index + 1) . ": Variant not found";
            continue;
        }
        
        $requestedQty = $item['quantity'];
        $availableQty = $variant->quantity ?? 0;
        $productName = $variant->product->name ?? 'Unknown Product';
        $variantName = $variant->name;
        
        if ($requestedQty > $availableQty) {
            $errors[] = "Insufficient stock for '{$productName} ({$variantName})': Requested {$requestedQty}, Available {$availableQty}";
        }
    }
    
    return $errors;
}
// ✅ NEW METHOD: Validate stock availability before order creation

    public function show(Order $order)
    {
        // Only allow viewing orders created by the logged-in user
        if ($order->salesman_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load(['items.product', 'items.variant', 'salesman']);
        return view('admin.pages.order-management.orders', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
{
    // Only allow updating orders created by the logged-in user
    if ($order->salesman_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }
    
    $validated = $request->validate([
        'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
    ]);
    
    $oldStatus = $order->status;
    $newStatus = $validated['status'];
    
    DB::beginTransaction();
    try {
        // Handle stock based on status transition
        if ($oldStatus !== $newStatus) {
            // CASE 1: Confirming order → DEDUCT STOCK FROM VARIANTS
            if ($oldStatus === 'pending' && $newStatus === 'confirmed') {
                $this->deductOrderStock($order);
            }
            
            // CASE 2: Cancelling order → RESTORE STOCK TO VARIANTS
            if (in_array($oldStatus, ['pending', 'confirmed', 'processing', 'shipped']) && $newStatus === 'cancelled') {
                $this->restoreOrderStock($order);
            }
            
            // CASE 3: Reverting cancelled order → DEDUCT STOCK again
            if ($oldStatus === 'cancelled' && in_array($newStatus, ['pending', 'confirmed', 'processing'])) {
                $this->deductOrderStock($order);
            }
        }
        
        $order->update(['status' => $newStatus]);
        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully!',
            'new_status' => $newStatus,
            'old_status' => $oldStatus
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Status update failed: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 422);
    }
}

// Helper: Deduct stock ONLY from variants (products table has no quantity)
private function deductOrderStock(Order $order)
{
    foreach ($order->items as $item) {
        // ⚠️ CRITICAL: Products table has NO quantity column - ONLY variants have stock
        if (!$item->variant_id) {
            throw new \Exception("Cannot deduct stock: Product '{$item->product_name}' requires variant selection. Order item #{$item->id} missing variant_id.");
        }
        
        $variant = \App\Models\ProductVariant::find($item->variant_id);
        if (!$variant) {
            throw new \Exception("Variant not found for item: {$item->product_name} (Variant ID: {$item->variant_id})");
        }
        
        if ($variant->quantity < $item->quantity) {
            throw new \Exception("Insufficient stock for variant '{$variant->name}' of product '{$item->product_name}': Requested {$item->quantity}, Available {$variant->quantity}");
        }
        
        // ✅ DEDUCT FROM VARIANT ONLY (products table has no quantity column)
        $variant->decrement('quantity', $item->quantity);
        
        Log::info("Stock deducted from variant", [
            'order_id' => $order->id,
            'variant_id' => $variant->id,
            'variant_name' => $variant->name,
            'quantity_deducted' => $item->quantity,
            'remaining_stock' => $variant->quantity
        ]);
    }
}

// Helper: Restore stock ONLY to variants
private function restoreOrderStock(Order $order)
{
    foreach ($order->items as $item) {
        if ($item->variant_id) {
            $variant = \App\Models\ProductVariant::find($item->variant_id);
            if ($variant) {
                // ✅ RESTORE TO VARIANT ONLY
                $variant->increment('quantity', $item->quantity);
                
                Log::info("Stock restored to variant", [
                    'order_id' => $order->id,
                    'variant_id' => $variant->id,
                    'quantity_restored' => $item->quantity,
                    'new_stock' => $variant->quantity
                ]);
            }
        }
        // Note: If variant_id is null, we cannot restore (shouldn't happen with proper validation)
    }
}
    public function destroy(Order $order)
    {
        // Only allow deleting orders created by the logged-in user
        if ($order->salesman_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully!');
    }
    
    public function getOrderDetails(Order $order)
{
    // Only allow viewing orders created by the logged-in user
    if ($order->salesman_id !== Auth::id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    
    $order->load('items');
    
    return response()->json([
        'order' => [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'customer_name' => $order->customer_name,
            'customer_phone' => $order->customer_phone,
            'customer_email' => $order->customer_email,
            'customer_address' => $order->customer_address,
            'subtotal' => $order->subtotal,
            'tax' => $order->tax,
            'shipping_cost' => $order->shipping_cost,
            'total' => $order->total,
            'status' => $order->status,
            'notes' => $order->notes,
            'created_at' => $order->created_at->format('M d, Y h:i A'),
        ],
        'items' => $order->items->map(function($item) {
            return [
                'id' => $item->id,
                'product_name' => $item->product_name,
                'variant_name' => $item->variant_name,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'subtotal' => $item->subtotal,
            ];
        })
    ]);
}
}
