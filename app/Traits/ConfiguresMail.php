<?php

namespace App\Traits;

use App\Models\EmailSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log
;

trait ConfiguresMail
{
    protected function configureMailerFromSettings($provider = null)
    {
        $emailSetting = $provider 
            ? EmailSetting::where('provider', $provider)->where('is_active', true)->first()
            : EmailSetting::where('is_active', true)->first();

        if (!$emailSetting || !$emailSetting->is_connected) {
            return false;
        }

        $config = $emailSetting->config;

        // Decrypt sensitive fields
        foreach (['mail_password', 'api_key', 'secret'] as $key) {
            if (!empty($config[$key])) {
                try {
                    $config[$key] = Crypt::decryptString($config[$key]);
                } catch (\Exception $e) {
                    $config[$key] = null;
                }
            }
        }

        switch ($emailSetting->provider) {
            case 'smtp':
            case 'php_mailer':
                Config::set('mail.mailers.custom', [
                    'transport' => 'smtp',
                    'host' => $config['mail_host'],
                    'port' => $config['mail_port'],
                    'encryption' => $config['mail_encryption'] ?? 'tls',
                    'username' => $config['mail_username'],
                    'password' => $config['mail_password'],
                    'timeout' => null,
                    'local_domain' => env('MAIL_EHLO_DOMAIN'),
                ]);
                Config::set('mail.default', 'custom');
                break;

            case 'sendgrid':
                Config::set('mail.mailers.custom', [
                    'transport' => 'api',
                    'driver' => 'sendgrid',
                    'api_key' => $config['api_key'],
                ]);
                Config::set('mail.default', 'custom');
                break;

            default:
                return false;
        }

        Config::set('mail.from.address', $config['from_email'] ?? env('MAIL_FROM_ADDRESS'));
        Config::set('mail.from.name', $config['from_name'] ?? env('MAIL_FROM_NAME', 'Invoice System'));

       // At the end of configureMailerFromSettings(), after the switch statement:

// ✅ CRITICAL: Set from address from config (not env fallback)
$fromEmail = $config['from_email'] ?? null;
$fromName = $config['from_name'] ?? 'Invoice System';

if ($fromEmail) {
    // Validate domain has MX records (optional but helpful)
    if (!checkdnsrr(preg_replace('/.*@/', '', $fromEmail), 'MX')) {
        Log::warning("From domain may not accept mail", ['from_email' => $fromEmail]);
        // Don't block - let SMTP server decide
    }
    
    Config::set('mail.from.address', $fromEmail);
    Config::set('mail.from.name', $fromName);
    
    Log::info('Mail from address configured', [
        'address' => $fromEmail,
        'name' => $fromName
    ]);
} else {
    Log::error('No from_email configured in email settings');
    return false;
}

return true;
        
    }
}