<?php

namespace App\Http\Controllers;

use App\Models\GatePass;
use App\Models\LaborType;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GatePassController extends Controller
{
    /**
     * Display a listing of gate passes
     */
    public function index()
    {
        // Group by batch_number to show vehicles
        $gatePasses = GatePass::select('batch_number', 'date')
            ->groupBy('batch_number', 'date')
            ->orderBy('date', 'desc')
            ->orderBy('batch_number', 'desc')
            ->get();

        return view('admin.pages.gate-passes.index', compact('gatePasses'));
    }

    /**
     * Show the form for creating a new gate pass
     */
    public function create()
    {
        $products = Product::where('status', 1)->get();
        $laborTypes = LaborType::where('status', 1)->get();

        return view('admin.pages.gate-passes.create', compact('products', 'laborTypes'));
    }

    /**
     * Store a newly created gate pass
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:inward,outward', // <-- ADD VALIDATION
            'batch_number' => 'required|string|max:100',
            'date' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.labor_type_id' => 'required|exists:labor_types,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.workers_count' => 'required|integer|min:1',
            'remarks' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->products as $productData) {
                $laborType = LaborType::find($productData['labor_type_id']);

                GatePass::create([
                    'batch_number' => $request->batch_number,
                    'type' => $request->type, // <-- SAVE TYPE
                    'date' => $request->date,
                    'product_id' => $productData['product_id'],
                    'labor_type_id' => $productData['labor_type_id'],
                    'quantity' => $productData['quantity'],
                    'workers_count' => $productData['workers_count'],
                    'rate_amount' => $laborType->rate_amount,
                    'total_cost' => $laborType->rate_amount * $productData['workers_count'],
                    'remarks' => $request->remarks ?? null
                ]);
            }

            DB::commit();
            return redirect()->route('admin.gate-passes.index')
                ->with('success', 'Gate Pass created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified gate pass
     */
    public function show($batchNumber)
    {
        $gatePasses = GatePass::with(['product', 'laborType'])
            ->where('batch_number', $batchNumber)
            ->get();

        if ($gatePasses->isEmpty()) {
            return redirect()->route('admin.gate-passes.index')
                ->with('error', 'Gate Pass not found');
        }

        $totalCost = GatePass::getTotalCostByBatch($batchNumber);
        $firstEntry = $gatePasses->first();

        return view('admin.pages.gate-passes.show', compact('gatePasses', 'totalCost', 'firstEntry'));
    }

    /**
     * Show the form for editing the specified gate pass
     */
    public function edit($id)
    {
        $gatePass = GatePass::with(['product', 'laborType'])->findOrFail($id);
        $products = Product::where('status', 1)->get();
        $laborTypes = LaborType::where('status', 1)->get();

        return view('admin.pages.gate-passes.edit', compact('gatePass', 'products', 'laborTypes'));
    }

    /**
     * Update the specified gate pass
     */
    public function update(Request $request, $id)
    {
        $gatePass = GatePass::findOrFail($id);

        $request->validate([
            'type' => 'required|in:inward,outward', // <-- ADD VALIDATION
            'batch_number' => 'required|string|max:100',
            'date' => 'required|date',
            'product_id' => 'required|exists:products,id',
            'labor_type_id' => 'required|exists:labor_types,id',
            'quantity' => 'required|integer|min:1',
            'workers_count' => 'required|integer|min:1',
            'remarks' => 'nullable|string'
        ]);

        $laborType = LaborType::find($request->labor_type_id);

        $gatePass->update([
            'batch_number' => $request->batch_number,
            'type' => $request->type, // <-- UPDATE TYPE
            'date' => $request->date,
            'product_id' => $request->product_id,
            'labor_type_id' => $request->labor_type_id,
            'quantity' => $request->quantity,
            'workers_count' => $request->workers_count,
            'rate_amount' => $laborType->rate_amount,
            'total_cost' => $laborType->rate_amount * $request->workers_count,
            'remarks' => $request->remarks ?? null
        ]);

        return redirect()->route('admin.gate-passes.index')
            ->with('success', 'Gate Pass updated successfully!');
    }

    /**
     * Remove the specified gate pass
     */
    public function destroy($id)
    {
        $gatePass = GatePass::findOrFail($id);
        $batchNumber = $gatePass->batch_number;

        $gatePass->delete();

        $remaining = GatePass::where('batch_number', $batchNumber)->count();

        if ($remaining == 0) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('admin.gate-passes.index'),
                    'message' => 'Gate Pass deleted successfully!'
                ]);
            }
            return redirect()->route('admin.gate-passes.index')
                ->with('success', 'Gate Pass deleted successfully!');
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'redirect' => route('admin.gate-passes.show', $batchNumber),
                'message' => 'Entry deleted successfully!'
            ]);
        }
        return redirect()->route('admin.gate-passes.show', $batchNumber)
            ->with('success', 'Entry deleted successfully!');
    }

    /**
     * Get labor type rate via AJAX
     */
    public function getLaborRate($id)
    {
        $laborType = LaborType::find($id);
        return response()->json([
            'rate_amount' => $laborType->rate_amount ?? 0
        ]);
    }
    /**
     * Generate Gate Pass Slip
     */
    public function generateSlip($batchNumber)
    {
        $gatePasses = GatePass::with(['product', 'laborType'])
            ->where('batch_number', $batchNumber)
            ->get();

        if ($gatePasses->isEmpty()) {
            return redirect()->route('admin.gate-passes.index')
                ->with('error', 'Gate Pass not found');
        }

        $totalCost = GatePass::getTotalCostByBatch($batchNumber);
        $firstEntry = $gatePasses->first();

        return view('admin.pages.gate-passes.slip', compact('gatePasses', 'totalCost', 'firstEntry'));
    }
}
