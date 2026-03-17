<?php

namespace App\Http\Controllers;

use App\Models\CaptchaSetting;
use Illuminate\Http\Request;

class CaptchaSettingController extends Controller
{
    public function index()
    {
        $setting = CaptchaSetting::getInstance();
        $currentDomain = CaptchaSetting::getCurrentDomain();

        return view('admin.pages.settings.general-settings.general-settings', [
            'setting' => $setting,
            'current_domain' => $currentDomain,
            'provider' => $setting?->provider ?? 'google',
            'google_recaptcha_site_key' => $setting?->google_recaptcha_site_key,
            'google_recaptcha_secret' => $setting?->google_recaptcha_secret,
            'cloudflare_site_key' => $setting?->cloudflare_site_key,
            'cloudflare_secret' => $setting?->cloudflare_secret,
            'allowed_domain' => $setting?->allowed_domain,
            'is_active' => $setting?->is_active ?? false,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'provider' => 'required|in:google,cloudflare',
            'google_recaptcha_site_key' => 'nullable|string',
            'google_recaptcha_secret' => 'nullable|string',
            'cloudflare_site_key' => 'nullable|string',
            'cloudflare_secret' => 'nullable|string',
            'allowed_domain' => 'nullable|string',
        ]);

        // Get or create the setting
        $setting = CaptchaSetting::getInstance();
        
        if (!$setting) {
            $setting = new CaptchaSetting();
        }

        // Update settings
        $setting->provider = $request->provider;
        $setting->google_recaptcha_site_key = $request->google_recaptcha_site_key;
        $setting->google_recaptcha_secret = $request->google_recaptcha_secret;
        $setting->cloudflare_site_key = $request->cloudflare_site_key;
        $setting->cloudflare_secret = $request->cloudflare_secret;
        $setting->allowed_domain = $request->allowed_domain;

        // Check domain match and set active status
        $currentDomain = request()->getHost();
        $allowedDomain = $request->allowed_domain;

        if ($allowedDomain) {
            // Remove www. if present for comparison
            $currentDomainClean = preg_replace('/^www\./', '', $currentDomain);
            $allowedDomainClean = preg_replace('/^www\./', '', $allowedDomain);

            $setting->is_active = ($currentDomainClean === $allowedDomainClean || 
                                   $currentDomain === 'localhost' || 
                                   $currentDomain === '127.0.0.1');
        } else {
            $setting->is_active = false;
        }

        $setting->save();

        return redirect()->route('general-settings')->with('success', 'Captcha settings saved successfully!');
    }

    // Manual check domain button
    public function checkDomain()
    {
        $isActive = CaptchaSetting::isCaptchaActive();
        $currentDomain = CaptchaSetting::getCurrentDomain();
        
        return response()->json([
            'success' => true,
            'current_domain' => $currentDomain,
            'is_active' => $isActive,
            'message' => $isActive 
                ? "Domain matches! Captcha is active." 
                : "Domain does not match. Captcha is inactive."
        ]);
    }
}