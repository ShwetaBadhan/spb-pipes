<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->enum('status', ['trialing', 'pending', 'active', 'expired', 'canceled', 'past_due'])->default('trialing')->change();
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->enum('status', ['trialing', 'active', 'expired', 'canceled', 'past_due'])->default('trialing')->change();
        });
    }
};
