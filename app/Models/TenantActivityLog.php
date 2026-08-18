<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantActivityLog extends Model
{
    protected $table = 'tenant_activity_log';

    protected $fillable = [
        'tenant_id',
        'user_id',
        'user_type',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }

    public function scopeForTenant($query, string $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeByAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    public static function log(string $tenantId, string $action, string $description, array $meta = []): self
    {
        return static::create([
            'tenant_id' => $tenantId,
            'user_id' => auth('central')->id(),
            'user_type' => CentralAdmin::class,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'meta' => $meta,
        ]);
    }
}
