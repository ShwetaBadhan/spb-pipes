<?php

namespace Database\Seeders;

use App\Models\RateType;
use Illuminate\Database\Seeder;

class RateTypeSeeder extends Seeder
{
    public function run(): void
    {
        RateType::insert([
            ['name' => 'Per Unit', 'slug' => 'per-unit', 'status' => 'active'],
            ['name' => 'Per Truck', 'slug' => 'per-truck',  'status' => 'active'],
            ['name' => 'Per Hour', 'slug' => 'per-hour', 'status' => 'active'],
            ['name' => 'Per Batch', 'slug' => 'per-batch', 'status' => 'active'],
            ['name' => 'Per Worker', 'slug' => 'per-worker', 'status' => 'active'],
        ]);
    }
}