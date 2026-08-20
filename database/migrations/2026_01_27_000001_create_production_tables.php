<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_rules', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();
            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('min_output');
            $table->integer('max_output');

            $table->timestamps();
        });

        Schema::create('production_batches', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();
            $table->string('batch_id')->nullable();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('production_date');
            $table->integer('actual_output');

            $table->enum('status', ['normal', 'under', 'over'])->nullable();

            $table->timestamps();

            $table->unique(['tenant_id', 'batch_id']);
        });

        Schema::create('production_recipes', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();

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

        Schema::create('production_consumptions', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();

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

    public function down(): void
    {
        Schema::dropIfExists('production_consumptions');
        Schema::dropIfExists('production_recipes');
        Schema::dropIfExists('production_batches');
        Schema::dropIfExists('production_rules');
    }
};
