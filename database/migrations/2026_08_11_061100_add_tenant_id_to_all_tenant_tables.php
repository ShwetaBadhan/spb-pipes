<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $tenantTables = [
        'products',
        'product_images',
        'product_variants',
        'categories',
        'units',
        'customers',
        'inventory_logs',
        'raw_materials',
        'production_rules',
        'production_batches',
        'production_recipes',
        'production_consumptions',
        'labor_types',
        'rate_types',
        'work_types',
        'labor_cost_assignments',
        'orders',
        'order_items',
        'invoices',
        'invoice_items',
        'invoice_taxes',
        'gate_passes',
        'currencies',
        'tax_rates',
        'tax_groups',
        'payment_methods',
        'bank_accounts',
        'email_settings',
        'email_templates',
        'system_settings',
        'account_settings',
        'security_settings',
        'notification_settings',
        'integration_settings',
        'localization_settings',
        'languages',
        'maintenance_mode_settings',
        'invoice_settings',
        'gdpr_cookies',
        'ledgers',
        'user_devices',
        'captcha_settings',
    ];

    public function up(): void
    {
        foreach ($this->tenantTables as $table) {
            if (! Schema::hasColumn($table, 'tenant_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->foreignId('tenant_id')->nullable()->after('id')->constrained()->nullOnDelete();
                    $table->index('tenant_id');
                });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tenantTables as $table) {
            if (Schema::hasColumn($table, 'tenant_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropConstrainedForeignId('tenant_id');
                });
            }
        }
    }
};
