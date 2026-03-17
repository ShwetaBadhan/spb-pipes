<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountSetting extends Model
{
    use HasFactory;

    protected $table = 'account_settings';

    protected $fillable = [
        'user_id',
        'profile_image',
        'name',
        'email',
        'mobile_number',
        'gender',
        'dob',
        'address',
        'state_id',
        'city_id',
        'postal_code'
    ];

    protected $casts = [
        'dob' => 'date',
        'state_id' => 'integer',
        'city_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    // Accessor for profile image URL
    public function getProfileImageUrlAttribute(): string
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return asset('assets/img/users/user-01.jpg');
    }
}