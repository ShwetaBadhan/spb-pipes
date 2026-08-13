<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\ProductionBatch;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Services\TenantAwarePermissionRegistrar;
use Spatie\Permission\PermissionRegistrar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(PermissionRegistrar::class, TenantAwarePermissionRegistrar::class);

        
 // ✅ Prevent DB access before migrations
        if (Schema::hasTable('production_batches')) {
            View::share('batches', ProductionBatch::all());
        } else {
            // Always define variable to avoid undefined errors in views
            View::share('batches', collect());
        }

    }
}
