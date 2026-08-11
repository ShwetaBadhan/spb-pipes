<?php

namespace App\Models;
use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;

class ProductionRule extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'product_id',
        'min_output',
        'max_output',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
