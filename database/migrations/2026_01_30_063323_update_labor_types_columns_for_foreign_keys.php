<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('labor_types', function (Blueprint $table) {
            // 1. Temporary columns banayo data transfer ke liye
            $table->unsignedBigInteger('rate_type_id_temp')->nullable();
            $table->unsignedBigInteger('unit_id_temp')->nullable();
            $table->unsignedBigInteger('work_type_id_temp')->nullable();
        });

        // 2. Existing string values ko IDs mein convert karo
        $this->migrateOldData();

        Schema::table('labor_types', function (Blueprint $table) {
            // 3. Foreign key constraints add karo (pehle constraints)
            $table->foreign('rate_type_id_temp')->references('id')->on('rate_types')->onDelete('cascade');
            $table->foreign('unit_id_temp')->references('id')->on('units')->onDelete('set null');
            $table->foreign('work_type_id_temp')->references('id')->on('work_types')->onDelete('set null');

            // 4. Purane string columns drop karo
            $table->dropColumn(['rate_type', 'unit_type', 'work_type']);

            // 5. Temporary columns ko final names dein
            $table->renameColumn('rate_type_id_temp', 'rate_type_id');
            $table->renameColumn('unit_id_temp', 'unit_id');
            $table->renameColumn('work_type_id_temp', 'work_type_id');
        });
    }

    private function migrateOldData()
    {
        // Rate Types mapping
        $rateTypes = DB::table('rate_types')->pluck('id', 'name');
        foreach ($rateTypes as $name => $id) {
            DB::table('labor_types')
                ->where('rate_type', $name)
                ->update(['rate_type_id_temp' => $id]);
        }

        // Units mapping
        $units = DB::table('units')->pluck('id', 'name');
        foreach ($units as $name => $id) {
            DB::table('labor_types')
                ->where('unit_type', $name)
                ->update(['unit_id_temp' => $id]);
        }

        // Work Types mapping
        $workTypes = DB::table('work_types')->pluck('id', 'name');
        foreach ($workTypes as $name => $id) {
            DB::table('labor_types')
                ->where('work_type', $name)
                ->update(['work_type_id_temp' => $id]);
        }
    }

    public function down()
    {
        Schema::table('labor_types', function (Blueprint $table) {
            // Rollback ke liye
            $table->string('rate_type')->nullable();
            $table->string('unit_type')->nullable();
            $table->string('work_type')->nullable();

            // IDs ko wapas string values mein convert karo
            $rateTypes = DB::table('rate_types')->pluck('name', 'id');
            foreach ($rateTypes as $id => $name) {
                DB::table('labor_types')
                    ->where('rate_type_id', $id)
                    ->update(['rate_type' => $name]);
            }

            $units = DB::table('units')->pluck('name', 'id');
            foreach ($units as $id => $name) {
                DB::table('labor_types')
                    ->where('unit_id', $id)
                    ->update(['unit_type' => $name]);
            }

            $workTypes = DB::table('work_types')->pluck('name', 'id');
            foreach ($workTypes as $id => $name) {
                DB::table('labor_types')
                    ->where('work_type_id', $id)
                    ->update(['work_type' => $name]);
            }

            // Foreign key columns drop karo
            $table->dropConstrainedForeignId('rate_type_id');
            $table->dropConstrainedForeignId('unit_id');
            $table->dropConstrainedForeignId('work_type_id');
        });
    }
};