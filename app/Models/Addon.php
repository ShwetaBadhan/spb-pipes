<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Addon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price_monthly',
        'feature',
        'is_active',
    ];

    protected $casts = [
        'price_monthly' => 'float',
        'is_active' => 'boolean',
    ];

    public function tenantAddons(): HasMany
    {
        return $this->hasMany(TenantAddon::class);
    }
}
