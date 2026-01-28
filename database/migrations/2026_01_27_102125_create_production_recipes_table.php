<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('production_recipes', function (Blueprint $table) {
    $table->id();

    $table->foreignId('product_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->foreignId('raw_material_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->decimal('qty_per_unit', 10, 4);

    $table->timestamps();

    $table->unique(['product_id', 'raw_material_id']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_recipes');
    }
};
