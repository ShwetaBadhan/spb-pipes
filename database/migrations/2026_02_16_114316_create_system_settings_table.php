<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            
            // Logo & Branding
            $table->string('white_logo')->nullable();
            $table->string('black_logo')->nullable();
            $table->string('single_logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('helpline_number')->nullable();
            
            // Company Information
            $table->string('company_name')->nullable();
            $table->string('company_email')->nullable();
            $table->text('company_location')->nullable();
            $table->string('company_phone')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};