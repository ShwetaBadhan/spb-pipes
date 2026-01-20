<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('customers', function (Blueprint $table) {
        $table->id();

        // Basic Info
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone');

        // Billing Address
        // $table->string('billing_name')->nullable();
        $table->text('billing_address')->nullable();
        // $table->string('billing_country')->nullable();
        $table->string('billing_state')->nullable();
        $table->string('billing_city')->nullable();
        $table->string('billing_pincode')->nullable();

        // Shipping Address
        // $table->string('shipping_name')->nullable();
        $table->text('shipping_address')->nullable();
        // $table->string('shipping_country')->nullable();
        $table->string('shipping_state')->nullable();
        $table->string('shipping_city')->nullable();
        $table->string('shipping_pincode')->nullable();

        // Banking
        $table->string('bank_name')->nullable();
        $table->string('branch')->nullable();
        $table->string('account_holder')->nullable();
        $table->string('account_number')->nullable();
        $table->string('ifsc')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
