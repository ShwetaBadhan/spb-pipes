<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('admin_name')->nullable()->after('updated_at');
            $table->string('admin_email')->nullable()->after('admin_name');
            $table->string('admin_password')->nullable()->after('admin_email');
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['admin_name', 'admin_email', 'admin_password']);
        });
    }
};
