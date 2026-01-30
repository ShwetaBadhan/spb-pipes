<?php

namespace App\Http\Controllers;

use App\Models\LaborType;
use App\Models\WorkType;
use App\Models\RateType;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LaborTypeController extends Controller
{
    /**
 * Auto-generate labor type code
 */
public function generateCode(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255'
    ]);

    $name = $request->name;
    $code = $this->generateUniqueCode($name);

    return response()->json([
        'success' => true,
        'code' => $code
    ]);
}

/**
 * Generate unique code: First 4 letters + Series from 5100
 */
private function generateUniqueCode($name)
{
    // Get first 4 letters of name (uppercase, remove special chars)
    $prefix = strtoupper(preg_replace('/[^A-Za-z]/', '', $name));
    $prefix = substr($prefix, 0, 4);
    
    // If prefix is less than 4 letters, pad with 'LAB'
    if (strlen($prefix) < 4) {
        $prefix = str_pad($prefix, 4, 'L', STR_PAD_RIGHT);
    }
    
    // Start series from 5100
    $baseNumber = 5100;
    $counter = 0;
    
    // Find next available code
    do {
        $code = $prefix . ($baseNumber + $counter);
        $exists = LaborType::where('code', $code)->exists();
        $counter++;
    } while ($exists && $counter < 10000); // Safety limit
    
    return $code;
}
    /**
     * Display a listing of labor types
     */
    public function index(Request $request)
    {
        try {
            // ✅ Correct: query() first, then with()
            $query = LaborType::query()->with(['rateType', 'unit', 'workType']);

            // Apply filters
            if ($request->has('category') && $request->category) {
                $query->where('category', $request->category);
            }

            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            if ($request->has('is_active')) {
                $query->where('is_active', $request->is_active);
            }

            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // Sorting
            $sortBy = $request->get('sort_by', 'sort_order');
            $sortOrder = $request->get('sort_order', 'asc');
            
            if (in_array($sortBy, ['name', 'code', 'category', 'status', 'sort_order', 'created_at'])) {
                $query->orderBy($sortBy, $sortOrder);
            }

            // Pagination
            $perPage = $request->get('per_page', 15);
            $laborTypes = $query->paginate($perPage);

            // ✅ Fetch dropdown options WITHOUT is_active filter
            $workTypes = WorkType::orderBy('name')->get(['id', 'name']);
            $rateTypes = RateType::orderBy('name')->get(['id', 'name']);
            $units = Unit::orderBy('name')->get(['id', 'name']);

            // ✅ Return VIEW
            return view('admin.pages.labor-types.index', [
                'laborTypes' => $laborTypes,
                'workTypes' => $workTypes,
                'rateTypes' => $rateTypes,
                'units' => $units,
            ]);

        } catch (\Exception $e) {
           
            return redirect()->route('dashboard')->with('error', 'Error loading labor types: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created labor type
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->validateRequest($request);

            $laborType = DB::transaction(function () use ($validatedData) {
                return LaborType::create($validatedData);
            });

            return redirect()->back()->with('success', 'Labor type created successfully');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
         
            return redirect()->back()->with('error', 'Error creating labor type: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified labor type
     */
    public function show($id)
    {
        try {
            $laborType = LaborType::with(['rateType', 'unit', 'workType'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $laborType,
                'message' => 'Labor type retrieved successfully'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Labor type not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving labor type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified labor type
     */
    public function update(Request $request, $id)
    {
        try {
            $laborType = LaborType::findOrFail($id);
            
            $validatedData = $this->validateRequest($request, $id);

            $laborType->update($validatedData);

            return redirect()->back()->with('success', 'Labor type updated successfully');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Labor type not found');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
          
            return redirect()->back()->with('error', 'Error updating labor type: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified labor type (soft delete)
     */
    public function destroy($id)
    {
        try {
            $laborType = LaborType::findOrFail($id);
            $laborType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Labor type deleted successfully'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Labor type not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting labor type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Activate a labor type
     */
    public function activate($id)
    {
        try {
            $laborType = LaborType::findOrFail($id);
            
            if ($laborType->activate()) {
                return response()->json([
                    'success' => true,
                    'data' => $laborType->fresh(),
                    'message' => 'Labor type activated successfully'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to activate labor type'
            ], 500);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Labor type not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error activating labor type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Deactivate a labor type
     */
    public function deactivate($id)
    {
        try {
            $laborType = LaborType::findOrFail($id);
            
            if ($laborType->deactivate()) {
                return response()->json([
                    'success' => true,
                    'data' => $laborType->fresh(),
                    'message' => 'Labor type deactivated successfully'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to deactivate labor type'
            ], 500);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Labor type not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deactivating labor type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get validation rules
     */
    private function validateRequest(Request $request, $id = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:labor_types,code' . ($id ? ",$id" : ''),
            'category' => 'required|in:production,logistics',
            'rate_type_id' => 'required|exists:rate_types,id',
            'rate_amount' => 'required|numeric|min:0',
            'unit_id' => 'nullable|exists:units,id',
            'work_type_id' => 'nullable|exists:work_types,id',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0'
        ];

        if ($request->category === 'production') {
            $rules['unit_id'] = 'required|exists:units,id';
            $rules['work_type_id'] = 'nullable';
        } elseif ($request->category === 'logistics') {
            $rules['work_type_id'] = 'required|exists:work_types,id';
            $rules['unit_id'] = 'nullable';
        }

        $validated = $request->validate($rules);
        $validated['is_active'] = ($validated['status'] === 'active');

        return $validated;
    }
}