<?php

use App\Http\Controllers\Central\CentralAuthController;
use App\Http\Controllers\Central\TenantController;
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

Route::get('/', function () {
    if (! in_array(request()->getHost(), config('tenancy.central_domains'))) {
        return redirect('/login');
    }

    return view('central.landing');
})->name('home');

Route::get('/admin/login', [CentralAuthController::class, 'showLoginForm'])->name('central.login');
Route::post('/admin/login', [CentralAuthController::class, 'login'])->name('central.login.submit');
Route::post('/admin/logout', [CentralAuthController::class, 'logout'])->name('central.logout');

Route::get('/admin/forgot-password', [CentralAuthController::class, 'showForgotPasswordForm'])->name('central.password.request');
Route::post('/admin/forgot-password', [CentralAuthController::class, 'sendResetLink'])->name('central.password.email');
Route::get('/admin/reset-password/{token}', [CentralAuthController::class, 'showResetPasswordForm'])->name('central.password.reset');
Route::post('/admin/reset-password', [CentralAuthController::class, 'resetPassword'])->name('central.password.update');

Route::middleware(['auth:central', 'central', 'superadmin'])->prefix('admin')->name('central.')->group(function () {
    Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
    Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
    Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->name('tenants.destroy');
});
