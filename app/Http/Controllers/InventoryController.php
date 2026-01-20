<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\InventoryLog; 
use Illuminate\Support\Facades\Log; // ✅ Import Log facade

class InventoryController extends Controller
{
public function index()
{
    // Fetch products that have inventory logs
    $inventoryProducts = Product::with(['variants', 'inventoryLogs', 'unit'])
        ->whereHas('inventoryLogs')
        ->get();

    // Calculate available quantity per variant
    foreach ($inventoryProducts as $product) {
        foreach ($product->variants as $variant) {
            $openingQty = $variant->quantity; // initial stock from product/variant

            $stockIn = InventoryLog::where('product_id', $product->id)
            ->where('status', 'stock_in')
            ->whereNull('deleted_at')
            ->sum('quantity');

        $stockOut = InventoryLog::where('product_id', $product->id)
            ->where('status', 'stock_out')
            ->whereNull('deleted_at')
            ->sum('quantity');
            $variant->available_qty = max(0, $openingQty + $stockIn - $stockOut);

            // Optional: attach latest log for edit modal pre-fill
            $variant->latest_log = $product->inventoryLogs->sortByDesc('id')->first();
        }
    }

    // All products for "Add Inventory" dropdown
    $allProducts = Product::with(['variants', 'unit'])->get();

    return view('admin.pages.inventory', [
        'products' => $inventoryProducts,
        'allProducts' => $allProducts
    ]);
}




public function store(Request $request)
{
    $request->validate([
        'item_id' => 'required|exists:products,id',
        'quantity' => 'required|numeric|min:1',
        'status' => 'required|in:stock_in,stock_out',
    ]);

    InventoryLog::create([
        'product_id' => $request->item_id,
        'quantity'   => $request->quantity,
        'status'     => $request->status,
    ]);

    return redirect()->back()->with('success', 'Inventory adjustment added successfully!');
}

public function getHistory(Product $product)
{
    // Get all logs for this product, sorted oldest to newest
    $logs = InventoryLog::where('product_id', $product->id)
        ->orderBy('created_at', 'asc')
        ->get();

    // Calculate running stock
    $runningStock = $product->variants->sum('quantity'); // opening stock

    $history = [];
    foreach ($logs as $log) {
        if ($log->status === 'stock_in') {
            $runningStock += $log->quantity;
            $adjustment = '+' . $log->quantity;
            $adjustmentClass = 'text-success';
        } else {
            $runningStock -= $log->quantity;
            $adjustment = '-' . $log->quantity;
            $adjustmentClass = 'text-danger';
        }

        $history[] = [
            'date' => $log->created_at->format('d M Y, h:i A'),
            'unit' => optional($product->unit)->name ?? 'N/A',
            'adjustment' => $adjustment,
            'adjustment_class' => $adjustmentClass,
            'stock' => max(0, $runningStock),
            'reason' => ucfirst(str_replace('_', ' ', $log->status)) // e.g., "Stock In"
        ];
    }

    return response()->json($history);
}

public function destroy(InventoryLog $log)
{
    Log::info("Deleting log ID: " . $log->id);
    Log::info("Before delete - Status: " . $log->status);
    
    $log->delete(); // soft delete

    Log::info("After delete - deleted_at: " . ($log->deleted_at ? $log->deleted_at->toISOString() : 'NULL'));
    return redirect()->back()->with('success', 'Log deleted.');
}

}
