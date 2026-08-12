<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;

class CaptchaSetting extends Model
{
    use BelongsToTenant;
    protected $table = 'captcha_settings';

    protected $fillable = [
        'provider',
        'google_recaptcha_site_key',
        'google_recaptcha_secret',
        'cloudflare_site_key',
        'cloudflare_secret',
        'allowed_domain',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Get the first (and should be only) captcha setting
    public static function getInstance()
    {
        return self::first();
    }

    // Check if captcha is active for current domain
    public static function isCaptchaActive()
    {
        $setting = self::getInstance();
        
        if (!$setting || !$setting->allowed_domain) {
            return false;
        }

        $currentDomain = request()->getHost();
        $allowedDomain = $setting->allowed_domain;

        // Remove www. if present for comparison
        $currentDomain = preg_replace('/^www\./', '', $currentDomain);
        $allowedDomain = preg_replace('/^www\./', '', $allowedDomain);

        // Check if domains match (exact match or subdomain match)
        $isActive = ($currentDomain === $allowedDomain || 
                     $currentDomain === 'localhost' || 
                     $currentDomain === '127.0.0.1');

        // Update the is_active status in database
        if ($setting->is_active !== $isActive) {
            $setting->update(['is_active' => $isActive]);
        }

        return $isActive;
    }

    // Get current domain
    public static function getCurrentDomain()
    {
        return request()->getHost();
    }
}