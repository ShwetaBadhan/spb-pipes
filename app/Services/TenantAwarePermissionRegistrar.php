<?php

namespace App\Services;

use Illuminate\Cache\CacheManager;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\PermissionRegistrar;

class TenantAwarePermissionRegistrar extends PermissionRegistrar
{
    protected ?string $loadedForTenant = null;

    public function __construct(CacheManager $cacheManager)
    {
        parent::__construct($cacheManager);
    }

    public function getPermissions(array $params = [], bool $onlyOne = false): Collection
    {
        $this->syncTenantContext();

        return parent::getPermissions($params, $onlyOne);
    }

    public function forgetCachedPermissions()
    {
        $this->syncTenantContext();

        return parent::forgetCachedPermissions();
    }

    protected function currentTenantKey(): ?string
    {
        if (! tenancy()->initialized) {
            return null;
        }

        $key = tenant()->getTenantKey();

        return $key === null ? null : (string) $key;
    }

    protected function syncTenantContext(): void
    {
        $tenantKey = $this->currentTenantKey();

        if ($this->loadedForTenant !== $tenantKey) {
            $this->clearPermissionsCollection();
            $this->loadedForTenant = $tenantKey;
        }

        $this->cacheKey = config('permission.cache.key') . ($tenantKey ? ':' . $tenantKey : '');
    }
}
