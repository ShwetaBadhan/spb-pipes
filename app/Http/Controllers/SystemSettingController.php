<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SystemSettingController extends Controller
{
    public function index()
    {
        $setting = SystemSetting::getInstance();

        return view('admin.pages.settings.system-settings', [
            'setting' => $setting,
            'white_logo' => $setting?->white_logo,
            'black_logo' => $setting?->black_logo,
            'single_logo' => $setting?->single_logo,
            'favicon' => $setting?->favicon,
            'cover_image' => $setting?->cover_image,
            'helpline_number' => $setting?->helpline_number,
            'company_name' => $setting?->company_name,
            'company_email' => $setting?->company_email,
            'company_location' => $setting?->company_location,
            'company_phone' => $setting?->company_phone,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            // Logos
            'white_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'black_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'single_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'favicon' => 'nullable|image|mimes:png,ico|max:512',
            'cover_image' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            
            // Contact
            'helpline_number' => 'nullable|string|max:50',
            
            // Company Info
            'company_name' => 'nullable|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'company_location' => 'nullable|string|max:500',
            'company_phone' => 'nullable|string|max:50',
        ]);

        $setting = SystemSetting::getInstance();
        
        if (!$setting) {
            $setting = new SystemSetting();
        }

        // Handle File Uploads
        if ($request->hasFile('white_logo')) {
            $this->deleteOldFile($setting->white_logo);
            $setting->white_logo = $request->file('white_logo')->store('logos', 'public');
        }

        if ($request->hasFile('black_logo')) {
            $this->deleteOldFile($setting->black_logo);
            $setting->black_logo = $request->file('black_logo')->store('logos', 'public');
        }

        if ($request->hasFile('single_logo')) {
            $this->deleteOldFile($setting->single_logo);
            $setting->single_logo = $request->file('single_logo')->store('logos', 'public');
        }

        if ($request->hasFile('favicon')) {
            $this->deleteOldFile($setting->favicon);
            $setting->favicon = $request->file('favicon')->store('logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $this->deleteOldFile($setting->cover_image);
            $setting->cover_image = $request->file('cover_image')->store('covers', 'public');
        }

        // Update Text Fields
        $setting->helpline_number = $request->helpline_number;
        $setting->company_name = $request->company_name;
        $setting->company_email = $request->company_email;
        $setting->company_location = $request->company_location;
        $setting->company_phone = $request->company_phone;

        $setting->save();

        return redirect()->route('settings.system-settings')->with('success', 'System settings updated successfully!');
    }

    private function deleteOldFile($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function removeImage(Request $request, $type)
    {
        $setting = SystemSetting::getInstance();
        
        if (!$setting) {
            return response()->json(['success' => false, 'message' => 'No settings found']);
        }

        $validTypes = ['white_logo', 'black_logo', 'single_logo', 'favicon', 'cover_image'];
        
        if (!in_array($type, $validTypes)) {
            return response()->json(['success' => false, 'message' => 'Invalid image type']);
        }

        $this->deleteOldFile($setting->$type);
        $setting->$type = null;
        $setting->save();

        return response()->json([
            'success' => true, 
            'message' => ucfirst(str_replace('_', ' ', $type)) . ' removed successfully!'
        ]);
    }
}