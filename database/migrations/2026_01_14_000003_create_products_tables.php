<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('slug');
            $table->unsignedBigInteger('category_id');
            $table->text('description');
            $table->string('image_path');
            $table->string('unit_id');

            $table->boolean('status')
                ->default(1)
                ->comment('1 = Active, 0 = Inactive');

            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();
            $table->unsignedBigInteger('product_id');
            $table->string('image_path');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('type')->nullable();

            $table->decimal('selling_price', 10, 2);
            $table->decimal('purchase_price', 10, 2)->default(0);

            $table->integer('quantity')->default(0);
            $table->integer('alert_quantity')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
    }
};
