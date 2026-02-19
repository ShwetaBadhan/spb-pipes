<?php

use App\Models\SystemSetting;

if (!function_exists('getSystemSetting')) {
    function getSystemSetting($key, $default = null)
    {
        return SystemSetting::get($key, $default);
    }
}

if (!function_exists('getLogo')) {
    function getLogo($type = 'single')
    {
        $path = SystemSetting::get($type . '_logo');
        return $path ? asset('storage/' . $path) : null;
    }
}

if (!function_exists('getFavicon')) {
    function getFavicon()
    {
        $path = SystemSetting::get('favicon');
        return $path ? asset('storage/' . $path) : asset('favicon.ico');
    }
}

if (!function_exists('getCompanyInfo')) {
    function getCompanyInfo($key)
    {
        return SystemSetting::get('company_' . $key);
    }
}