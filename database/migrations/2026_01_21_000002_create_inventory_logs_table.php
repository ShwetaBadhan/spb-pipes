<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();

            $table->enum('item_type', ['product', 'raw_material']);

            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');

            $table->unsignedBigInteger('raw_material_id')->nullable();

            $table->integer('quantity');
            $table->string('status');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('raw_material_id')
                ->references('id')
                ->on('raw_materials')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};
