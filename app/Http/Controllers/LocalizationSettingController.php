<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LocalizationSetting;
use Illuminate\Http\Request;

class LocalizationSettingController extends Controller
{
    /**
     * Show the form for editing the settings.
     */
    public function index()
    {
        // Fetch the existing settings if they exist
        $settings = LocalizationSetting::first();
        
        return view('admin.pages.settings.website-settings.localization-settings', compact('settings'));
    }

    /**
     * Update or Create the settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'time_zone' => 'required|string',
            'start_week' => 'required|string',
            'date_format' => 'required|string',
            'time_format' => 'required|string',
            'default_language' => 'required|string',
            'language_switcher' => 'nullable|boolean',
            'currency' => 'required|string',
            'currency_symbol' => 'required|string',
            'currency_position' => 'required|string',
            'decimal_separator' => 'required|string',
            'thousand_separator' => 'required|string',
        ]);

        // Handle checkbox (if not checked, it won't be in request, so default to false)
        $validated['language_switcher'] = $request->has('language_switcher');

        // Logic: If exists update, else create
        $setting = LocalizationSetting::first();

        if ($setting) {
            // Update existing
            $setting->update($validated);
            $message = 'Settings updated successfully.';
        } else {
            // Create new
            LocalizationSetting::create($validated);
            $message = 'Settings created successfully.';
        }

        return redirect()->back()->with('success', $message);
    }
}