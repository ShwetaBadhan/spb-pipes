<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $swaps = [
        ['users', 'users_email_unique', ['tenant_id', 'email']],
        ['roles', 'roles_name_guard_name_unique', ['tenant_id', 'name', 'guard_name']],
        ['permissions', 'permissions_name_guard_name_unique', ['tenant_id', 'name', 'guard_name']],
        ['categories', 'categories_name_unique', ['tenant_id', 'name']],
        ['categories', 'categories_slug_unique', ['tenant_id', 'slug']],
        ['customers', 'customers_email_unique', ['tenant_id', 'email']],
        ['labor_types', 'labor_types_code_unique', ['tenant_id', 'code']],
        ['work_types', 'work_types_slug_unique', ['tenant_id', 'slug']],
        ['rate_types', 'rate_types_slug_unique', ['tenant_id', 'slug']],
        ['orders', 'orders_order_number_unique', ['tenant_id', 'order_number']],
        ['invoices', 'invoices_invoice_number_unique', ['tenant_id', 'invoice_number']],
        ['production_batches', 'production_batches_batch_id_unique', ['tenant_id', 'batch_id']],
        ['integration_settings', 'integration_settings_integration_key_unique', ['tenant_id', 'integration_key']],
        ['languages', 'languages_code_unique', ['tenant_id', 'code']],
        ['payment_methods', 'payment_methods_slug_unique', ['tenant_id', 'slug']],
        ['currencies', 'currencies_code_unique', ['tenant_id', 'code']],
        ['email_settings', 'email_settings_provider_unique', ['tenant_id', 'provider']],
        ['email_templates', 'email_templates_slug_unique', ['tenant_id', 'slug']],
    ];

    private array $restore = [
        ['users', ['tenant_id', 'email'], ['email']],
        ['roles', ['tenant_id', 'name', 'guard_name'], ['name', 'guard_name']],
        ['permissions', ['tenant_id', 'name', 'guard_name'], ['name', 'guard_name']],
        ['categories', ['tenant_id', 'name'], ['name']],
        ['categories', ['tenant_id', 'slug'], ['slug']],
        ['customers', ['tenant_id', 'email'], ['email']],
        ['labor_types', ['tenant_id', 'code'], ['code']],
        ['work_types', ['tenant_id', 'slug'], ['slug']],
        ['rate_types', ['tenant_id', 'slug'], ['slug']],
        ['orders', ['tenant_id', 'order_number'], ['order_number']],
        ['invoices', ['tenant_id', 'invoice_number'], ['invoice_number']],
        ['production_batches', ['tenant_id', 'batch_id'], ['batch_id']],
        ['integration_settings', ['tenant_id', 'integration_key'], ['integration_key']],
        ['languages', ['tenant_id', 'code'], ['code']],
        ['payment_methods', ['tenant_id', 'slug'], ['slug']],
        ['currencies', ['tenant_id', 'code'], ['code']],
        ['email_settings', ['tenant_id', 'provider'], ['provider']],
        ['email_templates', ['tenant_id', 'slug'], ['slug']],
    ];

    public function up(): void
    {
        foreach ($this->swaps as [$table, $oldIndex, $columns]) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, fn (Blueprint $table) => $table->dropUnique($oldIndex));
            Schema::table($table, fn (Blueprint $table) => $table->unique($columns));
        }
    }

    public function down(): void
    {
        foreach ($this->restore as [$table, $newColumns, $oldColumns]) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $table) use ($newColumns) {
                $table->dropUnique($newColumns);
            });
            Schema::table($table, fn (Blueprint $table) => $table->unique($oldColumns));
        }
    }
};
