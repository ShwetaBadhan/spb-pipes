<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\GatePass;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\Tenant;
use App\Models\User;
use App\Services\TenantLoginService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class TenantController extends Controller
{
    public function index(): View
    {
        $tenants = Tenant::with(['domains', 'plan'])->orderByDesc('created_at')->get();
        $plans = Plan::active()->ordered()->get();
        $defaultPlan = Plan::where('is_default', true)->first() ?? $plans->first();

        return view('central.tenants.index', compact('tenants', 'plans', 'defaultPlan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'id' => ['required', 'alpha_dash', 'max:32', 'unique:tenants,id'],
            'subdomain' => ['required', 'regex:/^[a-z0-9]([a-z0-9\-]*[a-z0-9])?$/', 'max:32'],
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'admin_password' => ['required', 'string', 'min:8', 'confirmed'],
            'plan_id' => ['required', 'exists:plans,id'],
            'trial_days' => ['nullable', 'integer', 'min:0', 'max:365'],
        ]);

        $domain = $data['subdomain'] . '.' . config('tenancy.central_domains')[0];

        if (\Stancl\Tenancy\Database\Models\Domain::where('domain', $domain)->exists()) {
            return back()->withErrors(['subdomain' => 'This subdomain is already taken.'])->withInput();
        }

        $plan = Plan::findOrFail($data['plan_id']);

        $trialDays = (int) ($data['trial_days'] ?? $plan->trial_days);
        $startsAt = Carbon::now();
        $endsAt = $trialDays > 0 ? $startsAt->copy()->addDays($trialDays) : null;

        $status = $trialDays > 0 ? Subscription::STATUS_TRIALING : Subscription::STATUS_ACTIVE;

        $tenant = Tenant::create([
            'id' => $data['id'],
            'name' => $data['name'],
            'domain' => $domain,
            'admin_name' => $data['admin_name'],
            'admin_email' => $data['admin_email'],
            'admin_password' => $data['admin_password'],
            'plan_id' => $plan->id,
            'subscription_status' => $status,
            'trial_ends_at' => $status === Subscription::STATUS_TRIALING ? $endsAt : null,
            'subscription_ends_at' => $endsAt,
        ]);

        $tenant->domains()->create(['domain' => $domain]);

        Subscription::create([
            'tenant_id' => $tenant->id,
            'plan_id' => $plan->id,
            'status' => $status,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'gateway' => 'manual',
        ]);

        return redirect()->route('central.tenants.index')->with('status', 'Tenant created.');
    }

    public function show(Tenant $tenant): View
    {
        $tenant->load(['domains', 'plan', 'activeSubscription']);

        $counts = [
            'customers' => Customer::query()->where('tenant_id', $tenant->id)->count(),
            'invoices' => Invoice::query()->where('tenant_id', $tenant->id)->count(),
            'products' => Product::query()->where('tenant_id', $tenant->id)->count(),
            'users' => User::query()->where('tenant_id', $tenant->id)->count(),
            'gate_passes' => GatePass::query()->where('tenant_id', $tenant->id)->count(),
            'raw_materials' => RawMaterial::query()->where('tenant_id', $tenant->id)->count(),
        ];

        $subscription = $tenant->activeSubscription;

        $admin = User::query()->where('tenant_id', $tenant->id)->orderBy('id')->first();

        $usage = [];

        foreach (Plan::LIMIT_KEYS as $key) {
            $limit = $tenant->plan?->limit($key) ?? -1;
            $limit = $subscription?->limitOverride($key) ?? $limit;

            $count = $counts[$key];

            $usage[$key] = [
                'usage' => $count,
                'limit' => $limit,
                'remaining' => $limit < 0 ? PHP_INT_MAX : max(0, $limit - $count),
                'unlimited' => $limit < 0,
                'percent' => $limit < 0 ? 0 : min(100, (int) round($count / max(1, $limit) * 100)),
            ];
        }

        $financials = [
            'invoice_total' => Invoice::query()->where('tenant_id', $tenant->id)->sum('grand_total'),
            'invoice_count' => $counts['invoices'],
        ];

        $payments = SubscriptionPayment::query()
            ->where('tenant_id', $tenant->id)
            ->with('subscription.plan')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('central.tenants.show', compact('tenant', 'admin', 'usage', 'financials', 'payments'));
    }

    public function loginAs(Tenant $tenant): RedirectResponse
    {
        $user = User::query()->where('tenant_id', $tenant->id)->orderBy('id')->first();

        if (! $user) {
            return back()->withErrors(['error' => 'This tenant has no admin user yet.']);
        }

        $domain = $tenant->domains()->value('domain');

        if (! $domain) {
            return back()->withErrors(['error' => 'This tenant has no domain assigned.']);
        }

        $service = app(TenantLoginService::class);
        $token = $service->issueLoginToken($user, '/dashboard');

        return redirect()->away($service->tenantUrl($domain, "/auth/login-as/{$token}"));
    }

    public function edit(Tenant $tenant): View
    {
        $tenant->load(['domains', 'plan', 'activeSubscription']);

        $plans = Plan::orderBy('sort_order')->orderBy('price')->get();

        return view('central.tenants.edit', compact('tenant', 'plans'));
    }

    public function update(Request $request, Tenant $tenant): RedirectResponse
    {
        $data = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
            'trial_days' => ['nullable', 'integer', 'min:0', 'max:365'],
            'ends_at' => ['nullable', 'date'],
            'limit_overrides' => ['nullable', 'array'],
            'suspend' => ['nullable', 'boolean'],
        ]);

        $plan = Plan::findOrFail($data['plan_id']);

        $subscription = $tenant->activeSubscription()->first();

        if (! $subscription) {
            $subscription = Subscription::create([
                'tenant_id' => $tenant->id,
                'plan_id' => $plan->id,
                'status' => Subscription::STATUS_ACTIVE,
                'starts_at' => Carbon::now(),
                'gateway' => 'manual',
            ]);
        }

        $subscription->plan_id = $plan->id;
        $subscription->starts_at = $subscription->starts_at ?? Carbon::now();

        if ($request->boolean('suspend')) {
            $subscription->status = Subscription::STATUS_CANCELED;
            $subscription->cancelled_at = Carbon::now();
            $subscription->ends_at = $request->filled('ends_at') ? Carbon::parse($data['ends_at']) : $subscription->ends_at;
        } else {
            $subscription->status = Subscription::STATUS_ACTIVE;
            $subscription->cancelled_at = null;

            if ($request->filled('ends_at')) {
                $subscription->ends_at = Carbon::parse($data['ends_at']);
            } elseif ($subscription->isDirty('plan_id') || ! $subscription->ends_at) {
                $period = $plan->billing_period === 'yearly' ? 365 : 30;
                $subscription->ends_at = Carbon::now()->addDays($period);
            }
        }

        $overrides = collect($data['limit_overrides'] ?? [])
            ->map(fn ($value) => $value === '' ? null : (int) $value)
            ->filter(fn ($value) => $value !== null)
            ->toArray();

        $meta = $subscription->meta ?? [];
        $meta['limit_overrides'] = $overrides;
        $subscription->meta = $meta;

        $subscription->save();

        $tenant->plan_id = $plan->id;
        $tenant->subscription_status = $subscription->status;
        $tenant->trial_ends_at = $request->boolean('suspend') ? null : ($subscription->status === Subscription::STATUS_TRIALING ? $subscription->ends_at : null);
        $tenant->subscription_ends_at = $subscription->ends_at;
        $tenant->save();

        Cache::store()->forget("plan.subscription.{$tenant->id}");

        return redirect()->route('central.tenants.index')->with('status', 'Tenant updated.');
    }

    public function destroy(Tenant $tenant): RedirectResponse
    {
        SubscriptionPayment::query()->where('tenant_id', $tenant->id)->delete();
        Subscription::query()->where('tenant_id', $tenant->id)->delete();
        Cache::store()->forget("plan.subscription.{$tenant->id}");

        $tenant->domains()->delete();
        $tenant->delete();

        return redirect()->route('central.tenants.index')->with('status', 'Tenant deleted.');
    }
}
