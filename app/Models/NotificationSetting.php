<?php
// app/Models/NotificationSetting.php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationSetting extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'user_id',
        'category',
        'notification_key',
        'is_category_enabled',
        'channel_email',
        'channel_sms',
        'channel_inapp',
        'channel_whatsapp',
    ];

    protected $casts = [
        'is_category_enabled' => 'boolean',
        'channel_email' => 'boolean',
        'channel_sms' => 'boolean',
        'channel_inapp' => 'boolean',
        'channel_whatsapp' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}