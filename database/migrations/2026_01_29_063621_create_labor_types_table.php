<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('labor_types', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->string('name'); // e.g., "Tile Press Operator", "Loader"
            $table->string('code')->unique()->nullable(); // e.g., "LAB-001"
            
            // Category (Production or Logistics)
            $table->enum('category', ['production', 'logistics'])
                  ->default('production')
                  ->comment('Production: tiles/pipes | Logistics: loading/unloading');
            
            // Rate Configuration
            $table->enum('rate_type', ['per_unit', 'per_truck', 'per_hour', 'per_batch', 'per_worker'])
                  ->default('per_unit')
                  ->comment('How labor is charged');
            
            $table->decimal('rate_amount', 10, 2)->default(0.00)
                  ->comment('Rate value based on rate_type');
            
            // Unit Type (for production)
            $table->enum('unit_type', ['tile', 'pipe', 'batch', 'other'])->nullable()
                  ->comment('Applicable for production labor');
            
            // Work Type (for logistics)
            $table->enum('work_type', ['loading', 'unloading', 'both', 'none'])->nullable()
                  ->comment('Applicable for logistics labor');
            
            // Additional Info
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            
            // Status field (placed after is_active by order of definition)
            $table->enum('status', ['active', 'inactive'])
                  ->default('active')
                  ->comment('Labor type status: active or inactive');
            
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('status');
            $table->index('category');
            $table->index('rate_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('labor_types');
    }
};