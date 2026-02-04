<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->string('reference_number')->nullable();
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('created_by');
            
            // Amounts
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total_tax', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2);
            
            // Tax configuration
            $table->enum('tax_type', ['none', 'gst_5', 'gst_12', 'gst_18', 'gst_28', 'cgst_sgst', 'igst'])->default('none');
            
            // Status
            $table->enum('status', ['draft', 'sent', 'paid', 'unpaid', 'cancelled', 'partially_paid'])->default('draft');
            
            // Additional info
            $table->text('notes')->nullable();
            
            $table->boolean('round_off')->default(true);
            $table->decimal('round_off_amount', 10, 2)->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};