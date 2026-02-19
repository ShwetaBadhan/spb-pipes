<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $table = 'system_settings';

    protected $fillable = [
        'white_logo',
        'black_logo',
        'single_logo',
        'favicon',
        'cover_image',
        'helpline_number',
        'company_name',
        'company_email',
        'company_location',
        'company_phone',
    ];

    // Get the first (and should be only) system setting
    public static function getInstance()
    {
        return self::first();
    }

    // Helper to get a setting value
    public static function get($key, $default = null)
    {
        $setting = self::getInstance();
        return $setting ? ($setting->$key ?? $default) : $default;
    }
}