<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductionBatch;
use App\Models\ProductionConsumption;
use App\Models\ProductionRule;
use Illuminate\Http\Request;

class ProductionBatchController extends Controller
{
    /* ======================
       LIST BATCHES
    ====================== */
    public function index()
    {
        $batches = ProductionBatch::with('product')
            ->orderBy('production_date', 'desc')
            ->get();
            $products = Product::all();

        return view('admin.pages.production.batches.production-batches', compact('batches','products'));
    }

    /* ======================
       CREATE FORM
    ====================== */
    public function create()
    {
        $products = Product::all();
        return view('production.batches.create', compact('products'));
    }

    /* ======================
       STORE BATCH
    ====================== */
public function store(Request $request)
{
    $request->validate([
        'product_id'       => 'required|exists:products,id',
        'production_date'  => 'required|date',
        'actual_output'    => 'required|integer|min:0',
    ]);

    $rule = ProductionRule::where('product_id', $request->product_id)->first();

    if (!$rule) {
        return back()->withErrors('Production rule not defined for selected product');
    }

    // 🔥 Batch status based on output range
    if ($request->actual_output < $rule->min_output) {
        $status = 'under';
    } elseif ($request->actual_output > $rule->max_output) {
        $status = 'over';
    } else {
        $status = 'normal';
    }

    // 1️⃣ Create batch
    $batch = ProductionBatch::create([
        'product_id'      => $request->product_id,
        'production_date' => $request->production_date,
        'actual_output'   => $request->actual_output,
        'status'          => $status,
    ]);

    // 2️⃣ Create expected consumption from BOM
    $recipes = $batch->product->productionRecipes;

    foreach ($recipes as $recipe) {

        $expectedQty = (float) $recipe->qty_per_unit
                     * (float) $batch->actual_output;

        ProductionConsumption::create([
            'batch_id'        => $batch->id,
            'raw_material_id' => $recipe->raw_material_id,
            'expected_qty'    => $expectedQty,
            'actual_qty'      => 0, // ✅ actual raw material will be filled later
        ]);
    }

    return redirect()
        ->route('production-batches.index')
        ->with('success', 'Production batch created and expected raw material consumption generated');
}


    /* ======================
       EDIT FORM
    ====================== */
    public function edit($id)
    {
        $batch = ProductionBatch::findOrFail($id);
        $products = Product::all();

        return view('production.batches.edit', compact('batch', 'products'));
    }

    /* ======================
       UPDATE BATCH
    ====================== */
    public function update(Request $request, $id)
    {
        $batch = ProductionBatch::findOrFail($id);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'production_date' => 'required|date',
            'actual_output' => 'required|integer|min:0',
        ]);

        $rule = ProductionRule::where('product_id', $request->product_id)->first();

        if (!$rule) {
            return back()->withErrors('Production rule not defined for selected product');
        }

        // 🔥 STATUS LOGIC AGAIN
        if ($request->actual_output < $rule->min_output) {
            $status = 'under';
        } elseif ($request->actual_output > $rule->max_output) {
            $status = 'over';
        } else {
            $status = 'normal';
        }

        $batch->update([
            'product_id' => $request->product_id,
            'production_date' => $request->production_date,
            'actual_output' => $request->actual_output,
            'status' => $status,
        ]);

        return redirect()
            ->route('production-batches.index')
            ->with('success', 'Production batch updated successfully');
    }

    /* ======================
       DELETE BATCH
    ====================== */
  public function destroy($id)
{
    $batch = ProductionBatch::findOrFail($id);

    // delete consumptions first
    $batch->consumptions()->delete();

    // then delete batch
    $batch->delete();

    return redirect()
        ->route('production-batches.index')
        ->with('success', 'Production batch and its consumptions deleted successfully');
}

}
