<?php

namespace App\Models;
use App\Traits\BelongsToTenant;

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