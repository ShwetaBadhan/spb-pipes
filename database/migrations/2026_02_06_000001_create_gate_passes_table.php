<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gate_passes', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();
            $table->string('batch_number');
            $table->enum('type', ['inward', 'outward'])->default('inward');
            $table->date('date');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('labor_type_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('workers_count');
            $table->decimal('rate_amount', 10, 2);
            $table->decimal('total_cost', 10, 2);
            $table->text('remarks')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gate_passes');
    }
};
