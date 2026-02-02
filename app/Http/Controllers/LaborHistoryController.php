<?php

namespace App\Http\Controllers;

use App\Models\LaborCostAssignment;
use App\Models\LaborType;
use App\Models\Product;
use Illuminate\Http\Request;

class LaborHistoryController extends Controller
{
    public function index(Request $request)
    {
        // Date range filter
        $startDate = $request->get('start_date', now()->subMonths(3)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $query = LaborCostAssignment::with(['laborType', 'product', 'supervisor'])
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc');

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->whereHas('laborType', function ($q) use ($request) {
                $q->where('category', $request->category);
            });
        }

        // Labor type filter
        if ($request->has('labor_type_id') && $request->labor_type_id) {
            $query->where('labor_type_id', $request->labor_type_id);
        }

        // Product filter
        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('batch_number', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 25);
        $history = $query->paginate($perPage);

        // Summary statistics
        $summary = $this->getSummary($startDate, $endDate, $request);

        // Dropdown options
        $laborTypes = LaborType::where('status', 'active')->get();
        $products = Product::where('status', 1)->orderBy('name')->get();

        return view('admin.pages.labor-history.index', [
            'history' => $history,
            'summary' => $summary,
            'laborTypes' => $laborTypes,
            'products' => $products,
            'filters' => $request->all(),
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function export(Request $request)
    {
        return redirect()->back()->with('info', 'Export feature coming soon');
    }

    private function getSummary($startDate, $endDate, $request)
    {
        $query = LaborCostAssignment::whereBetween('date', [$startDate, $endDate]);

        if ($request->has('category') && $request->category) {
            $query->whereHas('laborType', function ($q) use ($request) {
                $q->where('category', $request->category);
            });
        }

        if ($request->has('labor_type_id') && $request->labor_type_id) {
            $query->where('labor_type_id', $request->labor_type_id);
        }

        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        $totalCost = $query->sum('total_cost');
        $totalAssignments = $query->count();
        $totalQuantity = $query->sum('quantity');

        $productionCost = $query->clone()
            ->whereHas('laborType', function ($q) {
                $q->where('category', 'production');
            })->sum('total_cost');

        $logisticsCost = $query->clone()
            ->whereHas('laborType', function ($q) {
                $q->where('category', 'logistics');
            })->sum('total_cost');

        return [
            'total_cost' => $totalCost,
            'total_assignments' => $totalAssignments,
            'total_quantity' => $totalQuantity,
            'production_cost' => $productionCost,
            'logistics_cost' => $logisticsCost,
            'average_cost_per_assignment' => $totalAssignments > 0 ? ($totalCost / $totalAssignments) : 0,
        ];
    }
}