<?php

namespace App\Http\Controllers;

use App\Models\RateType;
use Illuminate\Http\Request;

class RateTypeController extends Controller
{
    public function index(Request $request)
    {
        $rateTypes = RateType::when($request->status, fn($q) => $q->where('status', $request->status))
                           ->latest()
                           ->paginate(15);
        return view('admin.pages.rate-types', compact('rateTypes')); // ✅ Correct
    }

    public function create()
    {
        return view('admin.pages.rate-types.create'); // ✅ Fixed: added .pages.
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rate_types,name',
            'slug' => 'nullable|string|max:255|unique:rate_types,slug', // ✅ Added slug
            'status' => 'required|in:active,inactive'
        ]);
        
        RateType::create($request->only('name', 'slug', 'status')); // ✅ Added slug
        
        return redirect()->route('rate-types.index')->with('success', 'Rate type created successfully!'); // ✅ Added admin prefix
    }

    public function edit(RateType $rateType)
    {
        return view('admin.pages.rate-types.edit', compact('rateType')); // ✅ Fixed: added .pages.
    }

    public function update(Request $request, RateType $rateType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rate_types,name,' . $rateType->id,
            'slug' => 'nullable|string|max:255|unique:rate_types,slug,' . $rateType->id, // ✅ Added slug
            'status' => 'required|in:active,inactive'
        ]);
        
        $rateType->update($request->only('name', 'slug', 'status')); // ✅ Added slug
        
        return redirect()->route('rate-types.index')->with('success', 'Rate type updated successfully!'); // ✅ Added admin prefix
    }

    public function destroy(RateType $rateType)
    {
        $rateType->delete();
        return redirect()->route('rate-types.index')->with('success', 'Rate type deleted successfully!'); // ✅ Added admin prefix
    }

    public function toggleStatus(RateType $rateType)
    {
        $rateType->status = $rateType->status === 'active' ? 'inactive' : 'active';
        $rateType->save();
        
        return back()->with('success', 'Status updated successfully!');
    }
}