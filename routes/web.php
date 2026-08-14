<?php

use App\Http\Controllers\Central\CentralAdminController;
use App\Http\Controllers\Central\CentralAuthController;
use App\Http\Controllers\Central\CentralSettingController;
use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\Central\LandingController;
use App\Http\Controllers\Central\PlanController;
use App\Http\Controllers\Central\TenantController;
use App\Http\Controllers\Central\WebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Central Routes
|--------------------------------------------------------------------------
|
| These routes only run on the central domains (localhost / 127.0.0.1).
| Tenant domains are redirected to their own login at /login.
|
*/

// Route::get('/', function () {
//     if (! in_array(request()->getHost(), config('tenancy.central_domains'))) {
//         return redirect()->to('//' . request()->getHost() . '/login');
//     }

//     return view('central.landing');
// })->name('home');

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/register', [LandingController::class, 'register'])->name('central.register');
Route::post('/register', [LandingController::class, 'store'])->name('central.register.submit');

Route::get('/admin/login', [CentralAuthController::class, 'showLoginForm'])->name('central.login');
Route::post('/admin/login', [CentralAuthController::class, 'login'])->name('central.login.submit');
Route::post('/admin/logout', [CentralAuthController::class, 'logout'])->name('central.logout');

Route::get('/admin/forgot-password', [CentralAuthController::class, 'showForgotPasswordForm'])->name('central.password.request');
Route::post('/admin/forgot-password', [CentralAuthController::class, 'sendResetLink'])->name('central.password.email');
Route::get('/admin/reset-password/{token}', [CentralAuthController::class, 'showResetPasswordForm'])->name('central.password.reset');
Route::post('/admin/reset-password', [CentralAuthController::class, 'resetPassword'])->name('central.password.update');

Route::post('/billing/webhook/stripe', [WebhookController::class, 'stripe'])->name('billing.webhook.stripe');
Route::post('/billing/webhook/razorpay', [WebhookController::class, 'razorpay'])->name('billing.webhook.razorpay');

Route::middleware(['auth:central', 'central', 'superadmin'])->prefix('admin')->name('central.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
Route::get('/tenants/{tenant}', [TenantController::class, 'show'])->name('tenants.show');
Route::get('/tenants/{tenant}/login', [TenantController::class, 'loginAs'])->name('tenants.login');
Route::get('/tenants/{tenant}/edit', [TenantController::class, 'edit'])->name('tenants.edit');
    Route::put('/tenants/{tenant}', [TenantController::class, 'update'])->name('tenants.update');
    Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->name('tenants.destroy');

    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/{plan}/edit', [PlanController::class, 'edit'])->name('plans.edit');
    Route::put('/plans/{plan}', [PlanController::class, 'update'])->name('plans.update');
    Route::patch('/plans/{plan}/toggle', [PlanController::class, 'toggle'])->name('plans.toggle');
    Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');

    Route::get('/admins', [CentralAdminController::class, 'index'])->name('admins.index');
    Route::post('/admins', [CentralAdminController::class, 'store'])->name('admins.store');
    Route::patch('/admins/{admin}/toggle', [CentralAdminController::class, 'toggle'])->name('admins.toggle');
    Route::delete('/admins/{admin}', [CentralAdminController::class, 'destroy'])->name('admins.destroy');

    Route::get('/settings', [CentralSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [CentralSettingController::class, 'update'])->name('settings.update');
});
