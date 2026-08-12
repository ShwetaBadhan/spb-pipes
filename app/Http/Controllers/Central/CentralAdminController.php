<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\CentralAdmin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class CentralAdminController extends Controller
{
    public function index(): View
    {
        $admins = CentralAdmin::orderByDesc('created_at')->get();

        return view('central.admins', compact('admins'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:central_admins,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        CentralAdmin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_superadmin' => $request->boolean('is_superadmin'),
            'is_active' => true,
        ]);

        return redirect()->route('central.admins.index')->with('status', 'Admin user created.');
    }

    public function toggle(CentralAdmin $admin): RedirectResponse
    {
        if ($admin->id === auth('central')->id()) {
            return back()->withErrors(['admin' => 'You cannot deactivate your own account.']);
        }

        $admin->update(['is_active' => ! $admin->is_active]);

        return redirect()->route('central.admins.index')->with('status', 'Admin status updated.');
    }

    public function destroy(CentralAdmin $admin): RedirectResponse
    {
        if ($admin->id === auth('central')->id()) {
            return back()->withErrors(['admin' => 'You cannot delete your own account.']);
        }

        $admin->delete();

        return redirect()->route('central.admins.index')->with('status', 'Admin user deleted.');
    }
}
