<?php

namespace App\Listeners;

use App\Mail\TenantAdminWelcome;
use App\Models\Role;
use App\Models\User;
use App\Services\TenantPermissionSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Stancl\Tenancy\Events\TenantCreated;

class ProvisionTenantAdmin
{
    public function handle(TenantCreated $event): void
    {
        $tenant = $event->tenant;

        $adminName = $tenant->admin_name ?? null;
        $adminEmail = $tenant->admin_email ?? null;
        $adminPassword = $tenant->admin_password ?? null;

        $provisioned = false;

        tenancy()->initialize($tenant);

        try {
            (new TenantPermissionSeeder)->run();

            if ($adminName && $adminEmail && $adminPassword) {
                $user = User::create([
                    'name' => $adminName,
                    'email' => $adminEmail,
                    'password' => Hash::make($adminPassword),
                    'is_active' => true,
                ]);

                $adminRole = Role::where('name', 'Admin')->first();

                if ($adminRole) {
                    $user->roles()->syncWithoutDetaching([
                        $adminRole->id => ['tenant_id' => tenant()->getTenantKey()],
                    ]);
                }

                $provisioned = true;
            }
        } catch (\Throwable $e) {
            report($e);
        } finally {
            tenancy()->end();
        }

        if ($provisioned) {
            $this->sendWelcomeEmail($tenant, $adminEmail, $adminPassword);
        }

        $this->clearStoredCredentials($tenant);
    }

    private function sendWelcomeEmail($tenant, ?string $email, ?string $password): void
    {
        $domain = $tenant->domain ?? null;

        if (! $domain || ! $email) {
            return;
        }

        try {
            $scheme = app()->environment('production') ? 'https' : 'http';
            $port = app()->environment('production') ? '' : ':8000';
            $tenantUrl = $scheme . '://' . $domain . $port;
            $loginUrl = $tenantUrl . '/login';

            Mail::to($email)->send(new TenantAdminWelcome(
                $tenant->name ?? 'Your Company',
                $tenantUrl,
                $loginUrl,
                $email,
                $password,
            ));
        } catch (\Throwable $e) {
            report($e);
        }
    }

    private function clearStoredCredentials($tenant): void
    {
        if ($tenant->admin_name === null && $tenant->admin_email === null && $tenant->admin_password === null) {
            return;
        }

        unset($tenant->admin_name, $tenant->admin_email, $tenant->admin_password);
        $tenant->save();
    }
}
