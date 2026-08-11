<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = app('current_tenant');

        if (! $tenant) {
            abort(404, 'Tenant not found.');
        }

        if ($tenant->isSuspended()) {
            abort(403, 'Your account has been suspended. Please contact support.');
        }

        return $next($request);
    }
}
