<?php

namespace App\Rules;

use App\Services\PlanService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WithinPlanLimit implements ValidationRule
{
    public function __construct(protected string $resource)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $tenant = currentTenant();

        if (! $tenant) {
            return;
        }

        if (PlanService::withinLimit($tenant, $this->resource)) {
            return;
        }

        $limits = PlanService::limits($tenant);
        $max = $limits[$this->resource] ?? null;

        $fail("Your plan limit of ".($max === null || $max === PHP_INT_MAX ? 'unlimited' : $max)." {$this->resource} has been reached. Upgrade your plan to add more.");
    }
}
