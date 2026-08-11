<?php

namespace App\Traits;

trait BelongsToTenant
{
    public static function bootBelongsToTenant(): void
    {
        static::addGlobalScope('tenant', function ($query) {
            $tenantId = static::resolveTenantId();
            if ($tenantId) {
                $query->where($query->getModel()->getTable().'.tenant_id', $tenantId);
            }
        });

        static::creating(function ($model) {
            $tenantId = static::resolveTenantId();
            if ($tenantId) {
                $model->tenant_id = $tenantId;
            }
        });
    }

    public static function resolveTenantId(): ?int
    {
        if (app()->bound('current_tenant_id') && app('current_tenant_id')) {
            return (int) app('current_tenant_id');
        }

        // Prevent infinite recursion while the authenticated user is being
        // resolved: the User model's own scope would otherwise call auth()
        // again and resolve the user indefinitely.
        if (app()->bound('resolving_tenant_user')) {
            return null;
        }

        app()->instance('resolving_tenant_user', true);
        try {
            $user = auth()->user();
        } finally {
            app()->forgetInstance('resolving_tenant_user');
        }

        return $user?->tenant_id ? (int) $user->tenant_id : null;
    }
}
