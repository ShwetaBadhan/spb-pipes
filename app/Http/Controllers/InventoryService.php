<?php

namespace App\Services;

use App\Models\ProductVariant;
use App\Models\InventoryLog;
use App\Models\RawMaterial;

class InventoryService
{
    public static function productAvailableQty($productId)
    {
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
}
