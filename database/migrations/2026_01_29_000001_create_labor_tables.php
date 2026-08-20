<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rate_types', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->unique(['tenant_id', 'slug']);
        });

        Schema::create('work_types', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->unique(['tenant_id', 'slug']);
        });

        Schema::create('labor_types', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();

            $table->string('name');
            $table->string('code')->nullable();

            $table->enum('category', ['production', 'logistics'])
                ->default('production')
                ->comment('Production: tiles/pipes | Logistics: loading/unloading');

            $table->unsignedBigInteger('rate_type_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('work_type_id')->nullable();

            $table->decimal('rate_amount', 10, 2)->default(0.00)
                ->comment('Rate value based on rate_type');

            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);

            $table->enum('status', ['active', 'inactive'])
                ->default('active')
                ->comment('Labor type status: active or inactive');

            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('rate_type_id')->references('id')->on('rate_types')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
            $table->foreign('work_type_id')->references('id')->on('work_types')->onDelete('set null');

            $table->index('status');
            $table->index('category');

            $table->unique(['tenant_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('labor_types');
        Schema::dropIfExists('work_types');
        Schema::dropIfExists('rate_types');
    }
};
