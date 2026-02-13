<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('gate_passes', function (Blueprint $table) {
            // Add columns as NULLABLE first
        
            $table->foreignId('invoice_id')->nullable()->after('customer_id')->constrained('invoices')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('gate_passes', function (Blueprint $table) {
          
            
            $table->dropForeign(['invoice_id']);
            $table->dropColumn('invoice_id');
        });
    }
};