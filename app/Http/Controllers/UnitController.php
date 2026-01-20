<?php
namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::latest()->get();
        return view('admin.pages.units', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:units,name',
            'short_name' => 'required|string|max:20|unique:units,short_name',
            'is_active' => 'required|in:0,1',
        ]);

        Unit::create([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'is_active' => $request->is_active,
        ]);

        return redirect()
        ->route('units')
        ->with('success', 'Unit added successfully.');
    }

    public function edit(Unit $unit)
    {
        return response()->json($unit);
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:units,name,' . $unit->id,
            'short_name' => 'required|string|max:20|unique:units,short_name,' . $unit->id,
            'is_active' => 'required|in:0,1',
        ]);

        $unit->update([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'is_active' => $request->is_active,
        ]);

        return redirect()
        ->route('units')
        ->with('success', 'Unit updated successfully.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()
        ->route('units')
        ->with('success', 'Unit deleted  successfully.');
    }
}

?>