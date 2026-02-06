<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('gate_passes', function (Blueprint $table) {
            $table->enum('type', ['inward', 'outward'])->default('inward')->after('batch_number');
        });
    }

    public function down()
    {
        Schema::table('gate_passes', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};