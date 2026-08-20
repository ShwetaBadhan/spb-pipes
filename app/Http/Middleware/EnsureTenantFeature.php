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
        $planService = PlanService::for();

        if ($planService->hasFeature($feature)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'This feature is not available in your current plan.'], 403);
        }

        return redirect()->route('subscription.required')->with('error', "The \"{$feature}\" feature is not available in your current plan. Please upgrade to access it.");
    }
}
