<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('billing_invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->string('transaction_id')->nullable();
            $table->string('provider')->default('stripe'); // stripe | razorpay | manual
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('currency', 3)->default('usd');
            $table->string('status')->default('pending'); // pending | completed | failed | refunded
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
