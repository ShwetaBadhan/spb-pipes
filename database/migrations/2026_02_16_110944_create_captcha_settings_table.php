<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('captcha_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('provider', ['google', 'cloudflare'])->default('google');
            $table->string('google_recaptcha_site_key')->nullable();
            $table->string('google_recaptcha_secret')->nullable();
            $table->string('cloudflare_site_key')->nullable();
            $table->string('cloudflare_secret')->nullable();
            $table->string('allowed_domain')->nullable()->comment('Domain where captcha should be active');
            $table->boolean('is_active')->default(false)->comment('Auto-calculated based on domain match');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('captcha_settings');
    }
};