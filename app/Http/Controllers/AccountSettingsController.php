<?php

namespace App\Http\Controllers;

use App\Models\AccountSetting;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AccountSettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $accountSetting = AccountSetting::where('user_id', $user->id)->first();
        $states = State::orderBy('name')->get();
        
        // Load cities if state is selected
        $cities = collect();
        if ($accountSetting?->state_id) {
            $cities = City::where('state_id', $accountSetting->state_id)->orderBy('name')->get();
        }
        
        return view('admin.pages.settings.general-settings.account-settings', compact('accountSetting', 'states', 'cities'));
    }

  public function update(Request $request)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'mobile_number' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'dob' => 'nullable|date|before:today',
            'address' => 'nullable|string|max:500',
            'state_id' => 'nullable|exists:states,id',
            'city_id' => 'nullable|exists:cities,id',
            'postal_code' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5120',
        ], [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'profile_image.image' => 'Please upload a valid image file.',
            'profile_image.max' => 'Image size should not exceed 5MB.',
        ]);

        // ✅ Find or create account settings
        $accountSetting = AccountSetting::firstOrNew(
            ['user_id' => Auth::id()], // Search condition
            ['name' => $validated['name'], 'email' => $validated['email']] // Defaults if creating
        );

        // Handle profile image upload
        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            // Delete old image if exists
            if ($accountSetting->profile_image && Storage::disk('public')->exists($accountSetting->profile_image)) {
                Storage::disk('public')->delete($accountSetting->profile_image);
            }
            // Store new image
            $validated['profile_image'] = $request->file('profile_image')->store('profile-images', 'public');
        }

        // Remove profile_image from validated array if not uploaded (prevent null override)
        if (!isset($validated['profile_image'])) {
            unset($validated['profile_image']);
        }

        // ✅ Fill and save (works for both create & update)
        $accountSetting->fill($validated);
        $accountSetting->save();

        // Update users table for name & email (sync with auth)
        $user = Auth::user();
        if ($user) {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);
        }

        // ✅ Return success with action type
        $action = $accountSetting->wasRecentlyCreated ? 'created' : 'updated';
        return back()->with('success', 'Account settings ' . $action . ' successfully.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::warning('Validation failed: ' . json_encode($e->errors()));
        return back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        Log::error('Account Settings Save Error: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
            'user_id' => Auth::id(),
        ]);
        return back()->with('error', 'Something went wrong. Please try again.');
    }
}
    public function getCitiesByState($stateId)
    {
        try {
            $cities = City::where('state_id', $stateId)
                ->orderBy('name')
                ->get(['id', 'name']);
            
            return response()->json($cities);
        } catch (\Exception $e) {
            Log::error('Error fetching cities: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load cities'], 500);
        }
    }

    public function deleteProfileImage(Request $request)
    {
        try {
            $accountSetting = AccountSetting::where('user_id', Auth::id())->first();
            
            if ($accountSetting?->profile_image) {
                if (Storage::disk('public')->exists($accountSetting->profile_image)) {
                    Storage::disk('public')->delete($accountSetting->profile_image);
                }
                $accountSetting->update(['profile_image' => null]);
            }
            
            return back()->with('success', 'Profile image removed successfully.');
        } catch (\Exception $e) {
            Log::error('Delete Image Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to remove image.');
        }
    }
}