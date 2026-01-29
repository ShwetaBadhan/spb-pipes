<?php

namespace Database\Seeders;

use App\Models\RateType;
use Illuminate\Database\Seeder;

class RateTypeSeeder extends Seeder
{
    public function run(): void
    {
        RateType::insert([
            ['name' => 'Per Unit', 'status' => 'active'],
            ['name' => 'Per Truck', 'status' => 'active'],
            ['name' => 'Per Hour', 'status' => 'active'],
            ['name' => 'Per Batch', 'status' => 'active'],
            ['name' => 'Per Worker', 'status' => 'active'],
        ]);
    }
}