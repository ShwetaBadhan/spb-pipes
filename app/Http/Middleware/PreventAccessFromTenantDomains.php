<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventAccessFromTenantDomains
{
    public function handle(Request $request, Closure $next): Response
    {
        $centralDomains = config('tenancy.central_domains', []);
        $host = $request->getHost();

        if (! in_array($host, $centralDomains)) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
