<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.pages.category', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:100|unique:categories,name',
        'slug' => 'nullable|string|max:120|unique:categories,slug',
        'is_active' => 'required|in:0,1',
    ]);

    Category::create([
        'name' => $request->name,
        // AUTO slug from name
        'slug' => Str::slug($request->name),
        'is_active' => $request->is_active,
    ]);

    return redirect()
        ->route('category')
        ->with('success', 'Category added successfully.');
}


    public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
        'slug' => 'nullable|string|max:120|unique:categories,slug,' . $category->id,
        'is_active' => 'required|in:0,1',
    ]);

    $category->update([
        'name' => $request->name,
        // regenerate slug if name changes
        'slug' => Str::slug($request->name),
        'is_active' => $request->is_active,
    ]);

    return redirect()
        ->route('category')
        ->with('success', 'Category updated successfully.');
}


    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('category')
            ->with('success', value: 'Category deleted successfully.');
    }
}
