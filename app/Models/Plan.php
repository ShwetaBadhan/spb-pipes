<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price_monthly',
        'description',
        'max_users',
        'max_products',
        'max_invoices_per_month',
        'max_storage_mb',
        'features',
        'trial_days',
        'stripe_price_id',
        'is_active',
    ];

    protected $casts = [
        'price_monthly' => 'float',
        'max_users' => 'integer',
        'max_products' => 'integer',
        'max_invoices_per_month' => 'integer',
        'max_storage_mb' => 'integer',
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }

    public function hasFeature(string $feature): bool
    {
        return in_array($feature, $this->features ?? [], true);
    }
}
