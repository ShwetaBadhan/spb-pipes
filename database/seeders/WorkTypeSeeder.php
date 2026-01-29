<?php

namespace Database\Seeders;

use App\Models\WorkType;
use Illuminate\Database\Seeder;

class WorkTypeSeeder extends Seeder
{
    public function run(): void
    {
        WorkType::insert([
            ['name' => 'Loading', 'status' => 'active'],
            ['name' => 'Unloading', 'status' => 'active'],
            ['name' => 'Both', 'status' => 'active'],
        ]);
    }
}