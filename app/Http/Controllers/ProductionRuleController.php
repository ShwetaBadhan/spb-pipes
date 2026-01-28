<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductionRule;
use Illuminate\Http\Request;

class ProductionRuleController extends Controller
{
    /* ======================
       LIST ALL RULES
    ====================== */
    public function index()
    {
        $rules = ProductionRule::with('product')->get();
        $products = Product::all();
        return view('admin.pages.production.rules.production-rules', compact('rules', 'products'));
    }

    /* ======================
       CREATE FORM
    ====================== */
    public function create()
    {
        $products = Product::all();
        return view('production.rules.create', compact('products'));
    }

    /* ======================
       STORE RULE
    ====================== */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id|unique:production_rules,product_id',
            'min_output' => 'required|integer|min:0',
            'max_output' => 'required|integer|gte:min_output',
        ]);

        ProductionRule::create($request->all());

        return redirect()
            ->route('production-rules.index')
            ->with('success', 'Production rule created successfully');
    }

    /* ======================
       EDIT FORM
    ====================== */
    public function edit($id)
    {
        $rule = ProductionRule::findOrFail($id);
        $products = Product::all();

        return view('production.rules.edit', compact('rule', 'products'));
    }

    /* ======================
       UPDATE RULE
    ====================== */
    public function update(Request $request, $id)
    {
        $rule = ProductionRule::findOrFail($id);

        $request->validate([
            'product_id' => 'required|exists:products,id|unique:production_rules,product_id,' . $rule->id,
            'min_output' => 'required|integer|min:0',
            'max_output' => 'required|integer|gte:min_output',
        ]);

        $rule->update($request->all());

        return redirect()
            ->route('production-rules.index')
            ->with('success', 'Production rule updated successfully');
    }

    /* ======================
       DELETE RULE
    ====================== */
 public function destroy(ProductionRule $production_rule)
{
    $production_rule->delete();

    return redirect()
        ->route('production-rules.index')
        ->with('success', 'Production rule deleted successfully');
}

}
