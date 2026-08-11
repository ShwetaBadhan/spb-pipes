<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BillingInvoice;
use App\Models\Subscription;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $sixMonths = collect(range(5, 0))->map(function (int $offset) {
            $month = Carbon::now()->subMonths($offset);
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();

            $revenue = (float) BillingInvoice::where('status', 'paid')
                ->whereBetween('invoice_date', [$start, $end])
                ->sum('amount');

            $subscriptions = Subscription::with('plan')->get();

            return [
                'label' => $month->format('M Y'),
                'mrr' => (float) $subscriptions
                    ->where('status', 'active')
                    ->filter(fn ($s) => $s->created_at <= $end && (! $s->ends_at || $s->ends_at >= $start))
                    ->sum(fn ($s) => (float) ($s->plan?->price_monthly ?? 0)),
                'revenue' => $revenue,
                'new_tenants' => Tenant::whereBetween('created_at', [$start, $end])->count(),
                'churned' => $subscriptions
                    ->where('status', 'canceled')
                    ->filter(fn ($s) => $s->updated_at->between($start, $end))
                    ->count(),
            ];
        });

        $totals = [
            'tenants' => Tenant::count(),
            'active' => Tenant::where('status', 'active')->count(),
            'trial' => Tenant::where('status', 'trial')->count(),
            'suspended' => Tenant::where('status', 'suspended')->count(),
        ];

        return view('super-admin.reports.index', compact('sixMonths', 'totals'));
    }
}
