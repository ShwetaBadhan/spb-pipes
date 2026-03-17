<?php
// app/Http/Controllers/IntegrationSettingController.php

namespace App\Http\Controllers;

use App\Models\IntegrationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IntegrationSettingController extends Controller
{
    // Centralized integration definitions
    private function getIntegrationsList()
    {
        return [
            'gmail' => [
                'name' => 'Gmail',
                'icon' => 'assets/img/icons/mail-icon.svg',
                'description' => 'Send invoices, payment reminders and customer communication directly',
                'requires_oauth' => true,
                'config_fields' => ['email', 'access_token', 'refresh_token'],
            ],
            'google_calendar' => [
                'name' => 'Google Calendar',
                'icon' => 'assets/img/icons/calender-icon.svg',
                'description' => 'Automatically schedule invoice due dates and set up payment follow-up.',
                'requires_oauth' => true,
                'config_fields' => ['calendar_id', 'access_token', 'refresh_token'],
            ],
            // Add more integrations here easily
            // 'slack' => [...],
            // 'zapier' => [...],
        ];
    }

    /**
     * Display integrations settings page
     */
    public function index()
    {
        $user = Auth::user();
        $integrationsList = $this->getIntegrationsList();
        
        // Fetch user's integration settings
        $userIntegrations = IntegrationSetting::where('user_id', $user->id)
            ->get()
            ->keyBy('integration_key');
        
        // Build data for view with defaults
        $integrationData = collect($integrationsList)->map(function($config, $key) use ($userIntegrations) {
            $setting = $userIntegrations->get($key);
            
            return [
                'key' => $key,
                'name' => $config['name'],
                'icon' => $config['icon'],
                'description' => $config['description'],
                'is_enabled' => $setting?->is_enabled ?? false,
                'is_connected' => $setting?->connected_at !== null,
                'connected_at' => $setting?->connected_at,
                'config_data' => $setting?->config_data ?? [],
                'requires_oauth' => $config['requires_oauth'] ?? false,
            ];
        });
        
        return view('admin.pages.settings.general-settings.integrations-settings', 
            compact('integrationData'));
    }

    /**
     * Toggle integration enabled/disabled - Update if exists, Create if not
     */
    public function toggle(Request $request, $integrationKey)
    {
        $request->validate([
            'enabled' => 'required|boolean',
        ]);
        
        $integrationsList = $this->getIntegrationsList();
        if (!isset($integrationsList[$integrationKey])) {
            return back()->with('error', 'Invalid integration.');
        }
        
        $user = Auth::user();
        
        // ✅ LOGIC: Update if exists, Create if not
        $setting = IntegrationSetting::updateOrCreate(
            [
                'user_id' => $user->id,
                'integration_key' => $integrationKey,
            ],
            [
                'integration_name' => $integrationsList[$integrationKey]['name'],
                'icon_path' => $integrationsList[$integrationKey]['icon'],
                'description' => $integrationsList[$integrationKey]['description'],
                'is_enabled' => $request->boolean('enabled'),
            ]
        );
        
        // If enabling and not connected, redirect to OAuth flow (optional)
        if ($request->boolean('enabled') && !$setting->connected_at && $integrationsList[$integrationKey]['requires_oauth']) {
            // return redirect()->route('integrations.oauth.start', ['provider' => $integrationKey]);
        }
        
        return back()->with('success', $setting->is_enabled ? 'Integration enabled.' : 'Integration disabled.');
    }

    /**
     * Remove/Delete integration connection
     */
    public function remove(Request $request, $integrationKey)
    {
        $user = Auth::user();
        
        $setting = IntegrationSetting::where('user_id', $user->id)
            ->where('integration_key', $integrationKey)
            ->first();
        
        if (!$setting) {
            return back()->with('error', 'Integration not found.');
        }
        
        // Soft delete: just disable and clear connection data
        $setting->update([
            'is_enabled' => false,
            'connected_at' => null,
            'config_data' => null, // Clear tokens/keys
            'last_synced_at' => null,
        ]);
        
        return back()->with('success', 'Integration removed successfully.');
    }

    /**
     * Connect integration (OAuth callback handler - placeholder)
     */
    public function connectCallback(Request $request, $integrationKey)
    {
        // This would handle OAuth callback from Google/Gmail
        // Store tokens in config_data, set connected_at
        
        $user = Auth::user();
        
        IntegrationSetting::updateOrCreate(
            [
                'user_id' => $user->id,
                'integration_key' => $integrationKey,
            ],
            [
                'is_enabled' => true,
                'connected_at' => now(),
                'config_data' => [
                    'access_token' => $request->input('access_token'),
                    'refresh_token' => $request->input('refresh_token'),
                    'expires_at' => $request->input('expires_in') ? now()->addSeconds($request->input('expires_in')) : null,
                ],
            ]
        );
        
        return redirect()->route('integrations-settings')
            ->with('success', 'Integration connected successfully!');
    }
    public function connect($integrationKey)
{
    $integrationsList = $this->getIntegrationsList();
    
    if (!isset($integrationsList[$integrationKey])) {
        return back()->with('error', 'Invalid integration.');
    }
    
    // For Gmail/Google Calendar - redirect to Google OAuth
    // This is a placeholder - implement actual OAuth flow
    return redirect()->away('https://accounts.google.com/o/oauth2/auth?' . http_build_query([
        'client_id' => config('services.google.client_id'),
        'redirect_uri' => route('integrations-settings.callback', $integrationKey),
        'response_type' => 'code',
        'scope' => $integrationKey === 'gmail' 
            ? 'https://www.googleapis.com/auth/gmail.send'
            : 'https://www.googleapis.com/auth/calendar',
        'access_type' => 'offline',
        'prompt' => 'consent',
    ]));
}
}