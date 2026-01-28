<?php

namespace App\Http\Controllers;

use App\Models\ProductionBatch;
use App\Models\ProductionRecipe;
use App\Models\ProductionConsumption;
use Illuminate\Http\Request;
use App\Models\RawMaterial;

class ProductionConsumptionController extends Controller
{
public function consumptions(ProductionBatch $batch)
{
    $consumptions = $batch->consumptions()
        ->with('rawMaterial')
        ->get();

    return view(
        'admin.pages.production.batches.consumptions.production-consumptions',
        compact('batch', 'consumptions')
    );
}
public function update(Request $request, $batchId)
{
    foreach ($request->actual_qty as $consumptionId => $actualQty) {

        $consumption = ProductionConsumption::find($consumptionId);

        $consumption->update([
            'actual_qty' => $actualQty,
        ]);
    }

    return back()->with('success', 'Actual consumption updated successfully');
}

}
