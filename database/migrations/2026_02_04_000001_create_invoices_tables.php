<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();
            $table->string('invoice_number');
            $table->string('reference_number')->nullable();
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('created_by');

            $table->decimal('subtotal', 10, 2);
            $table->decimal('total_tax', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2);

            $table->enum('tax_type', ['none', 'gst_5', 'gst_12', 'gst_18', 'gst_28', 'cgst_sgst', 'igst'])->default('none');
            $table->boolean('enable_tax')->default(false);

            $table->enum('status', ['draft', 'sent', 'paid', 'unpaid', 'cancelled', 'partially_paid'])->default('draft');

            $table->text('notes')->nullable();

            $table->boolean('round_off')->default(true);
            $table->decimal('round_off_amount', 10, 2)->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['tenant_id', 'invoice_number']);
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();
            $table->unsignedBigInteger('invoice_id');
            $table->string('item_name');
            $table->string('item_type')->default('product');
            $table->integer('quantity');
            $table->string('unit')->default('Pcs');
            $table->decimal('rate', 10, 2);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });

        Schema::create('invoice_taxes', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();
            $table->unsignedBigInteger('invoice_id');
            $table->string('tax_name');
            $table->string('tax_type');
            $table->decimal('tax_rate', 5, 2);
            $table->decimal('taxable_amount', 10, 2);
            $table->decimal('tax_amount', 10, 2);
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_taxes');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};
