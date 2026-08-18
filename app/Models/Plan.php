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
    ];

    protected $casts = [
        'price' => 'float',
        'trial_days' => 'integer',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'sort_order' => 'integer',
        'limits' => 'array',
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
}
