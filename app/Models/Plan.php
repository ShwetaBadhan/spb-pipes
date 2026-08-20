<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    public const LIMIT_KEYS = [
        'customers',
        'invoices',
        'products',
        'users',
        'gate_passes',
        'raw_materials',
    ];

    public const FEATURES = [
        'production' => 'Production Management',
        'labor' => 'Labor Management',
        'orders' => 'Order Management',
        'gate_passes' => 'Gate Pass Management',
        'inventory' => 'Inventory Management',
        'invoices' => 'Invoicing & Accounts',
        'purchases' => 'Purchases',
        'suppliers' => 'Suppliers',
        'finances' => 'Finances',
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'currency',
        'billing_period',
        'trial_days',
        'is_active',
        'is_default',
        'sort_order',
        'limits',
        'features',
    ];

    protected $casts = [
        'price' => 'float',
        'trial_days' => 'integer',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'sort_order' => 'integer',
        'limits' => 'array',
        'features' => 'array',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('price');
    }

    public function limit(string $key): int
    {
        $limits = $this->limits ?? [];

        return (int) ($limits[$key] ?? 0);
    }

    public function isUnlimited(string $key): bool
    {
        return $this->limit($key) < 0;
    }

    public function isFree(): bool
    {
        return (float) $this->price <= 0;
    }

    public function hasFeature(string $key): bool
    {
        if ($this->features === null) {
            return true;
        }

        return in_array($key, $this->features, true);
    }
}
