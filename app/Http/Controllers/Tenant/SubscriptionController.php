<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Services\PlanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index(): View
    {
        $tenant = currentTenant();

        abort_if(! $tenant, 404);

        $tenant->load(['plan', 'subscription', 'billingInvoices', 'payments', 'addons']);

        $plans = Plan::where('is_active', true)->orderBy('price_monthly')->get();
        $limits = PlanService::limits($tenant);
        $usage = [
            'users' => $tenant->users()->count(),
            'products' => $tenant->products()->count(),
            'invoices' => $tenant->invoices()->count(),
        ];
        $stripeConfigured = ! empty(config('services.stripe.secret'));

        return view('admin.pages.settings.general-settings.plans-billings', compact(
            'tenant',
            'plans',
            'limits',
            'usage',
            'stripeConfigured'
        ));
    }

    public function change(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
        ]);

        $tenant = currentTenant();
        abort_if(! $tenant, 404);

        $plan = Plan::findOrFail($data['plan_id']);

        if (! empty(config('services.stripe.secret'))) {
            $session = $tenant->checkout(
                $plan->stripe_price_id ?: null,
                [
                    'mode' => 'subscription',
                    'success_url' => route('tenant.billing').'?checkout=success',
                    'cancel_url' => route('tenant.billing').'?checkout=cancelled',
                    'metadata' => ['plan_id' => $plan->id, 'plan_slug' => $plan->slug],
                ]
            );

            return redirect()->away($session->url);
        }

        $this->simulatePlanChange($tenant, $plan);

        return redirect()->route('tenant.billing')->with('success', "Plan switched to \"{$plan->name}\".");
    }

    public function cancel(): RedirectResponse
    {
        $tenant = currentTenant();
        abort_if(! $tenant, 404);

        if (! empty(config('services.stripe.secret')) && $tenant->subscription()) {
            $tenant->subscription()->cancel();
        }

        $tenant->update(['status' => 'canceled', 'canceled_at' => now()]);
        $tenant->subscription?->update(['status' => 'canceled', 'ends_at' => now()]);

        return redirect()->route('tenant.billing')->with('success', 'Your subscription has been cancelled.');
    }

    public function resume(): RedirectResponse
    {
        $tenant = currentTenant();
        abort_if(! $tenant, 404);

        if (! empty(config('services.stripe.secret')) && $tenant->subscription()) {
            $tenant->subscription()->resume();
        }

        $tenant->update(['status' => 'active', 'canceled_at' => null]);
        $tenant->subscription?->update(['status' => 'active', 'ends_at' => null]);

        return redirect()->route('tenant.billing')->with('success', 'Your subscription has been resumed.');
    }

    /**
     * Simulated plan change used when Stripe isn't configured (local/dev).
     */
    protected function simulatePlanChange(Tenant $tenant, Plan $plan): void
    {
        $tenant->update([
            'plan_id' => $plan->id,
            'plan_slug' => $plan->slug,
            'status' => $tenant->status === 'canceled' ? 'active' : $tenant->status,
            'canceled_at' => null,
        ]);

        Subscription::updateOrCreate(
            ['tenant_id' => $tenant->id, 'type' => 'default'],
            [
                'plan_id' => $plan->id,
                'status' => 'active',
                'stripe_status' => 'active',
                'trial_ends_at' => null,
                'ends_at' => null,
            ]
        );
    }
}
