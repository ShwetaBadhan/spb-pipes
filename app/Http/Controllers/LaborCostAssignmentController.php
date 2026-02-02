<?php

namespace App\Http\Controllers;

use App\Models\LaborCostAssignment;
use App\Models\LaborType;
use App\Models\Product; // Update with your actual Product model
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LaborCostAssignmentController extends Controller
{
    /**
     * Display a listing of labor cost assignments
     */
   public function index(Request $request)
{
    try {
        // ✅ Debug: Check if method is called
        // \Log::info('LaborCostAssignmentController@index called');

        $query = LaborCostAssignment::with(['laborType', 'product', 'supervisor'])
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc');

        $perPage = $request->get('per_page', 15);
        $assignments = $query->paginate($perPage);

        // \Log::info('Assignments fetched: ' . $assignments->count());

        // Dropdown options
        $laborTypes = LaborType::where('status', 'active')->get();
        // \Log::info('LaborTypes fetched: ' . $laborTypes->count());

        $products = Product::where('status', 1)->orderBy('name')->get();
        // \Log::info('Products fetched: ' . $products->count());

        // ✅ CORRECT (use Spatie's role() method properly)
$supervisors = User::role(['supervisor'])->get();
        // \Log::info('Supervisors fetched: ' . $supervisors->count());

        // ✅ Return view
        return view('admin.pages.labor-cost-assignments.index', [
            'assignments' => $assignments,
            'laborTypes' => $laborTypes,
            'products' => $products,
            'supervisors' => $supervisors,
            'filters' => $request->all(),
        ]);

    } catch (\Exception $e) {
        // \Log::error('LaborCostAssignment index error: ' . $e->getMessage());
        // \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        // ✅ Debug: Don't redirect, show error
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ], 500);
    }
}

    /**
     * Store a newly created labor cost assignment
     */
    public function store(Request $request)
    {
        try {
            $validated = $this->validateRequest($request);

            $assignment = LaborCostAssignment::create([
                'date' => $validated['date'],
                'labor_type_id' => $validated['labor_type_id'],
                'product_id' => $validated['product_id'],
                'batch_number' => $validated['batch_number'] ?? null,
                'quantity' => $validated['quantity'],
                'rate_amount' => $validated['rate_amount'],
                'total_cost' => $validated['quantity'] * $validated['rate_amount'],
                'supervisor_id' => $validated['supervisor_id'] ?? null,
                'workers_count' => $validated['workers_count'] ?? 1,
                'shift' => $validated['shift'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'created_by' => Auth::id(),
            ]);

            return redirect()->back()->with('success', 'Labor cost assigned successfully');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // \Log::error('LaborCostAssignment store error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error assigning labor cost')->withInput();
        }
    }

    /**
     * Display the specified labor cost assignment
     */
    public function show($id)
{
    try {
       $assignment = LaborCostAssignment::with(['laborType', 'product', 'supervisor', 'createdBy'])
            ->findOrFail($id);
        
        // Use append to add formatted date
        $assignment->append('formatted_date');
        
        return response()->json([
            'success' => true,
            'data' => $assignment,
            'message' => 'Labor cost assignment retrieved successfully'
        ], 200);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Labor cost assignment not found'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error retrieving labor cost assignment',
            'error' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Update the specified labor cost assignment
     */
    public function update(Request $request, $id)
    {
        try {
            $assignment = LaborCostAssignment::findOrFail($id);
            $validated = $this->validateRequest($request, $id);

            $assignment->update([
                'date' => $validated['date'],
                'labor_type_id' => $validated['labor_type_id'],
                'product_id' => $validated['product_id'],
                'batch_number' => $validated['batch_number'] ?? null,
                'quantity' => $validated['quantity'],
                'rate_amount' => $validated['rate_amount'],
                'total_cost' => $validated['quantity'] * $validated['rate_amount'],
                'supervisor_id' => $validated['supervisor_id'] ?? null,
                'workers_count' => $validated['workers_count'] ?? 1,
                'shift' => $validated['shift'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            return redirect()->back()->with('success', 'Labor cost assignment updated successfully');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Labor cost assignment not found');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // \Log::error('LaborCostAssignment update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating labor cost assignment')->withInput();
        }
    }

    /**
     * Remove the specified labor cost assignment
     */
    public function destroy($id)
    {
        try {
            $assignment = LaborCostAssignment::findOrFail($id);
            $assignment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Labor cost assignment deleted successfully'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Labor cost assignment not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting labor cost assignment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get labor type details (for auto-fill in form)
     */
    public function getLaborTypeDetails($id)
    {
        try {
            $laborType = LaborType::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'rate_amount' => $laborType->rate_amount,
                    'category' => $laborType->category,
                    'unit_id' => $laborType->unit_id,
                    'work_type_id' => $laborType->work_type_id,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving labor type details',
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
            'date' => 'required|date',
            'labor_type_id' => 'required|exists:labor_types,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0.01',
            'rate_amount' => 'required|numeric|min:0.01',
            'batch_number' => 'nullable|string|max:100',
            'supervisor_id' => 'nullable|exists:users,id',
            'workers_count' => 'nullable|integer|min:1',
            'shift' => 'nullable|in:morning,evening,night',
            'notes' => 'nullable|string',
        ];

        return $request->validate($rules);
    }
}