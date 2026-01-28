<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('inventory_logs', function (Blueprint $table) {

            // Item type (product / raw material)
            $table->enum('item_type', ['product', 'raw_material'])
                  ->after('id');

            // Raw material id
            $table->unsignedBigInteger('raw_material_id')
                  ->nullable()
                  ->after('product_id');

            // Foreign key
            $table->foreign('raw_material_id')
                  ->references('id')
                  ->on('raw_materials')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('inventory_logs', function (Blueprint $table) {
            $table->dropForeign(['raw_material_id']);
            $table->dropColumn([
                'item_type',
                'raw_material_id'
            ]);
        });
    }
};
