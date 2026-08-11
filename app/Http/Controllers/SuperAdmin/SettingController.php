<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $tenancy = config('saas.tenancy');

        return view('super-admin.settings.index', compact('tenancy'));
    }

    public function toggleMaintenance(Application $app): RedirectResponse
    {
        if ($app->isDownForMaintenance()) {
            \Illuminate\Support\Facades\Artisan::call('up');
            $message = 'Maintenance mode disabled.';
        } else {
            \Illuminate\Support\Facades\Artisan::call('down', [
                '--secret' => null,
            ]);
            $message = 'Maintenance mode enabled.';
        }

        return back()->with('success', $message);
    }
}
