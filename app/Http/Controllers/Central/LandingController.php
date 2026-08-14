<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use App\Services\TenantLoginService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $plans = Plan::active()->ordered()->get();
        $limitKeys = Plan::LIMIT_KEYS;
        $domainSuffix = config('tenancy.central_domains')[0] ?? null;

        return view('central.landing', compact('plans', 'limitKeys', 'domainSuffix'));
    }

    public function register(Request $request): View
    {
        $plans = Plan::active()->ordered()->get();

        $plan = $plans->firstWhere('id', (int) $request->query('plan'))
            ?? Plan::where('is_default', true)->first()
            ?? $plans->first();

        $domainSuffix = config('tenancy.central_domains')[0] ?? null;

        return view('central.register', compact('plan', 'plans', 'domainSuffix'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'subdomain' => ['required', 'regex:/^[a-z0-9]([a-z0-9\-]*[a-z0-9])?$/', 'max:32'],
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'admin_password' => ['required', 'string', 'min:8', 'confirmed'],
            'plan_id' => ['required', 'exists:plans,id'],
        ]);

        $plan = Plan::query()->active()->findOrFail($data['plan_id']);

        $domainSuffix = config('tenancy.central_domains')[0] ?? null;

        if (! $domainSuffix) {
            return back()->withErrors(['subdomain' => 'Central domain is not configured.'])->withInput();
        }

        $domain = $data['subdomain'] . '.' . $domainSuffix;

        if (\Stancl\Tenancy\Database\Models\Domain::where('domain', $domain)->exists()) {
            return back()->withErrors(['subdomain' => 'This subdomain is already taken.'])->withInput();
        }

        $trialDays = (int) $plan->trial_days;
        $startsAt = Carbon::now();
        $endsAt = $trialDays > 0 ? $startsAt->copy()->addDays($trialDays) : null;

        $status = $trialDays > 0 ? Subscription::STATUS_TRIALING : Subscription::STATUS_PENDING;

        $tenant = Tenant::create([
            'id' => $data['subdomain'],
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

        $admin = User::query()
            ->where('tenant_id', $tenant->id)
            ->where('email', $data['admin_email'])
            ->first();

        $next = $status === Subscription::STATUS_TRIALING ? '/dashboard' : '/plans-billings';
        $token = $admin ? app(TenantLoginService::class)->issueLoginToken($admin, $next) : null;

        if (! $token) {
            return redirect()->away(app(TenantLoginService::class)->tenantUrl($domain, '/login'));
        }

        return redirect()->away(app(TenantLoginService::class)->tenantUrl($domain, "/auth/login-as/{$token}"));
    }
}
