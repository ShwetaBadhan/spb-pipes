<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmailTemplateController extends Controller
{
    public function index(Request $request)
    {
        // Initialize defaults if not exist
        EmailTemplate::initializeDefaults();
        
        $query = EmailTemplate::query();
        
        // Server-side search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        $templates = $query->latest()->get();
        $categories = EmailTemplate::select('category')->distinct()->pluck('category')->filter();
        
        return view('admin.pages.settings.system-settings.email-templates', compact('templates', 'categories'));
    }

    public function store(Request $request)
{
    // Convert comma-separated string to array
    $variables = $request->input('variables');
    $variablesArray = [];
    
    if (!empty($variables) && is_string($variables)) {
        $variablesArray = array_map('trim', explode(',', $variables));
        $variablesArray = array_filter($variablesArray); // Remove empty values
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'nullable|string|max:255|unique:email_templates,slug',
        'subject' => 'required|string|max:500',
        'body' => 'required|string',
        'category' => 'nullable|string|in:transactional,marketing,system',
        // Remove 'variables' from validation since we handle it manually
        'is_active' => 'nullable|boolean',
    ]);

    // Auto-generate slug if not provided
    if (empty($validated['slug'])) {
        $validated['slug'] = Str::slug($validated['name']);
    }

    EmailTemplate::create([
        'name' => $validated['name'],
        'slug' => $validated['slug'],
        'subject' => $validated['subject'],
        'body' => $validated['body'],
        'category' => $validated['category'] ?? 'transactional',
        'variables' => $variablesArray, // Save as array
        'is_active' => $request->has('is_active'),
    ]);

    return redirect()->back()->with('success', 'Email template created successfully!');
}

public function update(Request $request, $id)
{
    $template = EmailTemplate::findOrFail($id);

    // Convert comma-separated string to array
    $variables = $request->input('variables');
    $variablesArray = [];
    
    if (!empty($variables) && is_string($variables)) {
        $variablesArray = array_map('trim', explode(',', $variables));
        $variablesArray = array_filter($variablesArray);
    }

    $validated = $request->validate([
        'name' => "required|string|max:255",
        'slug' => "nullable|string|max:255|unique:email_templates,slug,{$id}",
        'subject' => 'required|string|max:500',
        'body' => 'required|string',
        'category' => 'nullable|string|in:transactional,marketing,system',
        // Remove 'variables' from validation since we handle it manually
        'is_active' => 'nullable|boolean',
    ]);

    // Auto-generate slug if not provided
    if (empty($validated['slug'])) {
        $validated['slug'] = Str::slug($validated['name']);
    }

    $template->update([
        'name' => $validated['name'],
        'slug' => $validated['slug'],
        'subject' => $validated['subject'],
        'body' => $validated['body'],
        'category' => $validated['category'] ?? $template->category,
        'variables' => $variablesArray, // Save as array
        'is_active' => $request->has('is_active'),
    ]);

    return redirect()->back()->with('success', 'Email template updated successfully!');
}

    public function destroy($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $template->delete();

        return redirect()->back()->with('success', 'Email template deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $template->update(['is_active' => !$template->is_active]);

        $status = $template->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Template {$status}!");
    }

    // In EmailTemplateController.php

public function preview($id)
    {
        $template = EmailTemplate::findOrFail($id);
        
        // Sample data for preview
        $sampleData = [
            'Customer Name' => 'John Doe',
            'Company Name' => 'Your Company',
            'Booking Number' => 'BK123456',
            'Booking Date' => '25 Mar 2024',
            'Car Name' => 'Toyota Camry',
            'Pickup Location' => 'Airport Terminal 1',
            'Pickup Date' => '01 Apr 2024',
            'Rental Price' => '$299.99',
            'Website URL' => 'https://yourcompany.com',
            'Discount Code' => 'WELCOME20',
        ];
        
        $rendered = $template->render($sampleData);
        
        return view('admin.pages.settings.system-settings.email-template-preview', compact('template', 'rendered'));
    }
}