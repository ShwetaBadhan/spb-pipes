<?php

namespace App\Http\Middleware;

use App\Services\PlanService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantFeature
{
    public function handle(Request $request, Closure $next, string $feature): Response
    {
        $tenant = currentTenant();

        if (! $tenant || ! PlanService::hasFeature($tenant, $feature)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => "Your current plan doesn't include this feature. Upgrade to unlock it."], 403);
            }

            return redirect()->route('tenant.billing')
                ->with('error', "Your current plan doesn't include this feature. Upgrade to unlock it.");
        }

        return $next($request);
    }
}
