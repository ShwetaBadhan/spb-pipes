<?php

namespace App\Http\Controllers;

use App\Models\LaborType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LaborTypeController extends Controller
{
    /**
     * Display a listing of labor types with optional filters and pagination.
     */
    public function index(Request $request)
{
    try {
        $query = LaborType::query();

        // Apply filters
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        if ($request->has('rate_type') && $request->rate_type) {
            $query->where('rate_type', $request->rate_type);
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
        
        if (in_array($sortBy, ['name', 'code', 'category', 'rate_type', 'status', 'sort_order', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $laborTypes = $query->paginate($perPage);

        // **Return Blade view instead of JSON**
        return view('admin.pages.labor-types.index', [
            'laborTypes' => $laborTypes,
            'filters' => $request->all(), // optional: pass filters to view
        ]);

    } catch (\Exception $e) {
        // optional: show error page instead of JSON
        return redirect()->back()->with('error', 'Error retrieving labor types: '.$e->getMessage());
    }
}


    /**
     * Store a newly created labor type in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->validateRequest($request);

            $laborType = DB::transaction(function () use ($validatedData) {
                return LaborType::create($validatedData);
            });

            return response()->json([
                'success' => true,
                'data' => $laborType,
                'message' => 'Labor type created successfully'
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating labor type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified labor type.
     */
    public function show($id)
    {
        try {
            $laborType = LaborType::withTrashed()->findOrFail($id);

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
     * Update the specified labor type in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $laborType = LaborType::findOrFail($id);
            
            $validatedData = $this->validateRequest($request, $id);

            $laborType->update($validatedData);

            return response()->json([
                'success' => true,
                'data' => $laborType->fresh(),
                'message' => 'Labor type updated successfully'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Labor type not found'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating labor type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified labor type from storage (soft delete).
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
     * Restore a soft-deleted labor type.
     */
    public function restore($id)
    {
        try {
            $laborType = LaborType::withTrashed()->findOrFail($id);
            $laborType->restore();

            return response()->json([
                'success' => true,
                'data' => $laborType,
                'message' => 'Labor type restored successfully'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Labor type not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error restoring labor type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Permanently delete a labor type.
     */
    public function forceDelete($id)
    {
        try {
            $laborType = LaborType::withTrashed()->findOrFail($id);
            $laborType->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Labor type permanently deleted'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Labor type not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error permanently deleting labor type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle status of a labor type (active/inactive).
     */
    public function toggleStatus($id)
    {
        try {
            $laborType = LaborType::findOrFail($id);
            
            if ($laborType->toggleStatus()) {
                return response()->json([
                    'success' => true,
                    'data' => $laborType->fresh(),
                    'message' => 'Labor type status updated successfully'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to update labor type status'
            ], 500);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Labor type not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating labor type status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Activate a labor type.
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
     * Deactivate a labor type.
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
     * Get all active labor types for dropdown/select.
     */
    public function getActiveLaborTypes()
    {
        try {
            $laborTypes = LaborType::where('status', 'active')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(['id', 'name', 'code', 'category', 'rate_type', 'rate_amount', 'status']);

            return response()->json([
                'success' => true,
                'data' => $laborTypes,
                'message' => 'Active labor types retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving active labor types',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get labor type options for dropdowns.
     */
    public function getOptions()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => [
                    'statuses' => LaborType::getStatuses(),
                    'categories' => LaborType::getCategories(),
                    'rate_types' => LaborType::getRateTypes(),
                    'unit_types' => LaborType::getUnitTypes(),
                    'work_types' => LaborType::getWorkTypes()
                ],
                'message' => 'Options retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving options',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get validation rules for store and update requests.
     */
    private function validateRequest(Request $request, $id = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:labor_types,code' . ($id ? ",$id" : ''),
            'category' => 'required|in:production,logistics',
            'rate_type' => 'required|in:per_unit,per_truck,per_hour,per_batch,per_worker',
            'rate_amount' => 'required|numeric|min:0|max:99999999.99',
            'unit_type' => 'nullable|in:tile,pipe,batch,other',
            'work_type' => 'nullable|in:loading,unloading,both,none',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'integer|min:0'
        ];

        // Conditional validation based on category
        if ($request->category === 'production') {
            $rules['unit_type'] = 'required|in:tile,pipe,batch,other';
            $rules['work_type'] = 'nullable|in:none';
        } elseif ($request->category === 'logistics') {
            $rules['work_type'] = 'required|in:loading,unloading,both';
            $rules['unit_type'] = 'nullable|in:none';
        }

        // Auto-sync is_active with status
        $validated = $request->validate($rules);
        
        // Ensure is_active is synchronized with status
        $validated['is_active'] = $validated['status'] === 'active';

        return $validated;
    }
}