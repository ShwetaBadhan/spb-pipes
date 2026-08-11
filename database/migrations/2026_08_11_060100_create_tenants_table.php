<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('status')->default('trial'); // trial | active | suspended | canceled
            $table->string('plan_slug')->nullable(); // starter | pro | business | enterprise
            $table->foreignId('plan_id')->nullable()->constrained('plans')->nullOnDelete();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('trial_started_at')->nullable();
            $table->timestamp('suspended_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('primary_color', 20)->nullable()->default('#003366');
            $table->json('settings')->nullable();
            // Laravel Cashier (billable) columns
            $table->string('stripe_id')->nullable()->index();
            $table->string('pm_type')->nullable();
            $table->string('pm_last_four', 4)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
