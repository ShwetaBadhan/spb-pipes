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
       Schema::create('production_consumptions', function (Blueprint $table) {
    $table->id();

    $table->foreignId('batch_id')
          ->constrained('production_batches')
          ->cascadeOnDelete();

    $table->foreignId('raw_material_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->decimal('expected_qty', 10, 4);
    $table->decimal('actual_qty', 10, 4);

    $table->timestamps();

    $table->unique(['batch_id', 'raw_material_id']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_consumptions');
    }
};
