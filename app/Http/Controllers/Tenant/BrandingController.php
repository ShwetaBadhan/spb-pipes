<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Services\PlanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandingController extends Controller
{
    public function index(): View
    {
        $tenant = currentTenant();
        abort_if(! $tenant, 404);

        $hasWhiteLabel = PlanService::hasFeature($tenant, 'white_label');

        return view('admin.pages.settings.general-settings.branding', compact('tenant', 'hasWhiteLabel'));
    }

    public function update(Request $request): RedirectResponse
    {
        $tenant = currentTenant();
        abort_if(! $tenant, 404);

        if (! PlanService::hasFeature($tenant, 'white_label')) {
            return back()->with('error', 'White-label branding requires an eligible plan. Please upgrade your plan first.');
        }

        $data = $request->validate([
            'primary_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('tenant-logos', 'public');
        }

        $tenant->update($data);

        return back()->with('success', 'Branding updated.');
    }
}
