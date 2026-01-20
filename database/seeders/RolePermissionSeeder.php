<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $admin   = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $staff   = Role::firstOrCreate(['name' => 'Staff', 'guard_name' => 'web']);
        $manager = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);

        // Admin → all permissions
        $admin->syncPermissions(Permission::all());

        // Manager → limited permissions
        $manager->syncPermissions([
            'dashboard',
            'view-purchase',
            'view-inventory',
            'view-product',
            'view-category',
            'view-unit',
        ]);

        // Staff → very limited permissions
        $staff->syncPermissions([
            'dashboard',
            'view-product',
            'view-category',
            'view-unit',
        ]);
    }
}
