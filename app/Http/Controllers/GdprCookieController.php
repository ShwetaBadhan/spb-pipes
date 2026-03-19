<?php

namespace App\Http\Controllers;

use App\Models\GdprCookie;
use Illuminate\Http\Request;

class GdprCookieController extends Controller
{
    /**
     * Display GDPR cookies settings
     */
    public function index()
    {
        $gdprSettings = GdprCookie::getOrCreate();
        return view('admin.pages.settings.system-settings.gdpr-cookies', compact('gdprSettings'));
    }

    /**
     * Store or update GDPR cookies settings
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cookie_position' => 'required|string|in:left,right,bottom,top',
            'agree_button_text' => 'required|string|max:100',
            'decline_button_text' => 'nullable|string|max:100',
            'show_decline_button' => 'nullable|boolean',
            'cookie_content' => 'nullable|string',
            'cookies_page_link' => 'nullable|url|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        // Get or create settings (singleton - only one record)
        $gdprSettings = GdprCookie::getOrCreate();

        $gdprSettings->update([
            'cookie_position' => $validated['cookie_position'],
            'agree_button_text' => $validated['agree_button_text'],
            'decline_button_text' => $validated['decline_button_text'] ?? 'Decline',
            'show_decline_button' => $request->has('show_decline_button'),
            'cookie_content' => $validated['cookie_content'] ?? null,
            'cookies_page_link' => $validated['cookies_page_link'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'GDPR cookie settings updated successfully!');
    }

    /**
     * Toggle GDPR cookies active status
     */
    public function toggleStatus()
    {
        $gdprSettings = GdprCookie::getOrCreate();
        $gdprSettings->update(['is_active' => !$gdprSettings->is_active]);

        $status = $gdprSettings->is_active ? 'enabled' : 'disabled';
        return redirect()->back()->with('success', "GDPR cookies {$status}!");
    }
}
