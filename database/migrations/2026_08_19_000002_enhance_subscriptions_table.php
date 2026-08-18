<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->enum('status', ['trialing', 'pending', 'active', 'expired', 'canceled', 'past_due', 'paused', 'incomplete'])->default('trialing')->change();
            $table->string('discount_type', 10)->nullable()->after('gateway_subscription_id');
            $table->decimal('discount_value', 12, 2)->nullable()->after('discount_type');
            $table->timestamp('next_billing_at')->nullable()->after('cancelled_at');
            $table->text('notes')->nullable()->after('meta');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->enum('status', ['trialing', 'pending', 'active', 'expired', 'canceled', 'past_due'])->default('trialing')->change();
            $table->dropColumn(['discount_type', 'discount_value', 'next_billing_at', 'notes']);
        });
    }
};
