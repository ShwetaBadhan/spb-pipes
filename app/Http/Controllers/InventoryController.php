<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\ProductVariant;
use App\Models\InventoryLog;
use Illuminate\Support\Facades\Log; // ✅ Import Log facade
use App\Services\InventoryService;
class InventoryController extends Controller
{
  public function index()
{
$allProducts = Product::with(['unit'])->get(); // fetch all products for dropdown

$products = Product::with(['variants', 'unit', 'inventoryLogs'])
    ->get()
    ->filter(fn($product) => $product->inventoryLogs->count() > 0);
    
$allRawMaterials = RawMaterial::with(['unit', 'inventoryLogs'])
    ->whereHas('inventoryLogs')   // only raw materials with logs
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

            $runningStock = 0; // raw material ka opening stock agar alag table me ho toh yahan add kar sakti ho
            $unit = optional($raw->unit)->name ?? 'N/A';
        }

        $history = [];

        foreach ($logs as $log) {
            if ($log->status === 'stock_in') {
                $runningStock += $log->quantity;
                $adjustment = '+' . $log->quantity;
                $class = 'text-success';
            } else {
                $runningStock -= $log->quantity;
                $adjustment = '-' . $log->quantity;
                $class = 'text-danger';
            }

            $history[] = [
                'date'             => $log->created_at->format('d M Y, h:i A'),
                'unit'             => $unit,
                'adjustment'       => $adjustment,
                'adjustment_class' => $class,
                'stock'            => max(0, $runningStock),
                'reason'           => ucfirst(str_replace('_', ' ', $log->status)),
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

    public function dashboard()
{
    $lowStockProducts = InventoryService::getLowStockProducts();
    $lowStockRawMaterials = InventoryService::getLowStockRawMaterials();

    return view('admin.dashboard', compact('lowStockProducts', 'lowStockRawMaterials'));
}
}
