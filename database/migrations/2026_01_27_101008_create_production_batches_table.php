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
     Schema::create('production_batches', function (Blueprint $table) {
    $table->id();

    $table->foreignId('product_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->date('production_date');
    $table->integer('actual_output');

    $table->enum('status', ['normal', 'under', 'over'])->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_batches');
    }
};
