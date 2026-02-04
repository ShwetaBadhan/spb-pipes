<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoice_taxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->string('tax_name');
            $table->string('tax_type'); // cgst, sgst, igst, gst
            $table->decimal('tax_rate', 5, 2);
            $table->decimal('taxable_amount', 10, 2);
            $table->decimal('tax_amount', 10, 2);
            $table->timestamps();
            
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice_taxes');
    }
};