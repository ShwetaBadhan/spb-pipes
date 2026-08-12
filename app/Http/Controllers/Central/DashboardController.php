<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\CentralAdmin;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $tenants = Tenant::with('domains')->orderByDesc('created_at')->get();

        $stats = [
            'tenants' => $tenants->count(),
            'domains' => $tenants->flatMap(fn ($tenant) => $tenant->domains)->count(),
            'admins' => CentralAdmin::count(),
            'tenant_users' => User::whereNotNull('tenant_id')->count(),
        ];

        return view('central.dashboard', compact('tenants', 'stats'));
    }
}
