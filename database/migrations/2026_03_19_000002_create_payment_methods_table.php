<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();
            $table->string('name');
            $table->string('slug');
            $table->string('logo')->nullable();
            $table->string('email')->nullable();
            $table->text('api_key')->nullable();
            $table->text('secret_key')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_connected')->default(false);
            $table->text('additional_data')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
