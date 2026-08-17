<?php

namespace App\Http\Controllers\Concerns;

use App\Services\PlanService;
use Illuminate\Http\RedirectResponse;

trait EnforcesPlanLimits
{
    protected function ensurePlanLimit(string $key, string $label): ?RedirectResponse
    {
        if (PlanService::for()->isWithinLimit($key)) {
            return null;
        }

        return back()
            ->withInput()
            ->with('error', 'You’ve reached the user limit for your current plan. Upgrade your plan to add more users.');
    }
}
