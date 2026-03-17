<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceModeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaintenanceModeController extends Controller
{
    public function index()
    {
        // Use the static helper to get or create the setting
        $setting = MaintenanceModeSetting::getOrCreate();
        return view('admin.pages.settings.website-settings.maintenance-mode', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'meta_description' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        // Get or create the singleton record
        $setting = MaintenanceModeSetting::getOrCreate();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($setting->image_path && Storage::exists('public/' . $setting->image_path)) {
                Storage::delete('public/' . $setting->image_path);
            }

            $path = $request->file('image')->store('maintenance-mode', 'public');
            $setting->image_path = $path;
        }

        // Update fields
        $setting->meta_description = $validated['meta_description'];
        $setting->is_active = $request->has('is_active');

        $setting->save();

        return redirect()->back()->with('success', 'Maintenance mode settings updated successfully.');
    }
}