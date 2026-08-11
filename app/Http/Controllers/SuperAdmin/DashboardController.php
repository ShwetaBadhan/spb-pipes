<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BillingInvoice;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $mrr = (float) Subscription::where('status', 'active')->with('plan')->get()
            ->sum(fn ($s) => (float) ($s->plan?->price_monthly ?? 0));

        $activeTenants = Tenant::where('status', 'active')->count();
        $totalSubscriptions = Subscription::count();
        $churned = Subscription::where('status', 'canceled')->count();

        $stats = [
            'tenants' => Tenant::count(),
            'active_tenants' => $activeTenants,
            'trial_tenants' => Tenant::where('status', 'trial')->count(),
            'suspended_tenants' => Tenant::where('status', 'suspended')->count(),
            'plans' => Plan::count(),
            'subscriptions' => $totalSubscriptions,
            'mrr' => $mrr,
            'revenue' => (float) BillingInvoice::where('status', 'paid')->sum('amount'),
            'arpu' => $activeTenants > 0 ? $mrr / $activeTenants : 0.0,
            'churn_rate' => $totalSubscriptions > 0 ? round($churned / $totalSubscriptions * 100, 1) : 0.0,
        ];

        $mrrTrend = collect(range(5, 0))->map(function (int $offset) {
            $month = Carbon::now()->subMonths($offset);
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();

            $subscriptions = Subscription::with('plan')->get();

            return [
                'label' => $month->format('M y'),
                'mrr' => (float) $subscriptions
                    ->where('status', 'active')
                    ->filter(fn ($s) => $s->created_at <= $end && (! $s->ends_at || $s->ends_at >= $start))
                    ->sum(fn ($s) => (float) ($s->plan?->price_monthly ?? 0)),
                'churned' => $subscriptions
                    ->where('status', 'canceled')
                    ->filter(fn ($s) => $s->updated_at->between($start, $end))
                    ->count(),
            ];
        });

        $recentTenants = Tenant::latest()->take(8)->get();

        return view('super-admin.dashboard', compact('stats', 'mrrTrend', 'recentTenants'));
    }
}
