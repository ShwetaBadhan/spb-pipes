<?php

namespace App\Services;

use App\Models\Tenant;

class PlanService
{
    public static function hasFeature(?Tenant $tenant, string $feature): bool
    {
        if (! $tenant) {
            return false;
        }

        $plan = $tenant->plan;
        if ($plan && $plan->hasFeature($feature)) {
            return true;
        }

        // Fall back to the config catalog when the tenant has no DB plan yet
        $planConfig = config('saas.plans.'.$tenant->plan_slug);
        if ($planConfig && in_array($feature, $planConfig['features'] ?? [], true)) {
            return true;
        }

        // Check add-ons
        return $tenant->addons()
            ->wherePivot('status', 'active')
            ->where('feature', $feature)
            ->exists();
    }

    public static function withinLimit(?Tenant $tenant, string $resource): bool
    {
        if (! $tenant) {
            return false;
        }

        $limits = self::limits($tenant);

        $current = match ($resource) {
            'users' => $tenant->users()->count(),
            'products' => $tenant->products()->count(),
            'invoices' => $tenant->billingInvoices()->count(),
            default => 0,
        };

        $max = $limits[$resource] ?? null;

        if ($max === null || $max === PHP_INT_MAX) {
            return true;
        }

        return $current < $max;
    }

    /**
     * Resolve the limit values (DB plan, else config catalog).
     */
    public static function limits(?Tenant $tenant): array
    {
        $defaults = [
            'users' => PHP_INT_MAX,
            'products' => PHP_INT_MAX,
            'invoices' => PHP_INT_MAX,
            'storage_mb' => PHP_INT_MAX,
        ];

        if (! $tenant) {
            return $defaults;
        }

        if ($tenant->plan) {
            return array_merge($defaults, [
                'users' => $tenant->plan->max_users ?? PHP_INT_MAX,
                'products' => $tenant->plan->max_products ?? PHP_INT_MAX,
                'invoices' => $tenant->plan->max_invoices_per_month ?? PHP_INT_MAX,
                'storage_mb' => $tenant->plan->max_storage_mb ?? PHP_INT_MAX,
            ]);
        }

        $config = config('saas.plans.'.$tenant->plan_slug);
        if ($config) {
            return array_merge($defaults, [
                'users' => $config['max_users'] ?? PHP_INT_MAX,
                'products' => $config['max_products'] ?? PHP_INT_MAX,
                'invoices' => $config['max_invoices_per_month'] ?? PHP_INT_MAX,
                'storage_mb' => $config['max_storage_mb'] ?? PHP_INT_MAX,
            ]);
        }

        return $defaults;
    }
}
