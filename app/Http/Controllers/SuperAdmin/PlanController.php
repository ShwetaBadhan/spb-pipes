<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function index(): View
    {
        $plans = Plan::withCount('tenants')->orderBy('price_monthly')->get();

        return view('super-admin.plans.index', compact('plans'));
    }

    public function create(): View
    {
        return view('super-admin.plans.create', ['features' => config('saas.features')]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['features'] = $request->input('features', []);

        Plan::create($data);

        return redirect()->route('super-admin.plans.index')->with('success', 'Plan created.');
    }

    public function edit(Plan $plan): View
    {
        return view('super-admin.plans.edit', [
            'plan' => $plan,
            'features' => config('saas.features'),
        ]);
    }

    public function update(Request $request, Plan $plan): RedirectResponse
    {
        $data = $this->validated($request);
        $data['features'] = $request->input('features', []);

        $plan->update($data);

        return redirect()->route('super-admin.plans.index')->with('success', 'Plan updated.');
    }

    public function destroy(Plan $plan): RedirectResponse
    {
        $plan->delete();

        return redirect()->route('super-admin.plans.index')->with('success', 'Plan deleted.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'alpha_dash', 'max:60', Rule::unique('plans', 'slug')->ignore($request->route('plan'))],
            'price_monthly' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
            'max_users' => ['nullable', 'integer', 'min:0'],
            'max_products' => ['nullable', 'integer', 'min:0'],
            'max_invoices_per_month' => ['nullable', 'integer', 'min:0'],
            'max_storage_mb' => ['nullable', 'integer', 'min:0'],
            'trial_days' => ['nullable', 'integer', 'min:0', 'max:365'],
            'stripe_price_id' => ['nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
    }
}
