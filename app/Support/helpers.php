<?php

use App\Models\Tenant;

if (! function_exists('currentTenant')) {
    function currentTenant(): ?Tenant
    {
        if (app()->bound('current_tenant')) {
            $tenant = app('current_tenant');
            if ($tenant) {
                return $tenant;
            }
        }

        $user = auth()->user();

        return $user?->tenant;
    }
}
