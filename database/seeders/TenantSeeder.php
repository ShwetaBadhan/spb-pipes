<?php

namespace Database\Seeders;

use App\Listeners\ProvisionTenantAdmin;
use App\Models\Plan;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Stancl\Tenancy\Events\TenantCreated;

class TenantSeeder extends Seeder
{
    public int $count = 10;

    public function run(): void
    {
        if (Plan::query()->count() === 0) {
            $this->call(PlanSeeder::class);
        }

        $tenants = Tenant::factory()
            ->count($this->count)
            ->create();

        $provisioner = app(ProvisionTenantAdmin::class);

        $tenants->each(function (Tenant $tenant) use ($provisioner) {
            $hasAdmin = User::query()->where('tenant_id', $tenant->id)->exists();

            if (! $hasAdmin && filled($tenant->admin_email)) {
                $provisioner->handle(new TenantCreated($tenant));
            }
        });
    }
}
