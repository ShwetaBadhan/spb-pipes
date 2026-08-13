<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
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

    // 👉 Auto-login from a one-time signed token (issued after landing-page signup)
    public function loginAs(string $token)
    {
        try {
            $payload = json_decode(Crypt::decryptString($token), true) ?? [];
        } catch (\Throwable $e) {
            $payload = [];
        }

        if (empty($payload['uid']) || (int) ($payload['exp'] ?? 0) < now()->timestamp) {
            return redirect()->route('login')->withErrors([
                'email' => 'This login link is invalid or has expired.',
            ]);
        }

        $cachedUid = Cache::store()->pull("auth.login.{$token}");

        if ($cachedUid !== null && (int) $cachedUid !== (int) $payload['uid']) {
            return redirect()->route('login')->withErrors([
                'email' => 'This login link is invalid or has expired.',
            ]);
        }

        $user = User::query()->find((int) $payload['uid']);

        if (! $user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Account not found.',
            ]);
        }

        Auth::login($user);

        $next = $payload['next'] ?? '/dashboard';

        if (! is_string($next) || ! str_starts_with($next, '/') || str_starts_with($next, '//')) {
            $next = '/dashboard';
        }

        return redirect()->to($next);
    }
}
