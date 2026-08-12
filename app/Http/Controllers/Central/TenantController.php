<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantController extends Controller
{
    public function index(): View
    {
        $tenants = Tenant::with('domains')->orderByDesc('created_at')->get();

        return view('central.tenants.index', compact('tenants'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'id' => ['required', 'alpha_dash', 'max:32', 'unique:tenants,id'],
            'subdomain' => ['required', 'regex:/^[a-z0-9]([a-z0-9\-]*[a-z0-9])?$/', 'max:32'],
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'admin_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $domain = $data['subdomain'] . '.localhost';

        if (\Stancl\Tenancy\Database\Models\Domain::where('domain', $domain)->exists()) {
            return back()->withErrors(['subdomain' => 'This subdomain is already taken.'])->withInput();
        }

        $tenant = Tenant::create([
            'id' => $data['id'],
            'name' => $data['name'],
            'domain' => $domain,
            'admin_name' => $data['admin_name'],
            'admin_email' => $data['admin_email'],
            'admin_password' => $data['admin_password'],
        ]);

        $tenant->domains()->create(['domain' => $domain]);

        return redirect()->route('central.tenants.index')->with('status', 'Tenant created.');
    }

    public function destroy(Tenant $tenant): RedirectResponse
    {
        $tenant->domains()->delete();
        $tenant->delete();

        return redirect()->route('central.tenants.index')->with('status', 'Tenant deleted.');
    }
}
