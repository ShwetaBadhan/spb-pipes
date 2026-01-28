<?php

namespace App\Http\Controllers;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use App\Models\Unit;
class RawMaterialController extends Controller
{
  public function index()
{
    $materials = RawMaterial::with('unit')->latest()->get();
    $units = Unit::all();

    return view(
        'admin.pages.rawmaterials.raw-materials',
        compact('materials', 'units')
    );
}


    public function create()
    {
        return view('raw_materials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_name' => 'required|max:100',
            'unit_id'      => 'required|string',
            'min_stock' => 'required|numeric'
        ]);

        RawMaterial::create($request->all());

        return redirect()->route('raw-materials.index')
                         ->with('success', 'Raw material added successfully');
    }

    public function edit(RawMaterial $rawMaterial)
    {
        return view('raw_materials.edit', compact('rawMaterial'));
    }

    public function update(Request $request, RawMaterial $rawMaterial)
    {
        $request->validate([
            'material_name' => 'required|max:100',
            'unit_id'      => 'required|string',
            'min_stock' => 'required|numeric'
        ]);

        $rawMaterial->update($request->all());

        return redirect()->route('raw-materials.index')
                         ->with('success', 'Raw material updated successfully');
    }

    public function destroy(RawMaterial $rawMaterial)
    {
        $rawMaterial->delete();

        return redirect()->route('raw-materials.index')
                         ->with('success', 'Raw material deleted successfully');
    }
}