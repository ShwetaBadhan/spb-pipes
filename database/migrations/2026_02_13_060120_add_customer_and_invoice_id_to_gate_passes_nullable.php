<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('gate_passes', function (Blueprint $table) {
            // Add customer_id FIRST (required before using 'after')
            $table->foreignId('customer_id')
                  ->nullable()
                  ->constrained('customers')
                  ->onDelete('set null');

            // Now add invoice_id AFTER customer_id
            $table->foreignId('invoice_id')
                  ->nullable()
                  ->after('customer_id')
                  ->constrained('invoices')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('gate_passes', function (Blueprint $table) {
            // Drop foreign keys FIRST (reverse order of creation)
            $table->dropForeign(['invoice_id']);
            $table->dropForeign(['customer_id']);

            // Then drop columns
            $table->dropColumn('invoice_id');
            $table->dropColumn('customer_id');
        });
    }
};