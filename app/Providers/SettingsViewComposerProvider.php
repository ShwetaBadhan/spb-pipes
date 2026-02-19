<?php

namespace App\Providers;

use App\Models\SystemSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SettingsViewComposerProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Share system settings with all views
        View::composer('*', function ($view) {
            $setting = SystemSetting::getInstance();
            
            $view->with([
                'system_white_logo' => $setting?->white_logo,
                'system_black_logo' => $setting?->black_logo,
                'system_single_logo' => $setting?->single_logo,
                'system_favicon' => $setting?->favicon,
                'system_cover_image' => $setting?->cover_image,
                'system_helpline_number' => $setting?->helpline_number,
                'system_company_name' => $setting?->company_name,
                'system_company_email' => $setting?->company_email,
                'system_company_location' => $setting?->company_location,
                'system_company_phone' => $setting?->company_phone,
            ]);
        });
    }
}