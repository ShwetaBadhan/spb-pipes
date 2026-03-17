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
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('category'); // general, sales, invoice, user_management
            $table->string('notification_key'); // system_updates, security_alerts, etc.
            $table->boolean('is_category_enabled')->default(true); // master toggle for category
            $table->boolean('channel_email')->default(true);
            $table->boolean('channel_sms')->default(false);
            $table->boolean('channel_inapp')->default(true);
            $table->boolean('channel_whatsapp')->default(false);
            $table->timestamps();
            
            $table->unique(['user_id', 'category', 'notification_key']);
            $table->index(['user_id', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
