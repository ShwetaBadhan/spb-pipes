<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Models\TenantDomain;
use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('saas.tenancy.enabled', true)) {
            app()->instance('current_tenant', null);
            app(PermissionRegistrar::class)->setPermissionsTeamId(0);

            return $next($request);
        }

        $host = $request->getHost();
        $tenant = null;

        // 1. Custom domain (tenant_domains)
        $domain = TenantDomain::where('domain', $host)
            ->where('status', 'active')
            ->with('tenant')
            ->first();

        if ($domain && $domain->tenant) {
            $tenant = $domain->tenant;
        }

        // 2. Subdomain of the central domain (e.g. acme.spb-pipes.com)
        if (! $tenant && ! $this->isCentralHost($host)) {
            $subdomain = explode('.', $host)[0] ?? null;
            if ($subdomain && $subdomain !== 'www') {
                $tenant = Tenant::where('slug', $subdomain)->first();
            }
        }

        // 3. Development / CLI override via query string or header
        if (! $tenant) {
            $slug = $request->query('tenant') ?? $request->header('X-Tenant');
            if ($slug) {
                $tenant = Tenant::where('slug', $slug)->first();
            }
        }

        if ($tenant) {
            app()->instance('current_tenant', $tenant);
            app()->instance('current_tenant_id', $tenant->id);
            app(PermissionRegistrar::class)->setPermissionsTeamId($tenant->id);
        } else {
            app()->instance('current_tenant', null);
            app(PermissionRegistrar::class)->setPermissionsTeamId(0);
        }

        return $next($request);
    }

    protected function isCentralHost(string $host): bool
    {
        $central = strtolower(config('saas.tenancy.central_domain', 'spb-pipes.com'));

        return strtolower($host) === $central
            || str_starts_with(strtolower($host), 'www.')
            || in_array(strtolower($host), ['localhost', '127.0.0.1', '::1'], true);
    }
}
