<?php

namespace App\Http\Controllers;

use App\Services\PlanService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function show(): \Illuminate\View\View
    {
        $planService = PlanService::for();
        $plan = $planService->plan();
        $status = $planService->status();

        return view('admin.pages.subscription-required', compact('plan', 'status'));
    }
}
