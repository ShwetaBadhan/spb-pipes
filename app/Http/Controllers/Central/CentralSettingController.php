<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\CentralSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CentralSettingController extends Controller
{
    private const FIELDS = [
        'platform_name' => 'text',
        'support_email' => 'email',
        'support_phone' => 'text',
        'company_address' => 'text',
        'default_currency' => 'text',
    ];

    public function index(): View
    {
        $settings = CentralSetting::all()->pluck('value', 'key');

        return view('central.settings', [
            'fields' => self::FIELDS,
            'settings' => $settings,
            'gateways' => ['stripe', 'razorpay'],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        foreach (self::FIELDS as $key => $type) {
            $rule = $type === 'email' ? ['nullable', 'email'] : ['nullable', 'string', 'max:255'];

            $request->validate([$key => $rule]);

            CentralSetting::set($key, $request->input($key));
        }

        foreach (['stripe', 'razorpay'] as $gateway) {
            $request->validate([
                "{$gateway}.key" => ['nullable', 'string'],
                "{$gateway}.secret" => ['nullable', 'string'],
                "{$gateway}.webhook_secret" => ['nullable', 'string'],
            ]);

            CentralSetting::set($gateway, array_filter([
                'key' => $request->input("{$gateway}.key"),
                'secret' => $request->input("{$gateway}.secret"),
                'webhook_secret' => $request->input("{$gateway}.webhook_secret"),
            ]));
        }

        return back()->with('status', 'Central settings updated.');
    }
}
