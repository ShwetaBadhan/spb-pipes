<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
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

        // Define all permissions by module
        $permissions = [
            // ========== Dashboard ==========
            'view-dashboard',

            // ========== Quick Actions (Mini Sidebar) ==========
            'create-invoices',
            'create-expenses',
            'create-purchase-orders',
            'manage-settings',
            'view-documentation',

            // ========== Inventory & Sales - Products ==========
            'view-products',
            'manage-products',
            'manage-category',
            'manage-units',

            // ========== Inventory & Sales - Production ==========
            'manage-production',
            'manage-production-rules',
            'manage-production-batches',
            'manage-bom',
            'add-production-rules',

            // ========== Inventory & Sales - Raw Materials & Inventory ==========
            'manage-raw-materials',
            'view-inventory',

            // ========== Inventory & Sales - Accounts ==========
            'manage-invoices',
            'view-invoices',
            'create-invoices',

            // ========== Inventory & Sales - Customers ==========
            'manage-customers',
            'view-customers',
            'view-customer-details',
            'view-inventory-sales',

            // ========== Order Management ==========
            'manage-orders',
            'view-orders',
            'create-orders',
            'view-order-management',

            // ========== Gate Pass Management ==========
            'manage-gate-passes',
            'view-gate-passes',
            'create-gate-passes',
            'view-management',

            // ========== Costing - Labor Management ==========
            'manage-labor',
            'manage-work-types',
            'manage-rate-types',
            'manage-labor-types',
            'manage-labor-assignments',
            'view-labor-history',
            'view-labor-reports',
            'view-costing',

            // ========== Manage Users ==========
            'manage-users',
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            'manage-roles',
            'manage-permissions',
            'view-manage',

            // ========== Administration - Settings ==========
            'manage-settings',
            'edit-general-settings',
            'edit-system-settings',
            'view-administration',

            // ========== Purchases (Commented Section - Optional) ==========
            'view-purchases',
            'manage-purchases',
            'manage-purchase-orders',
            'manage-suppliers',
            'create-supplier-payments',

            // ========== Finance & Accounts (Commented Section - Optional) ==========
            'manage-expenses',
            'manage-incomes',
            'manage-payments',
            'view-transactions',
            'manage-bank-accounts',
            'create-money-transfer',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $this->command->info('All permissions created successfully!');

        // ========== Create Roles ==========
        $this->createRoles();
    }

    /**
     * Create roles and assign permissions
     */
    private function createRoles(): void
    {
        // Super Admin - All Permissions
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->syncPermissions(Permission::all());

        // Admin - Most Permissions (except system settings)
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $adminPermissions = Permission::whereNotIn('name', [
            'edit-system-settings',
            'manage-permissions',
        ])->get();
        $admin->syncPermissions($adminPermissions);

        // Manager - Operational Permissions
        $manager = Role::firstOrCreate(['name' => 'Manager']);
        $managerPermissions = Permission::whereIn('name', [
            'view-dashboard',
            'view-products',
            'manage-products',
            'manage-category',
            'manage-units',
            'manage-production',
            'manage-production-rules',
            'manage-production-batches',
            'manage-bom',
            'manage-raw-materials',
            'view-inventory',
            'manage-invoices',
            'view-invoices',
            'create-invoices',
            'manage-customers',
            'view-customers',
            'view-customer-details',
            'manage-orders',
            'view-orders',
            'create-orders',
            'manage-gate-passes',
            'view-gate-passes',
            'create-gate-passes',
            'manage-labor',
            'manage-work-types',
            'manage-rate-types',
            'manage-labor-types',
            'manage-labor-assignments',
            'view-labor-history',
            'view-labor-reports',
            'view-users',
            'edit-general-settings',
        ])->get();
        $manager->syncPermissions($managerPermissions);

        // Inventory Staff - Inventory Related Only
        $inventoryStaff = Role::firstOrCreate(['name' => 'Inventory Staff']);
        $inventoryPermissions = Permission::whereIn('name', [
            'view-dashboard',
            'view-products',
            'manage-products',
            'manage-category',
            'manage-units',
            'manage-raw-materials',
            'view-inventory',
            'manage-production',
            'manage-production-batches',
            'view-gate-passes',
        ])->get();
        $inventoryStaff->syncPermissions($inventoryPermissions);

        // Sales Staff - Sales & Orders Related
        $salesStaff = Role::firstOrCreate(['name' => 'Sales Staff']);
        $salesPermissions = Permission::whereIn('name', [
            'view-dashboard',
            'view-products',
            'manage-invoices',
            'view-invoices',
            'create-invoices',
            'manage-customers',
            'view-customers',
            'view-customer-details',
            'manage-orders',
            'view-orders',
            'create-orders',
        ])->get();
        $salesStaff->syncPermissions($salesPermissions);

        // Labor Staff - Labor Management Only
        $laborStaff = Role::firstOrCreate(['name' => 'Labor Staff']);
        $laborPermissions = Permission::whereIn('name', [
            'view-dashboard',
            'manage-labor',
            'manage-work-types',
            'manage-rate-types',
            'manage-labor-types',
            'manage-labor-assignments',
            'view-labor-history',
            'view-labor-reports',
        ])->get();
        $laborStaff->syncPermissions($laborPermissions);

        // Viewer - Read Only Access
        $viewer = Role::firstOrCreate(['name' => 'Viewer']);
        $viewerPermissions = Permission::whereIn('name', [
            'view-dashboard',
            'view-products',
            'view-inventory',
            'view-invoices',
            'view-customers',
            'view-orders',
            'view-gate-passes',
            'view-labor-history',
            'view-labor-reports',
            'view-users',
            'view-transactions',
        ])->get();
        $viewer->syncPermissions($viewerPermissions);

        $this->command->info('All roles created and permissions assigned!');
    }
}