<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('billing_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('stripe_invoice_id')->nullable()->unique();
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('currency', 3)->default('usd');
            $table->string('status')->default('pending'); // pending | paid | open | void | uncollectible
            $table->string('pdf_path')->nullable();
            $table->timestamp('invoice_date')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_invoices');
    }
};
