<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\ProductionBatch;

use Illuminate\Support\ServiceProvider;

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
        
    // Make batches available in all views (sidebar)
    $batches = ProductionBatch::all();
    View::share('batches', $batches);

    }
}
