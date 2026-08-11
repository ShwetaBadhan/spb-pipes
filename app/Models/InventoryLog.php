<?php

// app/Models/InventoryLog.php
namespace App\Models;
use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryLog extends Model
{
    use BelongsToTenant;
    use SoftDeletes;

    protected $fillable = [
        'item_type',
        'product_id',
        'raw_material_id',
        'quantity',
        'status', // stock_in, stock_out
        
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class, 'raw_material_id');
    }

    // ✅ Helper: Get the actual item (product or raw material)
    public function getItemAttribute()
    {
        if ($this->item_type === 'product') {
            return $this->product;
        }
        return $this->rawMaterial;
    }

    // ✅ Scope for filtering by reference
    public function scopeForOrder($query, $orderNumber)
    {
        return $query->where('notes', 'like', "%Order #{$orderNumber}%");
    }
}