<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Subscription extends Model
{
    use HasFactory, LogsActivity;

    public const STATUS_TRIALING = 'trialing';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_PENDING = 'pending';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_PAST_DUE = 'past_due';
    public const STATUS_PAUSED = 'paused';
    public const STATUS_INCOMPLETE = 'incomplete';

    public const ALL_STATUSES = [
        self::STATUS_TRIALING,
        self::STATUS_ACTIVE,
        self::STATUS_PENDING,
        self::STATUS_EXPIRED,
        self::STATUS_CANCELED,
        self::STATUS_PAST_DUE,
        self::STATUS_PAUSED,
        self::STATUS_INCOMPLETE,
    ];

    public const STATUS_COLORS = [
        self::STATUS_TRIALING => 'info',
        self::STATUS_ACTIVE => 'success',
        self::STATUS_PENDING => 'warning',
        self::STATUS_EXPIRED => 'secondary',
        self::STATUS_CANCELED => 'danger',
        self::STATUS_PAST_DUE => 'danger',
        self::STATUS_PAUSED => 'warning',
        self::STATUS_INCOMPLETE => 'secondary',
    ];

    protected $fillable = [
        'tenant_id',
        'plan_id',
        'status',
        'starts_at',
        'ends_at',
        'cancelled_at',
        'next_billing_at',
        'gateway',
        'gateway_subscription_id',
        'meta',
        'notes',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'next_billing_at' => 'datetime',
        'meta' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'plan_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function payments()
    {
        return $this->hasMany(SubscriptionPayment::class);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', [self::STATUS_TRIALING, self::STATUS_ACTIVE]);
    }

    public function scopeForTenant($query, string $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeNotCanceled($query)
    {
        return $query->where('status', '!=', self::STATUS_CANCELED);
    }

    public function isActive(): bool
    {
        return in_array($this->status, [self::STATUS_TRIALING, self::STATUS_ACTIVE], true);
    }

    public function isTrialing(): bool
    {
        return $this->status === self::STATUS_TRIALING;
    }

    public function isPaused(): bool
    {
        return $this->status === self::STATUS_PAUSED;
    }

    public function isIncomplete(): bool
    {
        return $this->status === self::STATUS_INCOMPLETE;
    }

    public function isCanceled(): bool
    {
        return $this->status === self::STATUS_CANCELED;
    }

    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED;
    }

    public function statusColor(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'secondary';
    }

    public function amount(): float
    {
        return $this->plan?->price ?? 0;
    }

    public function limitOverride(string $key): ?int
    {
        $meta = $this->meta ?? [];

        return array_key_exists($key, $meta['limit_overrides'] ?? [])
            ? (int) $meta['limit_overrides'][$key]
            : null;
    }

    public function cancel(): self
    {
        $this->update([
            'status' => self::STATUS_CANCELED,
            'cancelled_at' => now(),
        ]);

        return $this;
    }

    public function resume(): self
    {
        $this->update([
            'status' => self::STATUS_ACTIVE,
            'cancelled_at' => null,
        ]);

        return $this;
    }

    public function pause(): self
    {
        $this->update(['status' => self::STATUS_PAUSED]);

        return $this;
    }

    public function extend(int $days): self
    {
        $this->update([
            'ends_at' => $this->ends_at?->addDays($days),
        ]);

        return $this;
    }
}
