<?php

namespace App\Http\Middleware;

use App\Services\PlanService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return $next($request);
        }

        $excludedRoutes = [
            'billing.plans-billings',
            'billing.checkout',
            'billing.return',
            'billing.razorpay.verify',
            'subscription.required',
            'logout',
            'account-settings',
            'account-settings.update',
            'account-settings.cities',
            'account-settings.image.delete',
        ];

        $routeName = $request->route()?->getName();

        if ($routeName && in_array($routeName, $excludedRoutes, true)) {
            return $next($request);
        }

        $planService = PlanService::for();

        if ($planService->status() === null || in_array($planService->status(), ['trialing', 'active'], true)) {
            return $next($request);
        }

        return redirect()->route('subscription.required');
    }
}
