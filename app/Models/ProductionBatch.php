<?php

namespace App\Models;
use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class ProductionBatch extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'batch_id',
        'product_id',
        'production_date',
        'actual_output',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($batch) {
            // Only generate if batch_id not manually provided
            if (empty($batch->batch_id) && !empty($batch->product_id)) {
                $batch->batch_id = self::generateBatchId($batch->product_id);
            }
        });
    }

    public static function generateBatchId($productId)
    {
        // Get product details
        $product = \App\Models\Product::find($productId);
        
        if (!$product) {
            throw new \Exception("Product not found for ID: {$productId}");
        }

        // Option 1: Use SKU if available (BEST)
        $productCode = !empty($product->sku) 
            ? strtoupper(Str::limit($product->sku, 10, ''))
            : strtoupper(Str::limit(Str::slug($product->name, ''), 6, '')); // Fallback to name abbreviation

        // Get today's date (YYMMDD)
        $datePrefix = now()->format('ymd');

        // Count batches for this product created today
        $todayCount = static::where('product_id', $productId)
                            ->whereDate('created_at', today())
                            ->count() + 1;

        // Format: BATCH-CHAIR-260209-001
        $sequence = str_pad($todayCount, 3, '0', STR_PAD_LEFT);

        return "BATCH-{$productCode}-{$datePrefix}-{$sequence}";
    }

    /* =====================
       RELATIONS
    ===================== */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function consumptions()
    {
        return $this->hasMany(ProductionConsumption::class, 'batch_id');
    }
}
