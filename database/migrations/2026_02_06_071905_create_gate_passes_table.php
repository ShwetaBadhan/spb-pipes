<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gate_passes', function (Blueprint $table) {
            $table->id();
            $table->string('batch_number'); // Vehicle identifier
            $table->date('date');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('labor_type_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('workers_count');
            $table->decimal('rate_amount', 10, 2);
            $table->decimal('total_cost', 10, 2);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gate_passes');
    }
};