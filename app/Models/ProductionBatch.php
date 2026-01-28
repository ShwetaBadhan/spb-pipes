<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionBatch extends Model
{
    protected $fillable = [
        'product_id',
        'production_date',
        'actual_output',
        'status',
    ];

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
