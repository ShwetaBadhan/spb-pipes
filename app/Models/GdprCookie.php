<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GdprCookie extends Model
{
    protected $fillable = [
        'cookie_position',
        'agree_button_text',
        'decline_button_text',
        'show_decline_button',
        'cookie_content',
        'cookies_page_link',
        'is_active',
    ];

    protected $casts = [
        'show_decline_button' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get or create GDPR settings (singleton pattern)
     */
    public static function getOrCreate()
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
