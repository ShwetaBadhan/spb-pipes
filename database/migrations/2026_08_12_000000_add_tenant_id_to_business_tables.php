<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = [
        'account_deactivations',
        'account_settings',
        'bank_accounts',
        'captcha_settings',
        'categories',
        'cities',
        'currencies',
        'customers',
        'email_settings',
        'email_templates',
        'gate_passes',
        'gdpr_cookies',
        'integration_settings',
        'inventory_logs',
        'invoice_items',
        'invoice_settings',
        'invoice_taxes',
        'invoices',
        'labor_cost_assignments',
        'labor_types',
        'languages',
        'ledgers',
        'localization_settings',
        'maintenance_mode_settings',
        'model_has_permissions',
        'model_has_roles',
        'notification_settings',
        'order_items',
        'orders',
        'payment_methods',
        'permissions',
        'product_images',
        'product_variants',
        'production_batches',
        'production_consumptions',
        'production_recipes',
        'production_rules',
        'products',
        'rate_types',
        'raw_materials',
        'role_has_permissions',
        'roles',
        'security_settings',
        'states',
        'system_settings',
        'tax_groups',
        'tax_rates',
        'units',
        'user_devices',
        'work_types',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table) || Schema::hasColumn($table, 'tenant_id')) {
                continue;
            }

            Schema::table($table, function (Blueprint $table) {
                $table->string('tenant_id')->nullable()->index();
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'tenant_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('tenant_id');
                });
            }
        }
    }
};
