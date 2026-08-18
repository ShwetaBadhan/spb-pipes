<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class DashboardChartController extends Controller
{
    public function data(string $chart): JsonResponse
    {
        return match ($chart) {
            'tenant-growth' => $this->tenantGrowth(),
            'revenue-growth' => $this->revenueGrowth(),
            'new-subscriptions' => $this->newSubscriptions(),
            'plan-distribution' => $this->planDistribution(),
            'trial-conversion' => $this->trialConversion(),
            'churn' => $this->churn(),
            'mrr-trend' => $this->mrrTrend(),
            default => response()->json(['error' => 'Unknown chart'], 404),
        };
    }

    private function tenantGrowth(): JsonResponse
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push([
                'label' => $date->format('M Y'),
                'count' => Tenant::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ]);
        }

        return response()->json([
            'labels' => $months->pluck('label'),
            'data' => $months->pluck('count'),
        ]);
    }

    private function revenueGrowth(): JsonResponse
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = SubscriptionPayment::where('status', SubscriptionPayment::STATUS_PAID)
                ->whereYear('paid_at', $date->year)
                ->whereMonth('paid_at', $date->month)
                ->sum('amount');

            $months->push([
                'label' => $date->format('M Y'),
                'revenue' => round($revenue, 2),
            ]);
        }

        return response()->json([
            'labels' => $months->pluck('label'),
            'data' => $months->pluck('revenue'),
        ]);
    }

    private function newSubscriptions(): JsonResponse
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push([
                'label' => $date->format('M Y'),
                'count' => Subscription::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ]);
        }

        return response()->json([
            'labels' => $months->pluck('label'),
            'data' => $months->pluck('count'),
        ]);
    }

    private function planDistribution(): JsonResponse
    {
        $plans = Plan::withCount('subscriptions')
            ->active()
            ->get();

        return response()->json([
            'labels' => $plans->pluck('name'),
            'data' => $plans->pluck('subscriptions_count'),
        ]);
    }

    private function trialConversion(): JsonResponse
    {
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();

            $trialStarted = Tenant::where('created_at', '>=', $startOfMonth)
                ->where('created_at', '<=', $endOfMonth)
                ->count();

            $converted = Subscription::where('status', Subscription::STATUS_ACTIVE)
                ->where('starts_at', '>=', $startOfMonth)
                ->where('starts_at', '<=', $endOfMonth)
                ->where('created_at', '!=', null)
                ->count();

            $months->push([
                'label' => $date->format('M Y'),
                'trial' => $trialStarted,
                'converted' => $converted,
            ]);
        }

        return response()->json([
            'labels' => $months->pluck('label'),
            'trial' => $months->pluck('trial'),
            'converted' => $months->pluck('converted'),
        ]);
    }

    private function churn(): JsonResponse
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push([
                'label' => $date->format('M Y'),
                'count' => Subscription::where('status', Subscription::STATUS_CANCELED)
                    ->whereYear('cancelled_at', $date->year)
                    ->whereMonth('cancelled_at', $date->month)
                    ->count(),
            ]);
        }

        return response()->json([
            'labels' => $months->pluck('label'),
            'data' => $months->pluck('count'),
        ]);
    }

    private function mrrTrend(): JsonResponse
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $endOfMonth = $date->copy()->endOfMonth();

            $mrr = Subscription::whereIn('status', [Subscription::STATUS_ACTIVE])
                ->where('created_at', '<=', $endOfMonth)
                ->with('plan')
                ->get()
                ->sum(function ($sub) use ($endOfMonth) {
                    if ($sub->cancelled_at && $sub->cancelled_at->lte($endOfMonth)) {
                        return 0;
                    }
                    $price = $sub->plan?->price ?? 0;
                    return $sub->plan?->billing_period === 'yearly' ? round($price / 12, 2) : $price;
                });

            $months->push([
                'label' => $date->format('M Y'),
                'mrr' => round($mrr, 2),
            ]);
        }

        return response()->json([
            'labels' => $months->pluck('label'),
            'data' => $months->pluck('mrr'),
        ]);
    }
}
