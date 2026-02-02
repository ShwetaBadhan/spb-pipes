<?php

namespace App\Http\Controllers;

use App\Models\LaborCostAssignment;
use App\Models\LaborType;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // ✅ Import PDF facade
use App\Exports\LaborCostReportExport; // For Excel export
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\DB; // Add this line
use Illuminate\Support\Facades\Facade;

class LaborCostReportController extends Controller
{
    public function index()
    {
        $laborTypes = LaborType::where('status', 'active')->get();
        $products = Product::where('status', 1)->orderBy('name')->get();

        return view('admin.pages.labor-cost-reports.index', [
            'laborTypes' => $laborTypes,
            'products' => $products,
        ]);
    }
// app/Http/Controllers/LaborCostReportController.php

/**
     * Export report to PDF
     */
    public function exportPdf(Request $request)
    {
        try {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'report_type' => 'required|in:summary,detailed,category-wise,product-wise,labor-type-wise',
            ]);

            $data = $this->generateReportData(
                $request->start_date,
                $request->end_date,
                $request->report_type,
                $request
            );

            // ✅ Generate PDF and force download
            $pdf = Pdf::loadView('admin.pages.labor-cost-reports.pdf', [
                'data' => $data,
                'startDate' => $request->start_date,
                'endDate' => $request->end_date,
                'reportType' => $request->report_type,
            ]);

            // Set paper size and orientation
            $pdf->setPaper('a4', 'portrait');

            // ✅ Force download with filename
            return $pdf->download('labor-cost-report-' . date('Y-m-d') . '.pdf');

        } catch (\Exception $e) {
            // \Log::error('LaborCostReport PDF export error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error exporting PDF: ' . $e->getMessage());
        }
    }

    /**
     * Export report to Excel
     */
    public function exportExcel(Request $request)
    {
        try {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'report_type' => 'required|in:summary,detailed,category-wise,product-wise,labor-type-wise',
            ]);

            $filters = $request->all();

            return Excel::download(
                new LaborCostReportExport($request->start_date, $request->end_date, $filters),
                'labor-cost-report-' . date('Y-m-d') . '.xlsx'
            );

        } catch (\Exception $e) {
            // \Log::error('LaborCostReport Excel export error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error exporting Excel: ' . $e->getMessage());
        }
    }
    public function generate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'report_type' => 'required|in:summary,detailed,category-wise,product-wise,labor-type-wise',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $reportType = $request->report_type;

        $data = $this->generateReportData($startDate, $endDate, $reportType, $request);

        return view('admin.pages.labor-cost-reports.generate', [
            'data' => $data,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'reportType' => $reportType,
            'filters' => $request->all(),
        ]);
    }


    private function generateReportData($startDate, $endDate, $reportType, $request)
    {
        $query = LaborCostAssignment::with(['laborType', 'product', 'supervisor'])
            ->whereBetween('date', [$startDate, $endDate]);

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

        switch ($reportType) {
            case 'summary':
                return $this->generateSummaryReport($query, $startDate, $endDate);

            case 'detailed':
                $records = $query->orderBy('date', 'desc')->get();
                return [
                    'type' => 'detailed',
                    'records' => $records,
                    'summary' => [
                        'total_cost' => $records->sum('total_cost'),
                        'total_assignments' => $records->count(),
                        'total_quantity' => $records->sum('quantity'),
                    ],
                ];

            case 'category-wise':
                $categories = $query->clone()
                    ->selectRaw('labor_types.category, SUM(labor_cost_assignments.total_cost) as total_cost')
                    ->join('labor_types', 'labor_cost_assignments.labor_type_id', '=', 'labor_types.id')
                    ->groupBy('labor_types.category')
                    ->get();
                return ['type' => 'category-wise', 'categories' => $categories];

            case 'product-wise':
                $products = $query->clone()
                    ->select('product_id', DB::raw('SUM(total_cost) as total_cost'), DB::raw('SUM(quantity) as total_quantity'))
                    ->groupBy('product_id')
                    ->with(['product'])
                    ->orderBy('total_cost', 'desc')
                    ->get();
                return [
                    'type' => 'product-wise',
                    'products' => $products,
                    'total_cost' => $products->sum('total_cost'),
                ];

            case 'labor-type-wise':
                $laborTypes = $query->clone()
                    ->select('labor_type_id', DB::raw('SUM(total_cost) as total_cost'), DB::raw('SUM(quantity) as total_quantity'))
                    ->groupBy('labor_type_id')
                    ->with(['laborType'])
                    ->orderBy('total_cost', 'desc')
                    ->get();
                return [
                    'type' => 'labor-type-wise',
                    'labor_types' => $laborTypes,
                    'total_cost' => $laborTypes->sum('total_cost'),
                ];

            default:
                return $this->generateSummaryReport($query, $startDate, $endDate);
        }
    }

    private function generateSummaryReport($query, $startDate, $endDate)
    {
        $totalCost = $query->clone()->sum('total_cost');
        $totalAssignments = $query->clone()->count();
        $totalQuantity = $query->clone()->sum('quantity');

        $productionCost = $query->clone()
            ->whereHas('laborType', function ($q) {
                $q->where('category', 'production');
            })->sum('total_cost');

        $logisticsCost = $query->clone()
            ->whereHas('laborType', function ($q) {
                $q->where('category', 'logistics');
            })->sum('total_cost');

        $dailyAverage = $totalCost / max(1, $this->getDaysBetween($startDate, $endDate));

        $topLaborTypes = $query->clone()
            ->select('labor_type_id', DB::raw('SUM(total_cost) as total_cost'), DB::raw('COUNT(*) as assignments_count'))
            ->groupBy('labor_type_id')
            ->with(['laborType'])
            ->orderBy('total_cost', 'desc')
            ->limit(5)
            ->get();

        $topProducts = $query->clone()
            ->select('product_id', DB::raw('SUM(total_cost) as total_cost'), DB::raw('COUNT(*) as assignments_count'))
            ->groupBy('product_id')
            ->with(['product'])
            ->orderBy('total_cost', 'desc')
            ->limit(5)
            ->get();


        return [
            'type' => 'summary',
            'total_cost' => $totalCost,
            'total_assignments' => $totalAssignments,
            'total_quantity' => $totalQuantity,
            'production_cost' => $productionCost,
            'logistics_cost' => $logisticsCost,
            'daily_average' => $dailyAverage,
            'top_labor_types' => $topLaborTypes,
            'top_products' => $topProducts,
        ];
    }
// app/Http/Controllers/LaborCostReportController.php

private function generateCategoryWiseReport($query)
{
    $categories = $query->clone()
        ->selectRaw('labor_types.category, SUM(labor_cost_assignments.total_cost) as total_cost')
        ->join('labor_types', 'labor_cost_assignments.labor_type_id', '=', 'labor_types.id')
        ->groupBy('labor_types.category')
        ->get();

    // ✅ Calculate total cost for percentage calculation
    $totalCost = $categories->sum('total_cost');

    // ✅ Get production and logistics costs separately
    $productionCost = $categories->firstWhere('category', 'production')?->total_cost ?? 0;
    $logisticsCost = $categories->firstWhere('category', 'logistics')?->total_cost ?? 0;

    return [
        'type' => 'category-wise',
        'categories' => $categories,
        'total_cost' => $totalCost,           // ✅ Add this
        'production_cost' => $productionCost,  // ✅ Add this  
        'logistics_cost' => $logisticsCost,    // ✅ Add this
    ];
}
    private function getDaysBetween($startDate, $endDate)
    {
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        return $start->diffInDays($end) + 1;
    }
}
