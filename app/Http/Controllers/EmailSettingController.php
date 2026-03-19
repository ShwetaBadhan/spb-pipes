<?php

namespace App\Http\Controllers;

use App\Models\EmailSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailSettingController extends Controller
{
    public function index()
    {
        EmailSetting::initializeDefaults();
        $emailSettings = EmailSetting::all();
        return view('admin.pages.settings.system-settings.email-settings', compact('emailSettings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider' => 'required|string|unique:email_settings,provider',
            'name' => 'required|string|max:255',
            'logo' => 'nullable|string',
            'description' => 'nullable|string',
            'config' => 'required|array',
            'is_active' => 'nullable|boolean',
        ]);

        $config = $validated['config'];
        foreach (['mail_password', 'api_key', 'secret'] as $sensitive) {
            if (!empty($config[$sensitive])) {
                $config[$sensitive] = Crypt::encryptString($config[$sensitive]);
            }
        }

        $emailSetting = EmailSetting::create([
            'provider' => $validated['provider'],
            'name' => $validated['name'],
            'logo' => $validated['logo'] ?? null,
            'description' => $validated['description'] ?? null,
            'config' => $config,
            'is_active' => $request->has('is_active'),
            'is_connected' => $this->checkConnection($validated['provider'], $config),
        ]);

        return redirect()->back()->with('success', "{$emailSetting->name} configured successfully!");
    }

    public function update(Request $request, $id)
    {
        $emailSetting = EmailSetting::findOrFail($id);

        $validated = $request->validate([
            'config' => 'required|array',
            'is_active' => 'nullable|boolean',
        ]);

        $config = $emailSetting->config ?? [];
        $newConfig = $validated['config'];

        foreach (['mail_password', 'api_key', 'secret'] as $sensitive) {
            if (!empty($newConfig[$sensitive])) {
                $config[$sensitive] = Crypt::encryptString($newConfig[$sensitive]);
            } elseif (empty($newConfig[$sensitive]) && !empty($config[$sensitive])) {
                // Keep existing
            } else {
                $config[$sensitive] = null;
            }
        }

        foreach ($newConfig as $key => $value) {
            if (!in_array($key, ['mail_password', 'api_key', 'secret'])) {
                $config[$key] = $value;
            }
        }

        $emailSetting->update([
            'config' => $config,
            'is_active' => $request->has('is_active'),
            'is_connected' => $this->checkConnection($emailSetting->provider, $config),
        ]);

        return redirect()->back()->with('success', "{$emailSetting->name} updated successfully!");
    }

    // ✅ FIXED: Added Request parameter
    public function toggleStatus(Request $request, $id)
    {
        $emailSetting = EmailSetting::findOrFail($id);
        
        // If activating, ensure it's connected first
        if (!$emailSetting->is_connected && $request->has('is_active')) {
            return redirect()->back()->with('error', "Cannot activate {$emailSetting->name}. Please configure it first.");
        }

        $emailSetting->update(['is_active' => $request->has('is_active')]);
        
        $status = $emailSetting->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "{$emailSetting->name} {$status}!");
    }

    public function destroy($id)
    {
        $emailSetting = EmailSetting::findOrFail($id);
        
        $activeCount = EmailSetting::where('is_active', true)->count();
        if ($emailSetting->is_active && $activeCount <= 1) {
            return redirect()->back()->with('error', 'Cannot delete the only active email provider!');
        }

        $emailSetting->delete();
        return redirect()->back()->with('success', 'Email provider deleted successfully!');
    }

    public function sendTestEmail(Request $request, $id)
    {
        $emailSetting = EmailSetting::findOrFail($id);
        
        $validated = $request->validate([
            'to_email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            Log::info("Test email sent via {$emailSetting->name} to {$validated['to_email']}");
            return redirect()->back()->with('success', 'Test email sent successfully!');
        } catch (\Exception $e) {
            Log::error('Test email failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }

    private function checkConnection($provider, $config)
    {
        switch ($provider) {
            case 'php_mailer':
            case 'smtp':
                return !empty($config['mail_host']) && 
                       !empty($config['mail_port']) && 
                       !empty($config['mail_username']) && 
                       !empty($config['mail_password']);
            
            case 'sendgrid':
                return !empty($config['api_key']) && !empty($config['from_email']);
            
            default:
                return false;
        }
    }
}