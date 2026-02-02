<?php

namespace App\Http\Controllers;

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
        $query = Order::where('salesman_id', Auth::id())->with('salesman')->latest();
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }
        
        $orders = $query->paginate(15);
        
        return view('admin.pages.order-management.orders', compact('orders'));
    }
    
    public function create()
    {
        $products = Product::with('variants')->where('status', 'active')->get();
        return view('admin.pages.order-management.create', compact('products'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email',
            'customer_address' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        try {
            // Generate unique order number
            $orderNumber = 'ORD-' . date('ymd') . '-' . str_pad(Order::count() + 1, 5, '0', STR_PAD_LEFT);
            
            $subtotal = collect($validated['items'])->sum(fn($item) => $item['quantity'] * $item['unit_price']);
            $tax = $validated['tax'] ?? 0;
            $shippingCost = $validated['shipping_cost'] ?? 0;
            $total = $subtotal + $tax + $shippingCost;
            
            $order = Order::create([
                'order_number' => $orderNumber,
                'salesman_id' => Auth::id(),
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
            
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'product_name' => $product->name,
                    'variant_name' => $item['variant_name'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                ]);
                
                // Deduct stock
                if (isset($item['variant_id'])) {
                    $variant = \App\Models\ProductVariant::find($item['variant_id']);
                    if ($variant && $variant->quantity >= $item['quantity']) {
                        $variant->decrement('quantity', $item['quantity']);
                    } else {
                        throw new \Exception("Insufficient stock for variant: {$variant->name}");
                    }
                } else {
                    if ($product->quantity >= $item['quantity']) {
                        $product->decrement('quantity', $item['quantity']);
                    } else {
                        throw new \Exception("Insufficient stock for product: {$product->name}");
                    }
                }
            }
            
            DB::commit();
            return redirect()->route('admin.orders.show', $order)->with('success', 'Order created successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
    
    public function show(Order $order)
    {
        // Only allow viewing orders created by the logged-in user
        if ($order->salesman_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $order->load(['items.product', 'items.variant', 'salesman']);
        return view('admin.pages.order-management.show', compact('order'));
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
        
        $order->update(['status' => $validated['status']]);
        
        return back()->with('success', 'Order status updated successfully!');
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
}