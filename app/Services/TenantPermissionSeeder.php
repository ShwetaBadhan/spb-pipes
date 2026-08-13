<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class TenantPermissionSeeder
{
    private const GUARD = 'web';

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->createPermissions();
        $this->createRoles();
    }

    private function createPermissions(): void
    {
        foreach ($this->permissions() as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => self::GUARD]);
        }
    }

    private function createRoles(): void
    {
        // Super Admin - All Permissions
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => self::GUARD]);
        $superAdmin->syncPermissions(Permission::all());

        // Admin - Most Permissions (except system settings)
        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => self::GUARD]);
        $adminPermissions = Permission::whereNotIn('name', [
            'edit-system-settings',
            'manage-permissions',
        ])->get();
        $admin->syncPermissions($adminPermissions);

        // Manager - Operational Permissions
        $manager = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => self::GUARD]);
        $managerPermissions = Permission::whereIn('name', [
            'view-dashboard',
            'view-plans-billing',
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
        $inventoryStaff = Role::firstOrCreate(['name' => 'Inventory Staff', 'guard_name' => self::GUARD]);
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
        $salesStaff = Role::firstOrCreate(['name' => 'Sales Staff', 'guard_name' => self::GUARD]);
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
        $laborStaff = Role::firstOrCreate(['name' => 'Labor Staff', 'guard_name' => self::GUARD]);
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
        $viewer = Role::firstOrCreate(['name' => 'Viewer', 'guard_name' => self::GUARD]);
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
    }

    public function permissions(): array
    {
        return [
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
            'view-plans-billing',

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

            // dashboard
            'view-alert-notifications',
            'view-overview-stats',
            'view-invoice-stats',
            'view-sales-stats',
            'view-total-products',
            'view-total-sales',
            'view-total-customers',
            'view-recent-orders',
        ];
    }
}
