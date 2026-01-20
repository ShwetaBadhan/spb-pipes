<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id','size','color','type',
        'selling_price','purchase_price',
        'quantity','alert_quantity'
    ];

    // ✅ Correct relationship: inventory_logs uses product_variant_id
    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class, 'product_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

