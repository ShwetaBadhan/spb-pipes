<?php

namespace App\Services;

use App\Models\CentralSetting;
use Illuminate\Support\Facades\Cache;

class BillingGateway
{
    public function settings(string $gateway): array
    {
        $db = CentralSetting::get($gateway, []);

        return match ($gateway) {
            'stripe' => [
                'key' => $db['key'] ?? env('STRIPE_KEY'),
                'secret' => $db['secret'] ?? env('STRIPE_SECRET'),
                'webhook_secret' => $db['webhook_secret'] ?? env('STRIPE_WEBHOOK_SECRET'),
            ],
            'razorpay' => [
                'key' => $db['key'] ?? env('RAZORPAY_KEY_ID'),
                'secret' => $db['secret'] ?? env('RAZORPAY_KEY_SECRET'),
                'webhook_secret' => $db['webhook_secret'] ?? env('RAZORPAY_WEBHOOK_SECRET'),
            ],
            default => [],
        };
    }

    public function isConfigured(string $gateway): bool
    {
        $settings = $this->settings($gateway);

        return ! empty($settings['key']) && ! empty($settings['secret']);
    }
}
