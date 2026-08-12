<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;


class TaxRate extends Model
{
    use BelongsToTenant;
    protected $fillable = ['name', 'rate', 'is_active'];
    
    protected $casts = [
        'rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}