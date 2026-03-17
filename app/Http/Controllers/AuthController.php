<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemSetting; //
class AuthController extends Controller
{
    // 👉 GET login page
    public function login()
    {
         $settings = SystemSetting::getInstance(); 
        return view('admin.auth.login', [
            'system_favicon' => $settings?->favicon,
            'system_white_logo' => $settings?->white_logo,
            'cover_image' => $settings?->cover_image,
        ]);
    }

    // 👉 POST login form
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {

            // inactive user check
            if (!auth()->user()->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is inactive'
                ]);
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
