<?php

use App\Http\Controllers\SuperAdmin\AddonController;
use App\Http\Controllers\SuperAdmin\AuthController;
use App\Http\Controllers\SuperAdmin\AuditController;
use App\Http\Controllers\SuperAdmin\BillingController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\SuperAdmin\ReportController;
use App\Http\Controllers\SuperAdmin\SettingController;
use App\Http\Controllers\SuperAdmin\SubscriptionController;
use App\Http\Controllers\SuperAdmin\TenantController;
use Illuminate\Support\Facades\Route;

Route::prefix('super-admin')
    ->name('super-admin.')
    ->group(function (): void {

        Route::middleware('guest:super_admin')->group(function (): void {
            Route::get('login', [AuthController::class, 'showLogin'])->name('login');
            Route::post('login', [AuthController::class, 'login']);
        });

        Route::middleware('auth:super_admin')->group(function (): void {
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');

            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

            Route::resource('tenants', TenantController::class)->except(['destroy']);
            Route::patch('tenants/{tenant}/suspend', [TenantController::class, 'suspend'])->name('tenants.suspend');
            Route::patch('tenants/{tenant}/reactivate', [TenantController::class, 'reactivate'])->name('tenants.reactivate');
            Route::patch('tenants/{tenant}/change-plan', [TenantController::class, 'changePlan'])->name('tenants.change-plan');
            Route::get('tenants/{tenant}/domains', [TenantController::class, 'domains'])->name('tenants.domains');
            Route::post('tenants/{tenant}/domains', [TenantController::class, 'storeDomain'])->name('tenants.domains.store');
            Route::patch('tenants/{tenant}/domains/{domain}/verify', [TenantController::class, 'verifyDomain'])->name('tenants.domains.verify');
            Route::delete('tenants/{tenant}/domains/{domain}', [TenantController::class, 'destroyDomain'])->name('tenants.domains.destroy');

            Route::resource('plans', PlanController::class);

            Route::resource('addons', AddonController::class);

            Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
            Route::get('subscriptions/{subscription}', [SubscriptionController::class, 'show'])->name('subscriptions.show');

            Route::get('billing', [BillingController::class, 'index'])->name('billing.index');

            Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

            Route::get('audit-logs', [AuditController::class, 'index'])->name('audit-logs.index');

            Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
            Route::post('settings/maintenance', [SettingController::class, 'toggleMaintenance'])->name('settings.maintenance');
        });
    });
