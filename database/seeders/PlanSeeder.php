<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Start with a 14-day free trial. Limited customers, invoices and products to get you going.',
                'price' => 0,
                'currency' => 'INR',
                'billing_period' => 'monthly',
                'trial_days' => 14,
                'is_default' => true,
                'sort_order' => 1,
                'limits' => [
                    'customers' => 10,
                    'invoices' => 20,
                    'products' => 50,
                    'users' => 2,
                    'gate_passes' => 30,
                    'raw_materials' => 20,
                ],
                'features' => null,
            ],
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'description' => 'For growing small businesses. More customers, invoices and products.',
                'price' => 499,
                'currency' => 'INR',
                'billing_period' => 'monthly',
                'trial_days' => 0,
                'is_default' => false,
                'sort_order' => 2,
                'limits' => [
                    'customers' => 100,
                    'invoices' => 300,
                    'products' => 500,
                    'users' => 5,
                    'gate_passes' => 500,
                    'raw_materials' => 200,
                ],
                'features' => ['orders', 'invoices'],
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'description' => 'For established businesses with higher volume and larger teams.',
                'price' => 999,
                'currency' => 'INR',
                'billing_period' => 'monthly',
                'trial_days' => 0,
                'is_default' => false,
                'sort_order' => 3,
                'limits' => [
                    'customers' => 500,
                    'invoices' => 1500,
                    'products' => 2500,
                    'users' => 10,
                    'gate_passes' => 2500,
                    'raw_materials' => 1000,
                ],
                'features' => ['production', 'labor', 'orders', 'invoices', 'gate_passes', 'inventory', 'purchases'],
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Unlimited usage for large organizations.',
                'price' => 2499,
                'currency' => 'INR',
                'billing_period' => 'monthly',
                'trial_days' => 0,
                'is_default' => false,
                'sort_order' => 4,
                'limits' => [
                    'customers' => -1,
                    'invoices' => -1,
                    'products' => -1,
                    'users' => 50,
                    'gate_passes' => -1,
                    'raw_materials' => -1,
                ],
                'features' => null,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
