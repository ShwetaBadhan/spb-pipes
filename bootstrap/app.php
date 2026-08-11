<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (): void {
            Route::middleware('web')
                ->group(base_path('routes/super-admin.php'));

            // Stripe webhook: outside the "web" group so it is CSRF-exempt;
            // signature verification happens in the controller constructor.
            Route::post(
                'stripe/webhook',
                [App\Http\Controllers\StripeWebhookController::class, 'handleWebhook']
            )->name('stripe.webhook');

            // Cashier's payment confirmation page (3DS / SCA retry flow).
            Route::get(
                'stripe/payment/{id}',
                [Laravel\Cashier\Http\Controllers\PaymentController::class, 'show']
            )->name('cashier.payment');
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Resolve the current tenant from the request host before every request
        $middleware->prepend(\App\Http\Middleware\IdentifyTenant::class);

        $middleware->alias([
            'tenant' => \App\Http\Middleware\EnsureTenantActive::class,
            'tenant.feature' => \App\Http\Middleware\EnsureTenantFeature::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
