<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'provider',
        'name',
        'logo',
        'config',
        'is_active',
        'is_connected',
        'description',
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
        'is_connected' => 'boolean',
    ];

    /**
     * Get or create email provider
     */
    public static function getOrCreate($provider, $data = [])
    {
        return static::firstOrCreate(
            ['provider' => $provider],
            $data
        );
    }

    /**
     * Get default email providers
     */
    public static function getDefaultProviders()
    {
        return [
            [
                'provider' => 'php_mailer',
                'name' => 'PHP Mailer',
                'logo' => 'assets/img/settings/phpmail.svg',
                'description' => 'Used to send emails safely and easily via PHP code from a web server.',
                'config' => [
                    'mail_host' => '',
                    'mail_port' => '',
                    'mail_username' => '',
                    'mail_password' => '',
                    'mail_encryption' => 'tls',
                    'mail_from_address' => '',
                    'mail_from_name' => '',
                ],
            ],
            [
                'provider' => 'smtp',
                'name' => 'SMTP',
                'logo' => 'assets/img/settings/smtp.svg',
                'description' => 'SMTP is used to send, relay or forward messages from a mail client.',
                'config' => [
                    'mail_host' => '',
                    'mail_port' => '',
                    'mail_username' => '',
                    'mail_password' => '',
                    'mail_encryption' => 'tls',
                    'mail_from_address' => '',
                    'mail_from_name' => '',
                ],
            ],
            [
                'provider' => 'sendgrid',
                'name' => 'SendGrid',
                'logo' => 'assets/img/settings/sendgrid.svg',
                'description' => 'Cloud-based email marketing tool that assists marketers and developers.',
                'config' => [
                    'api_key' => '',
                    'from_email' => '',
                    'from_name' => '',
                ],
            ],
        ];
    }

    /**
     * Initialize default providers
     */
    public static function initializeDefaults()
    {
        $defaults = self::getDefaultProviders();
        
        foreach ($defaults as $provider) {
            self::getOrCreate($provider['provider'], $provider);
        }
    }

    /**
     * Get config value
     */
    public function getConfigValue($key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }
}
