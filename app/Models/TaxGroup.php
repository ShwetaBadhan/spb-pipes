<?php

namespace App\Models;
use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;

class TaxGroup extends Model
{
    use BelongsToTenant;
    protected $fillable = ['name', 'sub_taxes', 'is_active'];
    
    protected $casts = [
        'sub_taxes' => 'array',
        'is_active' => 'boolean',
    ];

    // Get tax rates for this group
    public function getTaxRatesAttribute()
    {
        return TaxRate::whereIn('id', $this->sub_taxes ?? [])->get();
    }
}