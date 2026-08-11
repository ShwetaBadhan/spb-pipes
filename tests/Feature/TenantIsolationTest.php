<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Tenant;
use App\Services\PlanService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase as BaseTestCase;

class TenantIsolationTest extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tenantA = Tenant::create([
            'name' => 'Tenant A',
            'slug' => 'tenant-a-'.uniqid(),
            'status' => 'active',
            'plan_slug' => 'pro',
        ]);

        $this->tenantB = Tenant::create([
            'name' => 'Tenant B',
            'slug' => 'tenant-b-'.uniqid(),
            'status' => 'active',
            'plan_slug' => 'pro',
        ]);

        $productFields = fn (array $overrides) => array_merge([
            'category_id' => 1,
            'description' => '',
            'image_path' => '',
            'unit_id' => '',
            'status' => 1,
        ], $overrides);

        Product::forceCreate($productFields(['tenant_id' => $this->tenantA->id, 'name' => 'Pipe A', 'slug' => 'pipe-a', 'code' => 'PA-1']));
        Product::forceCreate($productFields(['tenant_id' => $this->tenantA->id, 'name' => 'Pipe A2', 'slug' => 'pipe-a2', 'code' => 'PA-2']));
        Product::forceCreate($productFields(['tenant_id' => $this->tenantB->id, 'name' => 'Pipe B', 'slug' => 'pipe-b', 'code' => 'PB-1']));
    }

    public function test_models_are_scoped_to_the_current_tenant(): void
    {
        $this->app->instance('current_tenant_id', $this->tenantA->id);

        $products = Product::pluck('code')->sort()->values()->all();

        $this->assertEquals(['PA-1', 'PA-2'], $products);
    }

    public function test_no_tenant_context_returns_all_records(): void
    {
        $this->assertEquals(3, Product::count());
    }

    public function test_creating_a_model_without_context_does_not_leak_tenant_id(): void
    {
        $this->app->forgetInstance('current_tenant_id');

        $product = Product::create([
            'name' => 'Orphan Pipe',
            'slug' => 'orphan-pipe',
            'code' => 'OP-1',
            'category_id' => 1,
            'description' => '',
            'image_path' => '',
            'unit_id' => '',
            'status' => 1,
        ]);

        $this->assertNull($product->tenant_id);
    }

    public function test_plan_feature_gating_via_config_catalog(): void
    {
        $this->assertTrue(PlanService::hasFeature($this->tenantA, 'labor_tracking'));
        $this->assertFalse(PlanService::hasFeature($this->tenantA, 'custom_domain'));
    }
}
