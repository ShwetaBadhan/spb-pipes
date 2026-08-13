<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\GatePass;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class PlanService
{
    private const CACHE_TTL = 60;

    private ?string $tenantId = null;

    private ?Subscription $subscription = null;

    private ?Plan $plan = null;

    private ?string $fallbackStatus = null;

    private bool $resolved = false;

    public function __construct(?string $tenantId = null)
    {
        $this->tenantId = $tenantId ?? (tenancy()->initialized ? tenant()->getTenantKey() : null);
    }

    public static function for(?string $tenantId = null): self
    {
        return new self($tenantId);
    }

    public function tenantId(): ?string
    {
        return $this->tenantId;
    }

    public function subscription(): ?Subscription
    {
        $this->resolve();

        return $this->subscription;
    }

    public function plan(): ?Plan
    {
        $this->resolve();

        return $this->plan;
    }

    public function status(): ?string
    {
        $this->resolve();

        if ($this->isExpired()) {
            return $this->fallbackStatus ?? Subscription::STATUS_EXPIRED;
        }

        return $this->subscription?->status;
    }

    public function isExpired(): bool
    {
        $this->resolve();

        if (! $this->subscription) {
            return $this->fallbackStatus !== null;
        }

        if ($this->subscription->status === Subscription::STATUS_EXPIRED) {
            return true;
        }

        if ($this->subscription->status === Subscription::STATUS_PENDING) {
            return true;
        }

        if ($this->subscription->isTrialing()) {
            if ($this->subscription->ends_at) {
                return $this->subscription->ends_at->isPast();
            }

            $trialDays = (int) ($this->subscription->plan?->trial_days ?? 0);

            return $trialDays <= 0 || $this->subscription->created_at?->addDays($trialDays)->isPast();
        }

        return $this->subscription->ends_at !== null && $this->subscription->ends_at->isPast();
    }

    public function limit(string $key): int
    {
        $this->resolve();

        if (! $this->plan) {
            return -1;
        }

        $override = $this->subscription?->limitOverride($key);

        return $override ?? $this->plan->limit($key);
    }

    public function usage(string $key): int
    {
        return match ($key) {
            'customers' => Customer::count(),
            'invoices' => Invoice::count(),
            'products' => Product::count(),
            'users' => User::count(),
            'gate_passes' => GatePass::count(),
            'raw_materials' => RawMaterial::count(),
            default => 0,
        };
    }

    public function usages(): array
    {
        $usages = [];

        foreach (Plan::LIMIT_KEYS as $key) {
            $usages[$key] = [
                'usage' => $this->usage($key),
                'limit' => $this->limit($key),
                'remaining' => $this->remaining($key),
                'unlimited' => $this->limit($key) < 0,
                'within' => $this->isWithinLimit($key),
            ];
        }

        return $usages;
    }

    public function isWithinLimit(string $key): bool
    {
        if ($this->isExpired()) {
            return false;
        }

        $limit = $this->limit($key);

        if ($limit < 0) {
            return true;
        }

        return $this->usage($key) < $limit;
    }

    public function remaining(string $key): int
    {
        $limit = $this->limit($key);

        if ($limit < 0) {
            return PHP_INT_MAX;
        }

        return max(0, $limit - $this->usage($key));
    }

    private function resolve(): void
    {
        if ($this->resolved) {
            return;
        }

        $this->resolved = true;

        if (! $this->tenantId) {
            return;
        }

        $cacheKey = "plan.subscription.{$this->tenantId}";

        $this->subscription = Cache::store()->remember($cacheKey, self::CACHE_TTL, function () {
            return Subscription::query()
                ->forTenant($this->tenantId)
                ->active()
                ->latest('id')
                ->with('plan')
                ->first();
        });

        if ($this->subscription?->plan) {
            $this->plan = $this->subscription->plan;

            return;
        }

        $tenant = \App\Models\Tenant::query()->find($this->tenantId);

        $this->plan = $tenant?->plan;

        if ($tenant && $tenant->subscription_status && ! in_array($tenant->subscription_status, [Subscription::STATUS_TRIALING, Subscription::STATUS_ACTIVE], true)) {
            $this->fallbackStatus = $tenant->subscription_status;
        }
    }
}
