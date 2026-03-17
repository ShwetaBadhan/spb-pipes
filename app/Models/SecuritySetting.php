<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecuritySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_2fa_enabled',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'is_google_enabled',
        'google_id',
        'phone_number',
        'phone_verified_at',
    ];

    protected $casts = [
        'is_2fa_enabled' => 'boolean',
        'is_google_enabled' => 'boolean',
        'phone_verified_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
