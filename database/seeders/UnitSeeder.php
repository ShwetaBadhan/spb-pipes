<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        Unit::insert([
            ['name' => 'Piece', 'short_name' => 'pc', 'is_active' => true],
            ['name' => 'Kilogram', 'short_name' => 'kg', 'is_active' => true],
            ['name' => 'Meter', 'short_name' => 'm', 'is_active' => true],
            ['name' => 'Square Meter', 'short_name' => 'm2', 'is_active' => true],
            ['name' => 'Liter', 'short_name' => 'L', 'is_active' => true],
            ['name' => 'Hour', 'short_name' => 'hr', 'is_active' => true],
        ]);
    }
}
