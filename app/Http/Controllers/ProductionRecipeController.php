<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\ProductionRecipe;
use Illuminate\Http\Request;

class ProductionRecipeController extends Controller
{
  public function index()
{
    $recipes = ProductionRecipe::with(['product', 'rawMaterial'])->get();
    $products = Product::all();
    $rawMaterials = RawMaterial::all(); // add this line

    return view(
        'admin.pages.production.billofmaterials.bill-of-materials',
        compact('recipes','products','rawMaterials') // include it here
    );
}

    public function create()
    {
        return view('production.recipes.create', [
            'products' => Product::all(),
            'rawMaterials' => RawMaterial::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'raw_material_id' => 'required|exists:raw_materials,id',
            'qty_per_unit' => 'required|numeric|min:0.0001',
        ]);

        ProductionRecipe::create($request->all());

        return redirect()->route('bill-of-materials.index')
            ->with('success', 'BOM added successfully');
    }

    public function edit($id)
    {
        return view('production.recipes.edit', [
            'recipe' => ProductionRecipe::findOrFail($id),
            'products' => Product::all(),
            'rawMaterials' => RawMaterial::all(),
        ]);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'raw_material_id' => 'required|exists:raw_materials,id',
        'qty_per_unit' => 'required|numeric|min:0.0001',
    ]);

    $recipe = ProductionRecipe::findOrFail($id);
    $recipe->update($request->all());

    return redirect()
        ->route('bill-of-materials.index')
        ->with('success', 'Recipe updated successfully');
}

    public function destroy($id)
    {
        ProductionRecipe::findOrFail($id)->delete();

        return redirect()->route('bill-of-materials.index')
            ->with('success', 'BOM deleted successfully');
    }
}
