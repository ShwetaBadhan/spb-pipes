<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'name',
        'code',
        'symbol',
        'exchange_rate',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'exchange_rate' => 'decimal:4',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    // When setting a currency as default, unset others
    public static function setDefault($id)
    {
        static::where('is_default', true)->update(['is_default' => false]);
        static::findOrFail($id)->update(['is_default' => true]);
    }
}