<?php

// database/migrations/xxxx_create_ledgers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('transaction_type'); // payment_received, refund, adjustment
            $table->decimal('debit', 15, 2)->default(0); // Amount owed (invoice created)
            $table->decimal('credit', 15, 2)->default(0); // Amount paid
            $table->decimal('balance', 15, 2)->default(0); // Running balance
            
            $table->string('reference_type')->nullable(); // payment, refund
            $table->bigInteger('reference_id')->nullable();
            $table->string('payment_mode')->nullable(); // cash, bank_transfer, upi, card, cheque
            $table->string('transaction_id')->nullable(); // UPI/Bank reference
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ledgers');
    }
};
