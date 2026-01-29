<?php

namespace App\Http\Controllers;

use App\Models\WorkType;
use Illuminate\Http\Request;

class WorkTypeController extends Controller
{
    public function index(Request $request)
    {
        $workTypes = WorkType::when($request->status, fn($q) => $q->where('status', $request->status))
                             ->latest()
                             ->paginate(15);

        return view('admin.pages.work-types', compact('workTypes')); // ✅ lowercase 'workTypes'
    }

    public function create()
    {
        return view('admin.pages.work-types.create'); // ✅ create.blade.php separate file
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:work_types,name', // ✅ work_types not rate_types
            'slug' => 'nullable|string|max:255|unique:work_types,slug', // ✅ added slug
            'status' => 'required|in:active,inactive'
        ]);
        
        WorkType::create($request->only('name', 'slug', 'status')); // ✅ added slug
        
        return redirect()->route('work-types.index')->with('success', 'Work type created successfully!'); // ✅ admin prefix
    }

    public function edit(WorkType $workType) // ✅ lowercase parameter
    {
        return view('admin.pages.work-types.edit', compact('workType')); // ✅ lowercase + separate edit file
    }

    public function update(Request $request, WorkType $workType)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:work_types,name,' . $workType->id,
        'slug' => 'nullable|string|max:255|unique:work_types,slug,' . $workType->id,
        'status' => 'required|in:active,inactive'
    ]);

    $workType->update($request->only('name', 'slug', 'status'));

    // ✅ Correct route name use karo
    return redirect()
        ->route('work-types.index') // Change this to your actual route name
        ->with('success', 'Work type updated successfully!');
}

    public function destroy(WorkType $workType) // ✅ lowercase parameter
    {
        $workType->delete();
        return redirect()->route('work-types.index')->with('success', 'Work type deleted successfully!'); // ✅ admin prefix
    }

    public function toggleStatus(WorkType $workType) // ✅ lowercase parameter
    {
        $workType->status = $workType->status === 'active' ? 'inactive' : 'active';
        $workType->save();
        
        return back()->with('success', 'Status updated successfully!');
    }
}