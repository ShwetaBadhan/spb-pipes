<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Two Factor Auth
            $table->boolean('is_2fa_enabled')->default(false);
            $table->string('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            
            // Google Auth
            $table->boolean('is_google_enabled')->default(false);
            $table->string('google_id')->nullable();
            
            // Phone Verification
            $table->string('phone_number')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            
            $table->timestamps();
            
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_settings');
    }
};

