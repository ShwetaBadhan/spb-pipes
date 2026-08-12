<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'browser_name',
        'last_active',
    ];

    protected $casts = [
        'last_active' => 'datetime',
    ];
}