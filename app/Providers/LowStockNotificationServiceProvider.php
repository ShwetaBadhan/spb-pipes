<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Services\InventoryService;
use App\Models\Product;
use App\Models\RawMaterial;

class LowStockNotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('layouts.admin', function ($view) { // ← Replace 'layouts.admin' with your actual layout name
            $lowStockItems = collect();

            // Low stock products
            $products = Product::with('variants')->get()->filter(function ($p) {
    $available = InventoryService::productAvailableQty($p->id);
    $minAlert = $p->variants->min('alert_quantity') ?? 0;
    return $minAlert > 0 && $available <= $minAlert;
});
            foreach ($products as $product) {
                $available = InventoryService::productAvailableQty($product->id);
                $minAlert = $product->variants->min('alert_quantity') ?? 0;
                if ($minAlert > 0 && $available <= $minAlert) {
                    $lowStockItems->push([
                        'type' => 'product',
                        'name' => $product->name,
                        'available' => $available,
                        'threshold' => $minAlert,
                        'status' => $available <= 0 ? 'Out of Stock' : 'Low Stock',
                        'url' => route('inventory.index'),
                    ]);
                }
            }

            // Low stock raw materials
            $raws = RawMaterial::all();
            foreach ($raws as $raw) {
                $available = InventoryService::rawAvailableQty($raw->id);
                $minStock = $raw->min_stock ?? 0;
                if ($minStock > 0 && $available <= $minStock) {
                    $lowStockItems->push([
                        'type' => 'raw_material',
                        'name' => $raw->material_name,
                        'available' => $available,
                        'threshold' => $minStock,
                        'status' => $available <= 0 ? 'Out of Stock' : 'Low Stock',
                        'url' => route('inventory.index'),
                    ]);
                }
            }

            $view->with('lowStockNotifications', $lowStockItems->take(5)); // Show max 5
        });
    }
}