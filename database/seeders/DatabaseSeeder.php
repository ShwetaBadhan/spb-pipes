<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\StateSeeder;
use Database\Seeders\CitySeeder;
use Database\Seeders\WorkTypeSeeder;
use Database\Seeders\RateTypeSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
    $this->call([
        // UsersTableSeeder::class,
        CentralAdminSeeder::class,
        StateSeeder::class,
        CitySeeder::class,
        RateTypeSeeder::class,
        WorkTypeSeeder::class,
         PermissionSeeder::class,
          PlanSeeder::class,
         TenantSeeder::class,
     ]);
       
    }
}
