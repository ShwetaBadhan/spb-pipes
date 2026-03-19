<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $stats = [
            'invoices' => Invoice::whereNull('deleted_at')->count(),

            'customers' => Invoice::whereNull('deleted_at')
                ->distinct('customer_id')
                ->count('customer_id'),

            'amount_due' => Invoice::whereNull('deleted_at')
                ->whereIn('status', ['unpaid', 'pending', 'draft'])
                ->sum('grand_total'),

            'paid_invoices' => Invoice::whereNull('deleted_at')
                ->where('status', 'paid')
                ->count(),

        ];
                // Instead of passing all orders
$orders = Order::latest()->take(5)->get(); 
        return view('admin.pages.dashboard', compact('stats', 'orders'));
    }
}
