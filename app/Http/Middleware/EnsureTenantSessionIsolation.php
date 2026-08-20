<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantSessionIsolation
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = tenant();

        if ($tenant) {
            $tenantId = $tenant->getTenantKey();
            $cookieName = 'spb-pipes-session-' . $tenantId;

            config(['session.cookie' => $cookieName]);
            app('session.store')->setName($cookieName);
        }

        return $next($request);
    }
}
