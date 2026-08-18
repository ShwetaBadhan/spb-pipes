<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\Tenant;
use App\Models\User;
use App\Models\CentralAdmin;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('subscription_status', 'active')->count();
        $trialTenants = Tenant::where('subscription_status', 'trialing')->count();
        $suspendedTenants = Tenant::where('is_suspended', true)->count();
        $canceledTenants = Tenant::where('subscription_status', 'canceled')->count();
        $newThisMonth = Tenant::where('created_at', '>=', $startOfMonth)->count();
        $newLastMonth = Tenant::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        $activeSubscriptions = Subscription::whereIn('status', [Subscription::STATUS_TRIALING, Subscription::STATUS_ACTIVE])->count();

        $mrr = Subscription::whereIn('status', [Subscription::STATUS_ACTIVE])
            ->with('plan')
            ->get()
            ->sum(function ($sub) {
                $price = $sub->plan?->price ?? 0;
                return $sub->plan?->billing_period === 'yearly' ? round($price / 12, 2) : $price;
            });

        $arr = round($mrr * 12, 2);

        $trialStartedThisMonth = Tenant::where('subscription_status', 'trialing')
            ->where('created_at', '>=', $startOfMonth)
            ->count();
        $convertedFromTrial = Subscription::where('status', Subscription::STATUS_ACTIVE)
            ->where('created_at', '>=', $startOfMonth)
            ->whereNotNull('cancelled_at')
            ->count();
        $trialConversionRate = $trialStartedThisMonth > 0
            ? round(($convertedFromTrial / max($trialStartedThisMonth, 1)) * 100, 1)
            : 0;

        $canceledThisMonth = Subscription::where('status', Subscription::STATUS_CANCELED)
            ->where('cancelled_at', '>=', $startOfMonth)
            ->count();
        $totalAtStartOfMonth = Tenant::where('created_at', '<', $startOfMonth)->count();
        $churnRate = $totalAtStartOfMonth > 0
            ? round(($canceledThisMonth / $totalAtStartOfMonth) * 100, 1)
            : 0;

        $failedPayments = SubscriptionPayment::where('status', SubscriptionPayment::STATUS_FAILED)->count();

        $outstandingRevenue = Subscription::whereIn('status', [Subscription::STATUS_ACTIVE, Subscription::STATUS_PAST_DUE])
            ->with('plan')
            ->get()
            ->sum(function ($sub) {
                $amount = $sub->amount();
                $lastPaid = $sub->payments()->where('status', SubscriptionPayment::STATUS_PAID)->latest()->first();
                if ($lastPaid && $lastPaid->paid_at && $lastPaid->paid_at->gte(now()->subDays(30))) {
                    return 0;
                }
                return $amount;
            });

        $stats = [
            'total_tenants' => $totalTenants,
            'active_tenants' => $activeTenants,
            'trial_tenants' => $trialTenants,
            'suspended_tenants' => $suspendedTenants,
            'canceled_tenants' => $canceledTenants,
            'new_this_month' => $newThisMonth,
            'new_last_month' => $newLastMonth,
            'mrr' => $mrr,
            'arr' => $arr,
            'active_subscriptions' => $activeSubscriptions,
            'trial_conversion_rate' => $trialConversionRate,
            'churn_rate' => $churnRate,
            'failed_payments' => $failedPayments,
            'outstanding_revenue' => $outstandingRevenue,
            'plans' => Plan::active()->ordered()->count(),
        ];

        $recentTenants = Tenant::with(['domains', 'plan', 'activeSubscription'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return view('central.dashboard', compact('stats', 'recentTenants'));
    }
}
