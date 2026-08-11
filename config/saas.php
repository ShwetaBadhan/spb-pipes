<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Tenancy
    |--------------------------------------------------------------------------
    */

    'tenancy' => [
        // Central domain used for the super-admin panel / landing
        'central_domain' => env('CENTRAL_DOMAIN', 'spb-pipes.com'),

        // subdomain | domain | both
        'driver' => env('TENANCY_DRIVER', 'both'),

        // Set to false to disable tenant resolution in local/CLI contexts
        'enabled' => env('TENANCY_ENABLED', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Trial
    |--------------------------------------------------------------------------
    */

    'trial_days' => env('SAAS_TRIAL_DAYS', 14),

    /*
    |--------------------------------------------------------------------------
    | Feature Catalog
    |--------------------------------------------------------------------------
    |
    | Every module that can be locked/unlocked by plan. The key is the feature
    | slug used by middleware / services; the value is a human label.
    |
    */

    'features' => [
        'products'        => 'Products',
        'inventory'       => 'Inventory',
        'production'      => 'Production',
        'orders'          => 'Sales Orders',
        'invoices'        => 'Invoicing',
        'gate_passes'     => 'Gate Pass',
        'labor_tracking'  => 'Labor Tracking',
        'customers'       => 'Customers',
        'role_permissions' => 'Custom Roles',
        '2fa'             => 'Two-Factor Auth',
        'audit'           => 'Audit Trail',
        'api_access'      => 'API Access',
        'whatsapp'        => 'WhatsApp',
        'sms'             => 'SMS',
        'custom_domain'   => 'Custom Domain',
        'white_label'     => 'White Label',
        'priority_support' => 'Priority Support',
    ],

    /*
    |--------------------------------------------------------------------------
    | Plans
    |--------------------------------------------------------------------------
    |
    | Feature slugs included in each plan. Limits are applied through the
    | PlanService. Prices are in USD per month.
    |
    */

    'plans' => [
        'starter' => [
            'name'                => 'Starter',
            'price_monthly'       => 29,
            'max_users'           => 3,
            'max_products'        => 500,
            'max_invoices_per_month' => 200,
            'max_storage_mb'      => 1024,
            'trial_days'          => 14,
            'features'            => ['products', 'inventory', 'customers', 'invoices'],
        ],
        'pro' => [
            'name'                => 'Pro',
            'price_monthly'       => 79,
            'max_users'           => 10,
            'max_products'        => 5000,
            'max_invoices_per_month' => 2000,
            'max_storage_mb'      => 10240,
            'trial_days'          => 14,
            'features'            => ['products', 'inventory', 'customers', 'invoices', 'production', 'orders', 'gate_passes', 'labor_tracking'],
        ],
        'business' => [
            'name'                => 'Business',
            'price_monthly'       => 199,
            'max_users'           => 30,
            'max_products'        => 50000,
            'max_invoices_per_month' => 10000,
            'max_storage_mb'      => 51200,
            'trial_days'          => 14,
            'features'            => ['products', 'inventory', 'customers', 'invoices', 'production', 'orders', 'gate_passes', 'labor_tracking', 'role_permissions', '2fa', 'audit', 'api_access'],
        ],
        'enterprise' => [
            'name'                => 'Enterprise',
            'price_monthly'       => null, // custom pricing
            'max_users'           => null,
            'max_products'        => null,
            'max_invoices_per_month' => null,
            'max_storage_mb'      => null,
            'trial_days'          => 14,
            'features'            => ['products', 'inventory', 'customers', 'invoices', 'production', 'orders', 'gate_passes', 'labor_tracking', 'role_permissions', '2fa', 'audit', 'api_access', 'whatsapp', 'sms', 'custom_domain', 'white_label', 'priority_support'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Add-ons
    |--------------------------------------------------------------------------
    */

    'addons' => [
        'whatsapp'         => ['name' => 'WhatsApp Notifications', 'price_monthly' => 19, 'feature' => 'whatsapp'],
        'sms'              => ['name' => 'SMS Gateway', 'price_monthly' => 15, 'feature' => 'sms'],
        'extra_storage_10' => ['name' => 'Extra 10 GB Storage', 'price_monthly' => 10],
        'extra_users_5'    => ['name' => 'Extra 5 Users', 'price_monthly' => 12],
        'api'              => ['name' => 'REST API Access', 'price_monthly' => 25, 'feature' => 'api_access'],
        'custom_domain'    => ['name' => 'Custom Domain Mapping', 'price_monthly' => 20, 'feature' => 'custom_domain'],
        'white_label'      => ['name' => 'White-Label (remove branding)', 'price_monthly' => 30, 'feature' => 'white_label'],
        'priority_support' => ['name' => 'Priority Support', 'price_monthly' => 49, 'feature' => 'priority_support'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscriptions
    |--------------------------------------------------------------------------
    */

    'subscription' => [
        // Stripe price IDs keyed by plan slug (set in .env or admin panel)
        'stripe_price_ids' => [
            'starter'   => env('STRIPE_PRICE_STARTER'),
            'pro'       => env('STRIPE_PRICE_PRO'),
            'business'  => env('STRIPE_PRICE_BUSINESS'),
            'enterprise'=> env('STRIPE_PRICE_ENTERPRISE'),
        ],
    ],
];
