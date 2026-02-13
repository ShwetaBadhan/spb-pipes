<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ledgers', function (Blueprint $table) {
            // 1. Drop existing foreign key constraint (if exists)
            try {
                $table->dropForeign(['user_id']);
            } catch (\Exception $e) {
                // Ignore if constraint doesn't exist
            }
            
            // 2. Make user_id nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // 3. Re-add foreign key with SET NULL on delete
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('ledgers', function (Blueprint $table) {
            // Drop foreign key
            try {
                $table->dropForeign(['user_id']);
            } catch (\Exception $e) {
                // Ignore
            }
            
            // Make non-nullable again
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            
            // Re-add with CASCADE delete
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }
};