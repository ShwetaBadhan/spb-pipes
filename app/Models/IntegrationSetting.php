<?php
// app/Models/IntegrationSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IntegrationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'integration_key',
        'integration_name',
        'icon_path',
        'description',
        'is_enabled',
        'config_data',
        'connected_at',
        'last_synced_at',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'config_data' => 'array',
        'connected_at' => 'datetime',
        'last_synced_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Helper: Check if integration is connected & enabled
    public function isActive(): bool
    {
        return $this->is_enabled && $this->connected_at !== null;
    }
}