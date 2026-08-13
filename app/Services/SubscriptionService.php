<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\Tenant;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class SubscriptionService
{
    public function activate(string $tenantId, Plan $plan, string $gateway, SubscriptionPayment $payment): Subscription
    {
        $subscription = Subscription::query()
            ->forTenant($tenantId)
            ->active()
            ->latest('id')
            ->first();

        $period = $plan->billing_period === 'yearly' ? 365 : 30;
        $endsAt = Carbon::now()->addDays($period);

        if (! $subscription) {
            $subscription = Subscription::create([
                'tenant_id' => $tenantId,
                'plan_id' => $plan->id,
                'status' => Subscription::STATUS_ACTIVE,
                'starts_at' => Carbon::now(),
                'ends_at' => $endsAt,
                'gateway' => $gateway,
                'gateway_subscription_id' => $payment->gateway_payment_id,
            ]);
        } else {
            $subscription->update([
                'plan_id' => $plan->id,
                'status' => Subscription::STATUS_ACTIVE,
                'ends_at' => $endsAt,
                'cancelled_at' => null,
                'gateway' => $gateway,
                'gateway_subscription_id' => $payment->gateway_payment_id,
            ]);
        }

        $payment->update([
            'status' => SubscriptionPayment::STATUS_PAID,
            'paid_at' => Carbon::now(),
        ]);

        $tenant = Tenant::query()->find($tenantId);

        if ($tenant) {
            $tenant->update([
                'plan_id' => $plan->id,
                'subscription_status' => Subscription::STATUS_ACTIVE,
                'trial_ends_at' => null,
                'subscription_ends_at' => $subscription->ends_at,
            ]);
        }

        Cache::store()->forget("plan.subscription.{$tenantId}");

        return $subscription;
    }
}
