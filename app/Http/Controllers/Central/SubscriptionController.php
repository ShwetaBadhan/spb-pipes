<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\Tenant;
use App\Models\TenantActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Subscription::with(['tenant', 'plan', 'payments']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->input('plan_id'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('tenant', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('admin_email', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $subscriptions = $query->orderByDesc('created_at')->paginate(25)->withQueryString();
        $plans = Plan::active()->ordered()->get();

        return view('central.subscriptions.index', compact('subscriptions', 'plans'));
    }

    public function show(Subscription $subscription): View
    {
        $subscription->load(['tenant.domains', 'plan', 'payments']);

        $tenant = $subscription->tenant;

        return view('central.subscriptions.show', compact('subscription', 'tenant'));
    }

    public function upgrade(Subscription $subscription, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
        ]);

        $newPlan = Plan::findOrFail($data['plan_id']);
        $oldPlan = $subscription->plan;

        $subscription->update([
            'plan_id' => $newPlan->id,
        ]);

        $tenant = $subscription->tenant;
        if ($tenant) {
            $tenant->plan_id = $newPlan->id;
            $tenant->save();
            Cache::store()->forget("plan.subscription.{$tenant->id}");

            TenantActivityLog::log($tenant->id, 'subscription.upgraded', "Subscription upgraded from {$oldPlan->name} to {$newPlan->name}.");
        }

        return back()->with('status', "Subscription upgraded to {$newPlan->name}.");
    }

    public function downgrade(Subscription $subscription, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
        ]);

        $newPlan = Plan::findOrFail($data['plan_id']);
        $oldPlan = $subscription->plan;

        $subscription->update([
            'plan_id' => $newPlan->id,
        ]);

        $tenant = $subscription->tenant;
        if ($tenant) {
            $tenant->plan_id = $newPlan->id;
            $tenant->save();
            Cache::store()->forget("plan.subscription.{$tenant->id}");

            TenantActivityLog::log($tenant->id, 'subscription.downgraded', "Subscription downgraded from {$oldPlan->name} to {$newPlan->name}.");
        }

        return back()->with('status', "Subscription downgraded to {$newPlan->name}.");
    }

    public function cancel(Subscription $subscription): RedirectResponse
    {
        $subscription->cancel();

        $tenant = $subscription->tenant;
        if ($tenant) {
            $tenant->subscription_status = Subscription::STATUS_CANCELED;
            $tenant->subscription_ends_at = now();
            $tenant->save();
            Cache::store()->forget("plan.subscription.{$tenant->id}");

            TenantActivityLog::log($tenant->id, 'subscription.canceled', "Subscription canceled by admin.");
        }

        return back()->with('status', 'Subscription canceled.');
    }

    public function resume(Subscription $subscription): RedirectResponse
    {
        $subscription->resume();

        $period = $subscription->plan?->billing_period === 'yearly' ? 365 : 30;
        $subscription->ends_at = now()->addDays($period);
        $subscription->save();

        $tenant = $subscription->tenant;
        if ($tenant) {
            $tenant->subscription_status = Subscription::STATUS_ACTIVE;
            $tenant->subscription_ends_at = $subscription->ends_at;
            $tenant->save();
            Cache::store()->forget("plan.subscription.{$tenant->id}");

            TenantActivityLog::log($tenant->id, 'subscription.resumed', "Subscription resumed by admin.");
        }

        return back()->with('status', 'Subscription resumed.');
    }

    public function extend(Subscription $subscription, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'days' => ['required', 'integer', 'min:1', 'max:365'],
        ]);

        $subscription->extend($data['days']);

        $tenant = $subscription->tenant;
        if ($tenant) {
            $tenant->subscription_ends_at = $subscription->ends_at;
            $tenant->save();
            Cache::store()->forget("plan.subscription.{$tenant->id}");

            TenantActivityLog::log($tenant->id, 'subscription.extended', "Subscription extended by {$data['days']} days. New end: {$subscription->ends_at->format('d M Y')}.");
        }

        return back()->with('status', "Subscription extended by {$data['days']} days.");
    }

    public function changeCycle(Subscription $subscription, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'billing_period' => ['required', 'in:monthly,yearly'],
        ]);

        $subscription->plan->update(['billing_period' => $data['billing_period']]);

        $tenant = $subscription->tenant;
        if ($tenant) {
            Cache::store()->forget("plan.subscription.{$tenant->id}");
            TenantActivityLog::log($tenant->id, 'subscription.cycle_changed', "Billing cycle changed to {$data['billing_period']}.");
        }

        return back()->with('status', "Billing cycle changed to {$data['billing_period']}.");
    }

    public function changeRenewalDate(Subscription $subscription, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ends_at' => ['required', 'date'],
        ]);

        $subscription->ends_at = Carbon::parse($data['ends_at']);
        $subscription->save();

        $tenant = $subscription->tenant;
        if ($tenant) {
            $tenant->subscription_ends_at = $subscription->ends_at;
            $tenant->save();
            Cache::store()->forget("plan.subscription.{$tenant->id}");

            TenantActivityLog::log($tenant->id, 'subscription.renewal_changed', "Renewal date changed to {$subscription->ends_at->format('d M Y')}.");
        }

        return back()->with('status', "Renewal date changed to {$subscription->ends_at->format('d M Y')}.");
    }

    public function changeNotes(Subscription $subscription, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $subscription->update(['notes' => $data['notes']]);

        return back()->with('status', 'Notes updated.');
    }
}
