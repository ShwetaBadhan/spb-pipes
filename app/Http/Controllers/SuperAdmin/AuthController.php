<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SuperAdmin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('super-admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $admin = SuperAdmin::where('email', $credentials['email'])->first();

        if (! $admin || ! $admin->is_active || ! Hash::check($credentials['password'], $admin->password)) {
            return back()
                ->withInput()
                ->with('error', 'Invalid credentials or account disabled.');
        }

        Auth::guard('super_admin')->login($admin, $request->boolean('remember'));

        return redirect()->intended(route('super-admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('super_admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('super-admin.login');
    }
}
