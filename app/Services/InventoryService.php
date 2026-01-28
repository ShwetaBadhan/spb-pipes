<?php

namespace App\Services;

use App\Models\ProductVariant;
use App\Models\InventoryLog;
use App\Models\RawMaterial;
use App\Models\Product;

class InventoryService
{
public static function productAvailableQty($productId)
{
    if (!$productId) return 0;

    $opening = ProductVariant::where('product_id', $productId)->sum('quantity');

    $in = InventoryLog::where('item_type', 'product')
        ->where('product_id', $productId)
        ->where('status', 'stock_in')
        ->sum('quantity');

    $out = InventoryLog::where('item_type', 'product')
        ->where('product_id', $productId)
        ->where('status', 'stock_out')
        ->sum('quantity');

    return max(0, $opening + $in - $out);
}

public static function rawAvailableQty($rawId)
{
    if (!$rawId) return 0;

    $in = InventoryLog::where('item_type', 'raw_material')
        ->where('raw_material_id', $rawId)
        ->where('status', 'stock_in')
        ->sum('quantity');

    $out = InventoryLog::where('item_type', 'raw_material')
        ->where('raw_material_id', $rawId)
        ->where('status', 'stock_out')
        ->sum('quantity');

    return max(0, $in - $out);
}
public static function getLowStockProducts()
{
    return Product::with(['variants', 'unit'])
        ->get()
        ->filter(function ($product) {
            $available = self::productAvailableQty($product->id);
            $minAlert = $product->variants->min('alert_quantity') ?? PHP_INT_MAX;
            return $minAlert > 0 && $available <= $minAlert;
        });
}

public static function getLowStockRawMaterials()
{
    return RawMaterial::with('unit')
        ->where('min_stock', '>', 0)
        ->get()
        ->filter(function ($raw) {
            $available = self::rawAvailableQty($raw->id);
            return $available <= $raw->min_stock;
        });
}
}
