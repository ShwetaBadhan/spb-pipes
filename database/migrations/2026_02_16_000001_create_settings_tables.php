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
            $table->string('tenant_id')->nullable()->index();
            $table->enum('provider', ['google', 'cloudflare'])->default('google');
            $table->string('google_recaptcha_site_key')->nullable();
            $table->string('google_recaptcha_secret')->nullable();
            $table->string('cloudflare_site_key')->nullable();
            $table->string('cloudflare_secret')->nullable();
            $table->string('allowed_domain')->nullable()->comment('Domain where captcha should be active');
            $table->boolean('is_active')->default(false)->comment('Auto-calculated based on domain match');
            $table->timestamps();
        });

        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();

            $table->string('white_logo')->nullable();
            $table->string('black_logo')->nullable();
            $table->string('single_logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('helpline_number')->nullable();

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
        Schema::dropIfExists('captcha_settings');
    }
};
