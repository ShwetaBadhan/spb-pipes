<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BillingInvoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillingController extends Controller
{
    public function index(Request $request): View
    {
        $invoices = BillingInvoice::query()
            ->with(['tenant'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totals = [
            'collected' => BillingInvoice::where('status', 'paid')->sum('amount'),
            'pending' => BillingInvoice::where('status', 'pending')->sum('amount'),
            'payments' => Payment::count(),
        ];

        return view('super-admin.billing.index', compact('invoices', 'totals'));
    }
}
