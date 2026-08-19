<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Services\InventoryService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $lowStockProducts = InventoryService::getLowStockProducts();
        $lowStockRawMaterials = InventoryService::getLowStockRawMaterials();
        $today = Carbon::today();
        $lastMonth = Carbon::now()->subMonth();

        $totalProducts = Product::where('status', 1)->count();
        $productsThisMonth = Product::where('status', 1)
            ->where('created_at', '>=', $lastMonth)
            ->count();

        $completedStatuses = ['confirmed', 'shipped', 'delivered'];

        $totalSales = Order::where('status', 'delivered')
            ->orWhereIn('status', $completedStatuses)
            ->whereNull('deleted_at')
            ->count();

        $salesThisMonth = Order::whereIn('status', $completedStatuses)
            ->whereNull('deleted_at')
            ->where('created_at', '>=', $lastMonth)
            ->count();

        $totalCustomers = Customer::count();
        $customersThisMonth = Customer::where('created_at', '>=', $lastMonth)->count();

        $stats = [
            'total_products' => $totalProducts,
            'new_products_this_month' => $productsThisMonth,
            'total_sales' => $totalSales,
            'sales_this_month' => $salesThisMonth,
            'total_customers' => $totalCustomers,
            'new_customers_this_month' => $customersThisMonth,
            'total_orders' => Order::whereNull('deleted_at')->count(),
            'purchase' => Invoice::whereNull('deleted_at')
                ->where('status', 'paid')
                ->sum('grand_total'),
            'expenses' => Order::whereNull('deleted_at')
                ->whereIn('status', ['pending', 'confirmed'])
                ->sum('total'),
            'credits' => Order::whereNull('deleted_at')
                ->whereIn('status', ['pending', 'confirmed'])
                ->sum('total'),
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
            'invoiced' => Invoice::whereNull('deleted_at')->sum('grand_total'),
            'received' => Invoice::whereNull('deleted_at')
                ->where('status', 'paid')
                ->sum('grand_total'),
            'outstanding' => Invoice::whereNull('deleted_at')
                ->whereIn('status', ['unpaid', 'pending', 'draft'])
                ->sum('grand_total'),
            'overdue' => Invoice::whereNull('deleted_at')
                ->whereIn('status', ['unpaid', 'pending'])
                ->where('due_date', '<', $today)
                ->sum('grand_total'),
            'total_invoices' => Invoice::whereNull('deleted_at')->count(),
            'pending_invoices' => Invoice::whereNull('deleted_at')
                ->whereIn('status', ['unpaid', 'pending'])->count(),
        ];

        $orders = Order::latest()->take(5)->get();
        $tenant = tenant();

        return view('admin.pages.dashboard', compact(
            'lowStockProducts', 'lowStockRawMaterials', 'stats', 'orders', 'tenant'
        ));
    }
}
