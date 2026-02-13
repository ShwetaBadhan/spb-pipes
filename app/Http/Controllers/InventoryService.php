<?php

namespace App\Services;

use App\Models\ProductVariant;
use App\Models\InventoryLog;
use App\Models\RawMaterial;

class InventoryService
{
  // app/Services/InventoryService.php

public static function productAvailableQty($productId)
{
    // ✅ Get original quantity from variants
    $product = \App\Models\Product::with('variants')->find($productId);
    $originalQty = $product ? $product->variants->sum('quantity') : 0;
    
    // ✅ Get all inventory logs for this product
    $logs = \App\Models\InventoryLog::where('item_type', 'product')
        ->where('product_id', $productId)
        ->get();
    
    // ✅ Calculate adjustments from logs
    $totalIn = $logs->where('status', 'stock_in')->sum('quantity');
    $totalOut = $logs->where('status', 'stock_out')->sum('quantity');
    
    // ✅ Available = Original + Stock In - Stock Out
    $available = $originalQty + $totalIn - $totalOut;
    
    return max(0, $available);
}

public static function rawAvailableQty($rawId)
{
    // For raw materials, you might not have original quantity
    // So available is just from logs
    $logs = \App\Models\InventoryLog::where('item_type', 'raw_material')
        ->where('raw_material_id', $rawId)
        ->get();
    
    $totalIn = $logs->where('status', 'stock_in')->sum('quantity');
    $totalOut = $logs->where('status', 'stock_out')->sum('quantity');
    
    $available = $totalIn - $totalOut;
    
    return max(0, $available);
}
}
