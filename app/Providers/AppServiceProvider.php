<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\ProductionBatch;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Spatie\Permission\PermissionRegistrar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Support/helpers.php');

        // Register our own /stripe/webhook route (CSRF-free, signature-verified)
        // instead of Cashier's default controller, so we can sync domain records.
        Cashier::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Treat Tenant records as the Cashier billable/customer model and our
        // own Subscription model as the subscription record (scoped by tenant_id).
        Cashier::useCustomerModel(Tenant::class);
        Cashier::useSubscriptionModel(Subscription::class);

        // Default to the "global" permission team (0). The IdentifyTenant
        // middleware overrides this with the resolved tenant id per request.
        if (! $this->app->bound('current_tenant_id')) {
            app(PermissionRegistrar::class)->setPermissionsTeamId(0);
        }
        
 // ✅ Prevent DB access before migrations
        if (Schema::hasTable('production_batches')) {
            View::share('batches', ProductionBatch::all());
        } else {
            // Always define variable to avoid undefined errors in views
            View::share('batches', collect());
        }

    }
}
