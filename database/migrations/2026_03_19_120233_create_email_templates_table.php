<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // Welcome Email, Booking Confirmation
            $table->string('slug')->unique();          // welcome_email, booking_confirmation
            $table->string('subject')->nullable();     // Email subject line
            $table->longText('body');                  // Email body/content (HTML)
            $table->string('category')->nullable();    // transactional, marketing, system
            $table->json('variables')->nullable();     // Available template variables
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
