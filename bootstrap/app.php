<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'central' => \App\Http\Middleware\EnsureCentralRequest::class,
            'superadmin' => \App\Http\Middleware\EnsureSuperAdmin::class,
            'central.only' => \App\Http\Middleware\PreventAccessFromTenantDomains::class,
            'subscription.active' => \App\Http\Middleware\EnsureActiveSubscription::class,
            'tenant.feature' => \App\Http\Middleware\EnsureTenantFeature::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'billing/webhook/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedOnDomainException $e) {
            if (in_array(request()->getHost(), config('tenancy.central_domains', []))) {
                return null;
            }

            return response()->view('errors.tenant-not-found', [], 404);
        });
    })->create();
