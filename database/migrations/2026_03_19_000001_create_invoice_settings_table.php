<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();
            $table->string('invoice_prefix')->nullable();
            $table->string('invoice_image')->nullable();
            $table->integer('round_off_value')->default(0);
            $table->boolean('enable_round_off')->default(false);
            $table->boolean('show_company_details')->default(true);
            $table->longText('invoice_terms')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_settings');
    }
};
