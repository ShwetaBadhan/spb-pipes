<?php

namespace App\Http\Controllers;

use App\Models\SecuritySetting;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class SecuritySettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $settings = SecuritySetting::firstOrCreate(
            ['user_id' => $user->id],
            ['is_2fa_enabled' => false, 'is_google_enabled' => false]
        );
        
        // Use correct column name and fallback if missing
        $orderByColumn = Schema::hasColumn('user_devices', 'last_active') ? 'last_active' : 'created_at';
        
        $devices = UserDevice::where('user_id', $user->id)
            ->orderBy($orderByColumn, 'desc')
            ->get();
        
        return view('admin.pages.settings.general-settings.security-settings', 
            compact('user', 'settings', 'devices'));
    }

public function updateSettings(Request $request)
{
    $validated = $request->validate([
        'is_2fa_enabled' => 'sometimes|boolean',
        'is_google_enabled' => 'sometimes|boolean',
        'phone_number' => 'sometimes|nullable|string',
    ]);

    // ✅ Default unchecked boxes to false
    $validated['is_2fa_enabled'] = $validated['is_2fa_enabled'] ?? false;
    $validated['is_google_enabled'] = $validated['is_google_enabled'] ?? false;

    SecuritySetting::updateOrCreate(
        ['user_id' => Auth::id()], 
        $validated
    );

    return back()->with('success', 'Security settings updated successfully.');
}

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->password_changed_at = Carbon::now(); // ✅ Carbon instance
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }

    public function updatePhone(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'password' => 'required|current_password',
        ]);

        SecuritySetting::updateOrCreate(
            ['user_id' => Auth::id()],
            ['phone_number' => $request->phone_number, 'phone_verified_at' => null]
        );

        return back()->with('success', 'Phone number updated. Please verify.');
    }

    public function removePhone(Request $request)
    {
        SecuritySetting::where('user_id', Auth::id())->update([
            'phone_number' => null,
            'phone_verified_at' => null,
        ]);

        return back()->with('success', 'Phone number removed.');
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'required|current_password',
        ]);

        $user = Auth::user();
        $user->email = $request->email;
        $user->email_verified_at = null;
        $user->save();

        if (method_exists($user, 'sendEmailVerificationNotification')) {
            $user->sendEmailVerificationNotification();
        }

        return back()->with('success', 'Email updated. Please check your inbox to verify.');
    }

   public function deactivateAccount(Request $request)
{
    $request->validate([
        'deactivate_reason' => 'required|in:taking_break,privacy,too_many_emails,found_alternative,other',
        'deactivate_note' => 'nullable|string|max:500',
        'confirmation_password' => 'required|current_password',
    ]);

    $user = Auth::user();
    
    // Optional: Log the deactivation reason for analytics
    // Log::info('User deactivated account', [
    //     'user_id' => $user->id,
    //     'reason' => $request->deactivate_reason,
    //     'note' => $request->deactivate_note,
    // ]);

    $user->deactivated_at = Carbon::now();
    $user->save();

    Auth::logout();
    
    return redirect()->route('login')->with('info', 'Account deactivated. Sign in anytime to reactivate.');
}

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'confirmation_password' => 'required|current_password',
        ]);

        Auth::user()->delete();
        Auth::logout();
        
        return redirect()->route('login')->with('error', 'Account has been permanently deleted.');
    }
    
    public function deleteDevice($deviceId)
    {
        UserDevice::where('id', $deviceId)
            ->where('user_id', Auth::id())
            ->delete();
            
        return back()->with('success', 'Device session removed.');
    }
}