<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index(Request $request): View
    {
        $subscriptions = Subscription::query()
            ->with(['tenant', 'plan'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('super-admin.subscriptions.index', compact('subscriptions'));
    }

    public function show(Subscription $subscription): View
    {
        $subscription->load(['tenant', 'plan']);

        return view('super-admin.subscriptions.show', compact('subscription'));
    }
}
