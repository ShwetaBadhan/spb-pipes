<?php

namespace Database\Seeders;

use App\Models\Addon;
use App\Models\Plan;
use App\Models\SuperAdmin;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SaasSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSuperAdmin();
        $this->seedPlans();
        $this->seedAddons();
        $this->seedDevTenant();
    }

    protected function seedSuperAdmin(): void
    {
        $email = env('SUPER_ADMIN_EMAIL', 'admin@spb-pipes.com');
        $password = env('SUPER_ADMIN_PASSWORD', 'password');

        SuperAdmin::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Super Admin',
                'password' => Hash::make($password),
                'is_active' => true,
            ]
        );

        if (env('APP_ENV') !== 'production' && ! env('SUPER_ADMIN_PASSWORD')) {
            $this->command?->warn('Super admin created with default password "password" — set SUPER_ADMIN_PASSWORD in production.');
        }
    }

    protected function seedPlans(): void
    {
        foreach (config('saas.plans') as $slug => $data) {
            Plan::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'price_monthly' => $data['price_monthly'],
                    'description' => null,
                    'max_users' => $data['max_users'],
                    'max_products' => $data['max_products'],
                    'max_invoices_per_month' => $data['max_invoices_per_month'],
                    'max_storage_mb' => $data['max_storage_mb'],
                    'features' => $data['features'],
                    'trial_days' => $data['trial_days'],
                    'stripe_price_id' => config("saas.subscription.stripe_price_ids.{$slug}"),
                    'is_active' => true,
                ]
            );
        }
    }

    protected function seedAddons(): void
    {
        foreach (config('saas.addons') as $slug => $data) {
            Addon::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'price_monthly' => $data['price_monthly'],
                    'feature' => $data['feature'] ?? null,
                    'is_active' => true,
                ]
            );
        }
    }

    protected function seedDevTenant(): void
    {
        if (! app()->environment('local')) {
            return;
        }

        $pro = Plan::where('slug', 'pro')->first();

        $tenant = Tenant::firstOrCreate(
            ['slug' => 'demo'],
            [
                'name' => 'Demo Company',
                'email' => 'demo@example.com',
                'status' => 'active',
                'plan_id' => $pro?->id,
                'plan_slug' => $pro?->slug,
                'primary_color' => '#003366',
            ]
        );

        User::firstOrCreate(
            ['email' => 'owner@demo.test'],
            [
                'name' => 'Demo Owner',
                'tenant_id' => $tenant->id,
                'password' => Hash::make('password'),
            ]
        );
    }
}
