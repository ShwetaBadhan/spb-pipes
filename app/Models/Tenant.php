<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains, LogsActivity;

    protected $fillable = [
        'name',
        'domain',
        'admin_name',
        'admin_email',
        'admin_password',
        'plan_id',
        'subscription_status',
        'is_suspended',
        'trial_ends_at',
        'subscription_ends_at',
        'data',
        'last_login_at'
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
        'is_suspended' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'plan_id', 'subscription_status', 'is_suspended'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'tenant_id', 'id');
    }

    public function activeSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class, 'tenant_id', 'id')
            ->whereIn('status', [Subscription::STATUS_TRIALING, Subscription::STATUS_ACTIVE])
            ->latestOfMany();
    }

    public function latestSubscription()
    {
        return $this->hasOne(Subscription::class, 'tenant_id', 'id')->latestOfMany();
    }

    public function payments()
    {
        return $this->hasMany(SubscriptionPayment::class, 'tenant_id', 'id');
    }

    public function paidPayments()
    {
        return $this->hasMany(SubscriptionPayment::class, 'tenant_id', 'id')
            ->where('status', SubscriptionPayment::STATUS_PAID);
    }

    public function failedPayments()
    {
        return $this->hasMany(SubscriptionPayment::class, 'tenant_id', 'id')
            ->where('status', SubscriptionPayment::STATUS_FAILED);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'tenant_id', 'id');
    }

    public function activityLogs()
    {
        return $this->hasMany(TenantActivityLog::class, 'tenant_id', 'id');
    }

    public function latestActivity()
    {
        return $this->hasOne(TenantActivityLog::class, 'tenant_id', 'id')->latestOfMany();
    }

    public function isSuspended(): bool
    {
        return $this->is_suspended;
    }

    public function isTrialActive(): bool
    {
        return $this->subscription_status === 'trialing'
            && $this->trial_ends_at
            && $this->trial_ends_at->isFuture();
    }

    public function usersCount(): int
    {
        return $this->users()->count();
    }
}
