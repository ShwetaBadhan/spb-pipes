<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\ProductVariant;
use App\Models\InventoryLog;
use Illuminate\Support\Facades\Log; // ✅ Import Log facade
use App\Services\InventoryService;
use App\Models\Order; 
class InventoryController extends Controller
{
    public function index()
    {
        $allProducts = Product::with(['unit'])->get();

        $products = Product::with(['variants', 'unit', 'inventoryLogs'])->get()
            ->filter(fn($product) => $product->inventoryLogs->count() > 0);
            
        $allRawMaterials = RawMaterial::with(['unit', 'inventoryLogs'])
            ->whereHas('inventoryLogs')
            ->get();
            
        
        return view('admin.pages.inventory', compact('allProducts', 'products', 'allRawMaterials'));
    }   





    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([

            'item_type' => 'required|in:product,raw_material',
            'item_id'   => 'required',
            'quantity'  => 'required|numeric|min:1',
            'status'    => 'required|in:stock_in,stock_out',
        ]);

        $data = [
            'item_type' => $request->item_type,
            'quantity'  => $request->quantity,
            'status'    => $request->status,
        ];

        if ($request->item_type === 'product') {
            $request->validate([
                'item_id' => 'exists:products,id'
            ]);
            $data['product_id'] = $request->item_id;
        }

        if ($request->item_type === 'raw_material') {
            $request->validate([
                'item_id' => 'exists:raw_materials,id'
            ]);
            $data['raw_material_id'] = $request->item_id;
        }

        InventoryLog::create($data);

        return redirect()->back()->with('success', 'Inventory added successfully!');
    }

   // app/Http/Controllers/InventoryController.php

public function getHistory(Request $request)
{
    $request->validate([
        'item_type' => 'required|in:product,raw_material',
        'item_id'   => 'required|integer',
    ]);

    $itemType = $request->item_type;
    $itemId   = $request->item_id;

    if ($itemType === 'product') {
        $product = Product::with('unit', 'variants')->findOrFail($itemId);
        $logs = InventoryLog::where('item_type', 'product')
            ->where('product_id', $itemId)
            ->orderBy('created_at', 'asc')
            ->get();
        $runningStock = $product->variants->sum('quantity');
        $unit = optional($product->unit)->name ?? 'N/A';
    }

    if ($itemType === 'raw_material') {
        $raw = RawMaterial::with('unit')->findOrFail($itemId);
        $logs = InventoryLog::where('item_type', 'raw_material')
            ->where('raw_material_id', $itemId)
            ->orderBy('created_at', 'asc')
            ->get();
        $runningStock = 0;
        $unit = optional($raw->unit)->name ?? 'N/A';
    }

    $history = [];
    foreach ($logs as $log) {
        if ($log->status === 'stock_in') {
            $runningStock += $log->quantity;
            $adjustment = '+' . $log->quantity;
            $class = 'text-success';
            $badge = 'badge bg-success';
        } else {
            $runningStock -= $log->quantity;
            $adjustment = '-' . $log->quantity;
            $class = 'text-danger';
            $badge = 'badge bg-danger';
        }

        // ✅ Determine source (order vs manual)
        $source = [];
        if (str_contains($log->notes ?? '', 'Order #')) {
            preg_match('/Order #([^\s]+)/', $log->notes, $matches);
            $source = [
                'type' => 'order',
                'reference' => $matches[1] ?? 'N/A',
            ];
        } else {
            $source = [
                'type' => 'manual',
                'reference' => 'Manual Entry',
            ];
        }

        $history[] = [
            'date' => $log->created_at->format('d M Y, h:i A'),
            'unit' => $unit,
            'adjustment' => $adjustment,
            'adjustment_class' => $class,
            'badge_class' => $badge,
            'stock' => max(0, $runningStock),
            'reason' => ucfirst(str_replace('_', ' ', $log->status)),
            'source' => $source, // ✅ Add source info
            'notes' => $log->notes ?? '-', // ✅ Add notes
        ];
    }

    return response()->json($history);
}

// ✅ Helper: Identify if log is from order or manual entry
private function getLogSource($log)
{
    if (str_contains($log->notes, 'Order #')) {
        preg_match('/Order #([^\s]+)/', $log->notes, $matches);
        if (isset($matches[1])) {
            return [
                'type' => 'order',
                'reference' => $matches[1],
            ];
        }
    }
    return [
        'type' => 'manual',
        'reference' => 'Manual Entry',
    ];
}    public function destroy(InventoryLog $log)
    {
        Log::info("Deleting log ID: " . $log->id);
        Log::info("Before delete - Status: " . $log->status);

        $log->delete(); // soft delete

        Log::info("After delete - deleted_at: " . ($log->deleted_at ? $log->deleted_at->toISOString() : 'NULL'));
        return redirect()->back()->with('success', 'Log deleted.');
    }

    public function dashboard()
{
    $lowStockProducts = InventoryService::getLowStockProducts();
    $lowStockRawMaterials = InventoryService::getLowStockRawMaterials();

    return view('admin.dashboard', compact('lowStockProducts', 'lowStockRawMaterials'));
}


// Helper: Deduct stock with InventoryLog creation
private function deductOrderStock(Order $order)
{
    foreach ($order->items as $item) {
        if (!$item->variant_id) {
            throw new \Exception("Cannot deduct stock: Product '{$item->product_name}' requires variant selection.");
        }
        
        $variant = \App\Models\ProductVariant::find($item->variant_id);
        if (!$variant) {
            throw new \Exception("Variant not found for item: {$item->product_name}");
        }
        
        if ($variant->quantity < $item->quantity) {
            throw new \Exception("Insufficient stock for variant '{$variant->name}': Requested {$item->quantity}, Available {$variant->quantity}");
        }
        
        // ✅ Track BEFORE quantity
        $quantityBefore = $variant->quantity;
        
        // ✅ DEDUCT from variant
        $variant->decrement('quantity', $item->quantity);
        
        // ✅ CREATE INVENTORY LOG (stock_out)
        \App\Models\InventoryLog::create([
            'item_type' => 'product',
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'status' => 'stock_out',
            'notes' => "Order #{$order->order_number} confirmed - deducted {$item->quantity} units of {$item->product_name} ({$item->variant_name})",
        ]);
        
        Log::info("Stock deducted via inventory log", [
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'variant_id' => $item->variant_id,
            'quantity_before' => $quantityBefore,
            'quantity_after' => $variant->quantity,
            'quantity_change' => -$item->quantity,
        ]);
    }
}

// Helper: Restore stock with InventoryLog creation
private function restoreOrderStock(Order $order)
{
    foreach ($order->items as $item) {
        if ($item->variant_id) {
            $variant = \App\Models\ProductVariant::find($item->variant_id);
            if ($variant) {
                // ✅ Track BEFORE quantity
                $quantityBefore = $variant->quantity;
                
                // ✅ RESTORE to variant
                $variant->increment('quantity', $item->quantity);
                
                // ✅ CREATE INVENTORY LOG (stock_in)
                \App\Models\InventoryLog::create([
                    'item_type' => 'product',
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'status' => 'stock_in',
                    'notes' => "Order #{$order->order_number} cancelled/reverted - restored {$item->quantity} units of {$item->product_name} ({$item->variant_name})",
                ]);
                
                Log::info("Stock restored via inventory log", [
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity_before' => $quantityBefore,
                    'quantity_after' => $variant->quantity,
                    'quantity_change' => $item->quantity,
                ]);
            }
        }
    }
}


}
