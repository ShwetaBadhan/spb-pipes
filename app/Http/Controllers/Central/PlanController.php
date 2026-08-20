<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function index(): View
    {
        $plans = Plan::orderBy('sort_order')->orderBy('price')->get();

        return view('central.plans.index', compact('plans'));
    }

    public function create(): View
    {
        return view('central.plans.create', [
            'limitKeys' => Plan::LIMIT_KEYS,
            'featureKeys' => Plan::FEATURES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePlan($request);

        Plan::create($data);

        return redirect()->route('central.plans.index')->with('status', 'Plan created.');
    }

    public function edit(Plan $plan): View
    {
        return view('central.plans.edit', [
            'plan' => $plan,
            'limitKeys' => Plan::LIMIT_KEYS,
            'featureKeys' => Plan::FEATURES,
        ]);
    }

    public function update(Request $request, Plan $plan): RedirectResponse
    {
        $data = $this->validatePlan($request, $plan);

        if ($request->boolean('is_default') && ! $plan->is_default) {
            Plan::where('id', '!=', $plan->id)->update(['is_default' => false]);
        }

        $plan->update($data);

        return redirect()->route('central.plans.index')->with('status', 'Plan updated.');
    }

    public function destroy(Plan $plan): RedirectResponse
    {
        if (Subscription::where('plan_id', $plan->id)->exists()) {
            return back()->withErrors(['plan' => 'This plan is used by subscriptions and cannot be deleted. Deactivate it instead.']);
        }

        $plan->delete();

        return redirect()->route('central.plans.index')->with('status', 'Plan deleted.');
    }

    public function toggle(Plan $plan): RedirectResponse
    {
        if ($plan->is_active && Plan::active()->count() === 1) {
            return back()->withErrors(['plan' => 'At least one plan must remain active.']);
        }

        $plan->update(['is_active' => ! $plan->is_active]);

        return back()->with('status', $plan->is_active ? 'Plan activated.' : 'Plan deactivated.');
    }

    private function validatePlan(Request $request, ?Plan $plan = null): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:60', 'alpha_dash'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'billing_period' => ['required', 'in:monthly,yearly'],
            'trial_days' => ['required', 'integer', 'min:0', 'max:365'],
            'is_active' => ['nullable', 'boolean'],
            'is_default' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'limits' => ['nullable', 'array'],
            'features' => ['nullable', 'array'],
        ];

        if (! $plan) {
            $rules['slug'][] = 'unique:plans,slug';
        } else {
            $rules['slug'][] = 'unique:plans,slug,' . $plan->id;
        }

        $validated = $request->validate($rules);

        $limits = [];

        foreach (Plan::LIMIT_KEYS as $key) {
            $limits[$key] = (int) ($request->input("limits.{$key}", 0));
        }

        $validated['limits'] = $limits;

        $features = collect(Plan::FEATURES)
            ->keys()
            ->filter(fn ($key) => $request->boolean("features.{$key}"))
            ->values()
            ->toArray();

        $validated['features'] = empty($features) ? null : $features;

        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_default'] = $request->boolean('is_default');

        if ($validated['is_default'] && ! $plan) {
            Plan::where('is_default', true)->update(['is_default' => false]);
        }

        return $validated;
    }
}
