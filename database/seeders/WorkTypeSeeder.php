<?php

namespace Database\Seeders;

use App\Models\WorkType;
use Illuminate\Database\Seeder;

class WorkTypeSeeder extends Seeder
{
    public function run(): void
    {
        WorkType::insert([
            ['name' => 'Loading', 'slug' => 'loading' , 'status' => 'active'],
            ['name' => 'Unloading', 'slug' => 'unloading' , 'status' => 'active'],
            ['name' => 'Both', 'slug' => 'both' ,  'status' => 'active'],
        ]);
    }
}