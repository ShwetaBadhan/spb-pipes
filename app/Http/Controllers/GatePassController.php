<?php

namespace App\Http\Controllers;

use App\Models\GatePass;
use App\Models\LaborType;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Exception;
class GatePassController extends Controller
{
    public function index()
    {
        $gatePasses = GatePass::select('id', 'batch_number', 'date')
            // ->groupBy('batch_number', 'date', 'id')
            ->orderBy('date', 'desc')
            // ->orderBy('batch_number', 'desc')
            ->get();

        return view('admin.pages.gate-passes.index', compact('gatePasses'));
    }

    public function create()
    {
        $products = Product::where('status', 1)->get();
        $laborTypes = LaborType::where('status', 1)->get();
        $customers = Customer::all(); // Get all customers

        // ✅ Get all invoices and group by customer_id (NO relationship needed)
        $allInvoices = Invoice::whereIn('status', ['paid', 'partially_paid', 'unpaid'])
            ->with('items') // Eager load items
            ->orderBy('created_at', 'desc')
            ->get();

        // Group invoices by customer_id
        $customerInvoicesData = [];
        foreach ($allInvoices as $invoice) {
            $customerId = $invoice->customer_id;
            
            $customerInvoicesData[$customerId][$invoice->id] = [
                'invoice_number' => $invoice->invoice_number,
                'grand_total' => $invoice->grand_total,
                'status' => $invoice->status,
                'items' => $invoice->items->map(function($item) use ($products) {
                    // Try to match product by name
                    $matchedProduct = $products->first(function($p) use ($item) {
                        return strtolower(trim($item->item_name)) === strtolower(trim($p->name));
                    });
                    
                    return [
                        'product_id' => $matchedProduct ? $matchedProduct->id : null,
                        'quantity' => $item->quantity,
                        'rate' => $item->rate,
                        'discount_percent' => $item->discount_percent ?? 0,
                        'amount' => $item->amount,
                        'labor_type_id' => null, // Will be selected by user
                        'workers_count' => 1, // Default
                    ];
                })
            ];
        }

        return view('admin.pages.gate-passes.create', compact(
            'products', 
            'laborTypes', 
            'customers', 
            'customerInvoicesData'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
             'customer_id' => 'required|exists:customers,id', // ✅ Now valid
        'invoice_id' => 'nullable|exists:invoices,id', // ✅ Now valid
            'type' => 'required|in:inward,outward',
            'batch_number' => 'required|string|max:100',
            'date' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.labor_type_id' => 'required|exists:labor_types,id',
            'products.*.quantity' => 'required|numeric|min:0.01',
            'products.*.workers_count' => 'required|integer|min:1',
            'remarks' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->products as $productData) {
                $laborType = LaborType::find($productData['labor_type_id']);

                GatePass::create([
                      'customer_id' => $request->customer_id, // ✅ Now saves correctly
                'invoice_id' => $request->invoice_id, // ✅ Now saves correctly
                    'batch_number' => $request->batch_number,
                    'type' => $request->type,
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

    public function show($batchNumber)
    {
        $gatePasses = GatePass::with([
                'product', 
                'laborType', 
                'customer.billingStateRelation',  // Add this
                'customer.billingCityRelation',   // Add this
                'invoice'
            ])
            ->where('batch_number', $batchNumber)
            ->get();

        if ($gatePasses->isEmpty()) {
            return redirect()->route('admin.gate-passes.index')
                ->with('error', 'Gate Pass not found');
        }

        $totalCost = GatePass::where('batch_number', $batchNumber)->sum('total_cost');
        $firstEntry = $gatePasses->first();

        return view('admin.pages.gate-passes.show', compact('gatePasses', 'totalCost', 'firstEntry'));
    }
    public function edit($id)
    {
        $gatePass = GatePass::with(['product', 'laborType', 'customer', 'invoice'])->findOrFail($id);
        
        // ✅ Add logging
        Log::info('GatePass Edit - GatePass Data', [
            'id' => $gatePass->id,
            'batch_number' => $gatePass->batch_number,
            'customer_id' => $gatePass->customer_id,
            'invoice_id' => $gatePass->invoice_id,
            'product_id' => $gatePass->product_id,
            'labor_type_id' => $gatePass->labor_type_id,
        ]);

        $products = Product::where('status', 1)->get();
        $laborTypes = LaborType::where('status', 1)->get();
        $customers = Customer::all();

        Log::info('GatePass Edit - Customers Count', ['count' => $customers->count()]);
        Log::info('GatePass Edit - Products Count', ['count' => $products->count()]);
        Log::info('GatePass Edit - LaborTypes Count', ['count' => $laborTypes->count()]);

        // ✅ Get invoices for the current gate pass's customer (pre-selected)
        $customerInvoices = [];
        if ($gatePass->customer_id) {
            $customerInvoices = Invoice::where('customer_id', $gatePass->customer_id)
                ->whereIn('status', ['paid', 'partially_paid', 'unpaid'])
                ->orderBy('created_at', 'desc')
                ->get(['id', 'invoice_number', 'grand_total', 'status']);
            
            Log::info('GatePass Edit - Customer Invoices', [
                'customer_id' => $gatePass->customer_id,
                'invoice_count' => $customerInvoices->count(),
                'invoices' => $customerInvoices->pluck('id', 'invoice_number')->toArray()
            ]);
        } else {
            Log::warning('GatePass Edit - No Customer ID found', ['gate_pass_id' => $gatePass->id]);
        }

        // ✅ Get all invoices grouped by customer for dynamic loading when customer changes
        $allInvoices = Invoice::whereIn('status', ['paid', 'partially_paid', 'unpaid'])
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->get();

        Log::info('GatePass Edit - All Invoices Count', ['count' => $allInvoices->count()]);

        $customerInvoicesData = [];
        foreach ($allInvoices as $invoice) {
            $customerId = $invoice->customer_id;
            
            $customerInvoicesData[$customerId][$invoice->id] = [
                'invoice_number' => $invoice->invoice_number,
                'grand_total' => $invoice->grand_total,
                'status' => $invoice->status,
                'items' => $invoice->items->map(function($item) use ($products) {
                    $matchedProduct = $products->first(function($p) use ($item) {
                        return strtolower(trim($item->item_name)) === strtolower(trim($p->name));
                    });
                    
                    return [
                        'product_id' => $matchedProduct ? $matchedProduct->id : null,
                        'quantity' => $item->quantity,
                        'rate' => $item->rate,
                        'discount_percent' => $item->discount_percent ?? 0,
                        'amount' => $item->amount,
                        'labor_type_id' => null,
                        'workers_count' => 1,
                    ];
                })
            ];
        }

        Log::info('GatePass Edit - CustomerInvoicesData Structure', [
            'customer_count' => count($customerInvoicesData),
            'customers' => array_keys($customerInvoicesData)
        ]);

        return view('admin.pages.gate-passes.edit', compact(
            'gatePass', 
            'products', 
            'laborTypes', 
            'customers', 
            'customerInvoices',
            'customerInvoicesData'
        ));
    }
    public function update(Request $request, $id)
    {
        // ✅ Debug what's being submitted
        Log::info('GatePass Update Request Data', [
            'all' => $request->all(),
            'type' => $request->type,
            'batch_number' => $request->batch_number,
            'date' => $request->date,
            'products' => $request->products,
        ]);

        // dd([
        //     'all' => $request->all(),
        //     'type' => $request->type,
        //     'batch_number' => $request->batch_number,
        //     'date' => $request->date,
        //     'products' => $request->products,
        // ]);
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'type' => 'required|in:inward,outward',
            'batch_number' => 'required|string|max:100',
            'date' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.labor_type_id' => 'required|exists:labor_types,id',
            'products.*.quantity' => 'required|numeric|min:0.01',
            'products.*.workers_count' => 'required|integer|min:1',
            'remarks' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Delete existing gate pass entries for this batch_number
            GatePass::where('batch_number', $request->batch_number)->delete();

            // Create new entries
            foreach ($request->products as $productData) {
                $laborType = LaborType::find($productData['labor_type_id']);

                GatePass::create([
                    'customer_id' => $request->customer_id,
                    'invoice_id' => $request->invoice_id,
                    'batch_number' => $request->batch_number,
                    'type' => $request->type,
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
                ->with('success', 'Gate Pass updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $gatePass = GatePass::findOrFail($id);
        $batchNumber = $gatePass->batch_number;

        $gatePass->delete();

        $remaining = GatePass::where('batch_number', $batchNumber)->count();

        if ($remaining == 0) {
            return redirect()->route('admin.gate-passes.index')
                ->with('success', 'Gate Pass deleted successfully!');
        }

        return redirect()->route('admin.gate-passes.show', $batchNumber)
            ->with('success', 'Entry deleted successfully!');
    }

    public function generateSlip($batchNumber)
    {
        $gatePasses = GatePass::with([
                'product', 
                'laborType', 
                'customer.billingStateRelation',  // Add this
                'customer.billingCityRelation',   // Add this
                'invoice'
            ])
            ->where('batch_number', $batchNumber)
            ->get();

        if ($gatePasses->isEmpty()) {
            return redirect()->route('admin.gate-passes.index')
                ->with('error', 'Gate Pass not found');
        }

        $totalCost = GatePass::where('batch_number', $batchNumber)->sum('total_cost');
        $firstEntry = $gatePasses->first();

        return view('admin.pages.gate-passes.slip', compact('gatePasses', 'totalCost', 'firstEntry'));
    }
}