<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @extends Factory<Tenant>
 */
class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        $plan = $this->randomPlan();

        $company = fake()->unique()->company();
        $subdomain = Str::slug($company).'-'.Str::lower(Str::random(4));
        $domainSuffix = config('tenancy.central_domains')[0] ?? 'localhost';

        $startsAt = Carbon::instance(fake()->dateTimeBetween(now()->startOfYear(), now()));

        [$status, $endsAt, $trialEndsAt] = $this->timeline($plan, $startsAt);

        return [
            'name' => $company,
            'domain' => $subdomain.'.'.$domainSuffix,
            'admin_name' => fake()->name(),
            'admin_email' => fake()->unique()->safeEmail(),
            'admin_password' => 'password',
            'plan_id' => $plan->id,
            'subscription_status' => $status,
            'trial_ends_at' => $trialEndsAt,
            'subscription_ends_at' => $endsAt,
            'created_at' => $startsAt,
            'updated_at' => $startsAt,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Tenant $tenant) {
            $tenant->domains()->firstOrCreate(['domain' => $tenant->domain]);

            $startsAt = $tenant->created_at ?? now();
            $endsAt = $tenant->subscription_ends_at;
            $status = $tenant->subscription_status;

            $subscription = Subscription::create([
                'tenant_id' => $tenant->id,
                'plan_id' => $tenant->plan_id,
                'status' => $status,
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'cancelled_at' => $status === Subscription::STATUS_CANCELED ? ($endsAt ?? now()) : null,
                'next_billing_at' => $status === Subscription::STATUS_ACTIVE ? $endsAt : null,
                'gateway' => fake()->randomElement(['manual', 'stripe', 'razorpay']),
                'gateway_subscription_id' => fake()->boolean(60) ? 'sub_'.Str::random(14) : null,
            ]);

            $plan = $tenant->plan;

            if (! $plan || $plan->isFree()) {
                return;
            }

            if (in_array($status, [Subscription::STATUS_TRIALING, Subscription::STATUS_PENDING], true)) {
                return;
            }

            $maxPayments = min(
                12,
                max(1, (int) floor($startsAt->diffInDays(now()) / ($plan->billing_period === 'yearly' ? 365 : 30)))
            );

            for ($i = 0; $i < fake()->numberBetween(1, $maxPayments); $i++) {
                $paidUntil = ($endsAt && $endsAt->lessThan(now())) ? $endsAt : now();

                if ($paidUntil->lessThanOrEqualTo($startsAt)) {
                    continue;
                }

                $paymentStatus = fake()->randomElement([
                    SubscriptionPayment::STATUS_PAID,
                    SubscriptionPayment::STATUS_PAID,
                    SubscriptionPayment::STATUS_PAID,
                    SubscriptionPayment::STATUS_PAID,
                    SubscriptionPayment::STATUS_FAILED,
                ]);

                SubscriptionPayment::create([
                    'subscription_id' => $subscription->id,
                    'tenant_id' => $tenant->id,
                    'gateway' => $subscription->gateway,
                    'gateway_payment_id' => 'pay_'.Str::random(14),
                    'amount' => $plan->price,
                    'currency' => $plan->currency,
                    'status' => $paymentStatus,
                    'paid_at' => $paymentStatus === SubscriptionPayment::STATUS_PAID
                        ? Carbon::instance(fake()->dateTimeBetween($startsAt, $paidUntil))
                        : null,
                ]);
            }
        });
    }

    public function trialing(): static
    {
        return $this->state(fn () => [
            'subscription_status' => Subscription::STATUS_TRIALING,
        ]);
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'subscription_status' => Subscription::STATUS_ACTIVE,
        ]);
    }

    public function suspended(): static
    {
        return $this->state(fn () => [
            'is_suspended' => true,
        ]);
    }

    private function randomPlan(): Plan
    {
        $plan = Plan::query()->inRandomOrder()->active()->first();

        if ($plan) {
            return $plan;
        }

        return Plan::query()->create([
            'name' => 'Starter',
            'slug' => 'starter-'.Str::lower(Str::random(4)),
            'description' => 'Fallback plan created by TenantFactory.',
            'price' => fake()->randomElement([499, 999, 1499]),
            'currency' => 'INR',
            'billing_period' => fake()->randomElement(['monthly', 'yearly']),
            'trial_days' => 14,
            'is_active' => true,
            'sort_order' => 99,
            'limits' => collect(Plan::LIMIT_KEYS)
                ->mapWithKeys(fn (string $key) => [$key => fake()->numberBetween(50, 500)])
                ->all(),
            'features' => null,
        ]);
    }

    private function timeline(Plan $plan, Carbon $startsAt): array
    {
        $periodDays = $plan->billing_period === 'yearly' ? 365 : 30;

        $status = fake()->randomElement([
            Subscription::STATUS_ACTIVE,
            Subscription::STATUS_ACTIVE,
            Subscription::STATUS_ACTIVE,
            Subscription::STATUS_ACTIVE,
            Subscription::STATUS_TRIALING,
            Subscription::STATUS_PENDING,
            Subscription::STATUS_PAST_DUE,
            Subscription::STATUS_EXPIRED,
            Subscription::STATUS_CANCELED,
        ]);

        if ($status === Subscription::STATUS_TRIALING && $plan->trial_days < 1) {
            $status = Subscription::STATUS_ACTIVE;
        }

        $trialEndsAt = null;

        $endsAt = $startsAt->copy()->addDays(
            $status === Subscription::STATUS_TRIALING ? $plan->trial_days : $periodDays
        );

        if (in_array($status, [Subscription::STATUS_EXPIRED, Subscription::STATUS_CANCELED], true)) {
            if ($endsAt->isFuture()) {
                $endsAt = Carbon::instance(fake()->dateTimeBetween($startsAt, now()));
            }
        } else {
            while ($endsAt->isPast()) {
                $endsAt->addDays(
                    $status === Subscription::STATUS_TRIALING ? max(1, $plan->trial_days) : $periodDays
                );
            }
        }

        if ($status === Subscription::STATUS_TRIALING) {
            $trialEndsAt = $endsAt;
        }

        return [$status, $endsAt, $trialEndsAt];
    }
}
