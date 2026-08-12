<?php

namespace Database\Seeders;

use App\Services\TenantPermissionSeeder;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        (new TenantPermissionSeeder)->run();

        $this->command->info('All permissions and roles created successfully!');
    }
}
