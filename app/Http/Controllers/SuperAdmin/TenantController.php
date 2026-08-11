<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Plan;
use App\Models\Tenant;
use App\Models\TenantDomain;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TenantController extends Controller
{
    public function index(Request $request): View
    {
        $tenants = Tenant::query()
            ->with(['plan', 'subscription'])
            ->when($request->filled('q'), fn ($q) => $q->where(function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->q}%")
                    ->orWhere('slug', 'like', "%{$request->q}%")
                    ->orWhere('email', 'like', "%{$request->q}%");
            }))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('super-admin.tenants.index', compact('tenants'));
    }

    public function create(): View
    {
        $plans = Plan::where('is_active', true)->orderBy('price_monthly')->get();

        return view('super-admin.tenants.create', compact('plans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'alpha_dash', 'max:60', 'unique:tenants,slug'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'plan_id' => ['nullable', 'exists:plans,id'],
            'status' => ['required', Rule::in(['trial', 'active', 'suspended'])],
            'trial_days' => ['nullable', 'integer', 'min:0'],
        ]);

        $tenant = Tenant::create($data + [
            'plan_slug' => $data['plan_id'] ? Plan::find($data['plan_id'])->slug : null,
            'trial_started_at' => $data['status'] === 'trial' ? now() : null,
            'trial_ends_at' => $data['status'] === 'trial' && isset($data['trial_days'])
                ? now()->addDays($data['trial_days'])
                : null,
        ]);

        $this->log('tenant.created', $tenant, ['name' => $tenant->name]);

        return redirect()->route('super-admin.tenants.index')
            ->with('success', "Tenant \"{$tenant->name}\" created.");
    }

    public function show(Tenant $tenant): View
    {
        $tenant->load(['plan', 'subscriptions.plan', 'domains', 'addons', 'billingInvoices', 'payments']);

        $usage = [
            'users' => $tenant->users()->count(),
            'products' => $tenant->products()->count(),
            'customers' => $tenant->customers()->count(),
            'invoices' => $tenant->invoices()->count(),
            'orders' => $tenant->orders()->count(),
        ];

        $limits = \App\Services\PlanService::limits($tenant);

        return view('super-admin.tenants.show', compact('tenant', 'usage', 'limits'));
    }

    public function edit(Tenant $tenant): View
    {
        $plans = Plan::orderBy('price_monthly')->get();

        return view('super-admin.tenants.edit', compact('tenant', 'plans'));
    }

    public function update(Request $request, Tenant $tenant): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'alpha_dash', 'max:60', Rule::unique('tenants', 'slug')->ignore($tenant->id)],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'status' => ['required', Rule::in(['trial', 'active', 'suspended', 'canceled'])],
        ]);

        $tenant->update($data);

        $this->log('tenant.updated', $tenant, ['name' => $tenant->name]);

        return redirect()->route('super-admin.tenants.show', $tenant)
            ->with('success', 'Tenant updated.');
    }

    public function suspend(Tenant $tenant): RedirectResponse
    {
        $tenant->update([
            'status' => 'suspended',
            'suspended_at' => now(),
        ]);

        $this->log('tenant.suspended', $tenant, ['name' => $tenant->name]);

        return back()->with('success', "Tenant \"{$tenant->name}\" suspended.");
    }

    public function reactivate(Tenant $tenant): RedirectResponse
    {
        $tenant->update([
            'status' => 'active',
            'suspended_at' => null,
        ]);

        $this->log('tenant.reactivated', $tenant, ['name' => $tenant->name]);

        return back()->with('success', "Tenant \"{$tenant->name}\" reactivated.");
    }

    public function changePlan(Request $request, Tenant $tenant): RedirectResponse
    {
        $data = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
        ]);

        $plan = Plan::findOrFail($data['plan_id']);

        $tenant->update([
            'plan_id' => $plan->id,
            'plan_slug' => $plan->slug,
        ]);

        $this->log('tenant.plan_changed', $tenant, [
            'name' => $tenant->name,
            'old_plan' => $tenant->getOriginal('plan_slug'),
            'new_plan' => $plan->slug,
        ]);

        return back()->with('success', "Plan changed to \"{$plan->name}\".");
    }

    public function domains(Tenant $tenant): View
    {
        $domains = $tenant->domains()->latest()->get();

        return view('super-admin.tenants.domains', compact('tenant', 'domains'));
    }

    public function storeDomain(Request $request, Tenant $tenant): RedirectResponse
    {
        $data = $request->validate([
            'domain' => ['required', 'string', 'max:255', 'unique:tenant_domains,domain'],
            'type' => ['required', Rule::in(['subdomain', 'custom'])],
        ]);

        $tenant->domains()->create($data + ['status' => 'pending']);

        return back()->with('success', 'Domain registered and pending verification.');
    }

    public function verifyDomain(TenantDomain $domain): RedirectResponse
    {
        $tenant = $domain->tenant;

        if ($this->verifyDns($domain) || request()->boolean('force')) {
            $domain->update(['status' => 'active', 'verified_at' => now()]);

            $this->log('domain.verified', $tenant, ['domain' => $domain->domain]);

            return back()->with('success', "Domain \"{$domain->domain}\" verified and active.");
        }

        return back()->withErrors([
            'domain' => 'DNS verification failed. Create a TXT record on _spb-pipes.'.$domain->domain
                .' with value "'.$this->verificationToken($domain)
                .'", or a CNAME pointing at '.config('saas.tenancy.central_domain', 'spb-pipes.com')
                .'. You can also use "Verify (force)" once the record is published.',
        ]);
    }

    public function destroyDomain(TenantDomain $domain): RedirectResponse
    {
        $tenant = $domain->tenant;
        $name = $domain->domain;

        $domain->delete();

        $this->log('domain.removed', $tenant, ['domain' => $name]);

        return back()->with('success', "Domain \"{$name}\" removed.");
    }

    protected function verifyDns(TenantDomain $domain): bool
    {
        $token = $this->verificationToken($domain);

        foreach ((array) @dns_get_record('_spb-pipes.'.$domain->domain, DNS_TXT) as $record) {
            if (in_array($token, $record['entries'] ?? [], true)) {
                return true;
            }
        }

        $central = config('saas.tenancy.central_domain', 'spb-pipes.com');

        foreach ((array) @dns_get_record($domain->domain, DNS_A) as $record) {
            if (($record['ip'] ?? '') === $this->centralIp($central)) {
                return true;
            }
        }

        foreach ((array) @dns_get_record($domain->domain, DNS_CNAME) as $record) {
            if (str_ends_with(rtrim((string) ($record['target'] ?? ''), '.'), $central)) {
                return true;
            }
        }

        return false;
    }

    protected function centralIp(string $central): ?string
    {
        $records = @dns_get_record($central, DNS_A);

        return $records[0]['ip'] ?? null;
    }

    protected function verificationToken(TenantDomain $domain): string
    {
        return substr(hash('sha256', $domain->tenant_id.'|'.$domain->domain.'|'.config('app.key')), 0, 32);
    }

    protected function log(string $event, Tenant $tenant, array $newValues = []): void
    {
        AuditLog::create([
            'tenant_id' => $tenant->id,
            'super_admin_id' => auth('super_admin')->id(),
            'event' => $event,
            'auditable_type' => Tenant::class,
            'auditable_id' => $tenant->id,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
