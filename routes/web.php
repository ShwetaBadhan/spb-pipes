<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RawMaterialController;
use App\Services\InventoryService;
use App\Http\Controllers\ProductionRuleController;
use App\Http\Controllers\ProductionBatchController;
use App\Http\Controllers\ProductionRecipeController;
use App\Http\Controllers\ProductionConsumptionController;
use App\Models\ProductionBatch;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\LaborTypeController;
use App\Http\Controllers\RateTypeController;
use App\Http\Controllers\WorkTypeController;
use App\Http\Controllers\LaborCostAssignmentController;
use App\Http\Controllers\LaborHistoryController;
use App\Http\Controllers\LaborCostReportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\GatePassController;
use App\Http\Controllers\PaymentController; // ✅ IMPORT FROM ROOT CONTROLLERS
use App\Http\Controllers\CaptchaSettingController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\SecuritySettingController;
use App\Http\Controllers\NotificationSettingController;
use App\Http\Controllers\IntegrationSettingController;
use App\Http\Controllers\LocalizationSettingController;
use App\Http\Controllers\Admin\LanguageSettingController;
use App\Http\Controllers\MaintenanceModeController;

use App\Models\Invoice;
use App\Models\Order; // Add this
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Customer;
// Route::get('/', function () {
//     return view('admin.auth.login');
// })-> name("login");

Route::get('/auth/register', function () {
    return view('admin.auth.register');
})->name("register");


    
   

// routes/web.php
Route::get('/security-settings', [SecuritySettingController::class, 'index'])->name('security-settings');

Route::middleware(['auth'])->group(function () {
    Route::post('/security-settings/update', [SecuritySettingController::class, 'updateSettings'])->name('security-settings.update');
    Route::post('/security-settings/password', [SecuritySettingController::class, 'changePassword'])->name('security-settings.password');
    Route::post('/security-settings/phone', [SecuritySettingController::class, 'updatePhone'])->name('security-settings.phone');
    Route::delete('/security-settings/phone', [SecuritySettingController::class, 'removePhone'])->name('security-settings.phone.remove');
    Route::post('/security-settings/email', [SecuritySettingController::class, 'updateEmail'])->name('security-settings.email');
    Route::post('/security-settings/deactivate', [SecuritySettingController::class, 'deactivateAccount'])->name('security-settings.deactivate');
    Route::post('/security-settings/delete', [SecuritySettingController::class, 'deleteAccount'])->name('security-settings.delete');
    Route::delete('/security-settings/device/{id}', [SecuritySettingController::class, 'deleteDevice'])->name('security-settings.device.delete');
});

Route::get('/plans-billings', function () {
    return view('admin.pages.settings.general-settings.plans-billings');
})->name("plans-billings");

Route::get('/notifications-settings', [NotificationSettingController::class, 'index'])
    ->name("notifications-settings");

Route::middleware(['auth'])->group(function () {
    Route::post('/notifications-settings/update', [NotificationSettingController::class, 'update'])
        ->name('notifications-settings.update');
});
// Replace your closure route with controller
Route::get('/integrations-settings', [IntegrationSettingController::class, 'index'])
    ->name("integrations-settings");

Route::middleware(['auth'])->group(function () {
    // Toggle integration on/off
    Route::post('/integrations-settings/{integrationKey}/toggle', [IntegrationSettingController::class, 'toggle'])
        ->name('integrations-settings.toggle');
    
    // Remove integration
    Route::delete('/integrations-settings/{integrationKey}/remove', [IntegrationSettingController::class, 'remove'])
        ->name('integrations-settings.remove');
    
    // OAuth connect callback (optional)
    Route::get('/integrations-settings/{integrationKey}/callback', [IntegrationSettingController::class, 'connectCallback'])
        ->name('integrations-settings.callback');
        // OAuth connection
    Route::get('/integrations-settings/{integrationKey}/connect', [IntegrationSettingController::class, 'connect'])
        ->name('integrations-settings.connect');
    
    Route::post('/integrations-settings/{integrationKey}/toggle', [IntegrationSettingController::class, 'toggle'])
        ->name('integrations-settings.toggle');
    
    Route::delete('/integrations-settings/{integrationKey}/remove', [IntegrationSettingController::class, 'remove'])
        ->name('integrations-settings.remove');
});

// website-settings

Route::get('/ai-configuration', function () {
    return view('admin.pages.settings.website-settings.ai-configuration');
})->name("ai-configuration");

Route::get('/appearance-settings', function () {
    return view('admin.pages.settings.website-settings.appearance-settings');
})->name("appearance-settings");


Route::get('/authentication-settings', function () {
    return view('admin.pages.settings.website-settings.authentication-settings');
})->name("authentication-settings");





// routes/web.php



Route::get('/language-settings', [LanguageSettingController::class, 'index'])
    ->name('language-settings');

Route::post('/language-settings', [LanguageSettingController::class, 'store'])
    ->name('language-settings.store');

Route::put('/language-settings/{id}', [LanguageSettingController::class, 'update'])
    ->name('language-settings.update');

Route::delete('/language-settings/{id}', [LanguageSettingController::class, 'destroy'])
    ->name('language-settings.destroy');

// AJAX Routes
Route::post('/language-settings/{id}/toggle-status', [LanguageSettingController::class, 'toggleStatus'])
    ->name('language-settings.toggle-status');

Route::post('/language-settings/{id}/toggle-rtl', [LanguageSettingController::class, 'toggleRTL'])
    ->name('language-settings.toggle-rtl');

Route::post('/language-settings/{id}/set-default', [LanguageSettingController::class, 'setDefault'])
    ->name('language-settings.set-default');

Route::post('/language-settings/{id}/toggle-platform/{platform}', [LanguageSettingController::class, 'togglePlatform'])
    ->name('language-settings.toggle-platform');


// Show the page
Route::get('/localization-settings', [LocalizationSettingController::class, 'index'])->name("localization-settings");

// Handle form submission
Route::post('/localization-settings', [LocalizationSettingController::class, 'update'])->name("localization-settings.update");

Route::get('/maintenance-mode', [MaintenanceModeController::class, 'index'])
    ->name('maintenance-mode');

Route::put('/maintenance-mode', [MaintenanceModeController::class, 'update'])
    ->name('maintenance-mode.update');

Route::get('/plugin-manager', function () {
    return view('admin.pages.settings.website-settings.plugin-manager');
})->name("plugin-manager");

Route::get('/preference-settings', function () {
    return view('admin.pages.settings.website-settings.preference-settings');
})->name("preference-settings");

Route::get('/prefixes-settings', function () {
    return view('admin.pages.settings.website-settings.prefixes-settings');
})->name("prefixes-settings");

Route::get('/seo-setup', function () {
    return view('admin.pages.settings.website-settings.seo-setup');
})->name("seo-setup");

// app-settings

Route::get('/barcode-settings', function () {
    return view('admin.pages.settings.app-settings.barcode-settings');
})->name("barcode-settings");

Route::get('/custom-fields', function () {
    return view('admin.pages.settings.app-settings.custom-fields');
})->name("custom-fields");

Route::get('/esignatures', function () {
    return view('admin.pages.settings.app-settings.esignatures');
})->name("esignatures");

Route::get('/invoice-settings', function () {
    return view('admin.pages.settings.app-settings.invoice-settings');
})->name("invoice-settings");

Route::get('/invoice-templates-settings', function () {
    return view('admin.pages.settings.app-settings.invoice-templates-settings');
})->name("invoice-templates-settings");

Route::get('/sass-settings', function () {
    return view('admin.pages.settings.app-settings.sass-settings');
})->name("sass-settings");

Route::get('/thermal-printer', function () {
    return view('admin.pages.settings.app-settings.thermal-printer');
})->name("thermal-printer");

// finance settings

Route::get('/bank-accounts-settings', function () {
    return view('admin.pages.settings.finance-settings.bank-accounts-settings');
})->name("bank-accounts-settings");

Route::get('/currencies', function () {
    return view('admin.pages.settings.finance-settings.currencies');
})->name("currencies");

Route::get('/payment-methods', function () {
    return view('admin.pages.settings.finance-settings.payment-methods');
})->name("payment-methods");

Route::get('/tax-rates', function () {
    return view('admin.pages.settings.finance-settings.tax-rates');
})->name("tax-rates");

// system-settings

Route::get('/email-settings', function () {
    return view('admin.pages.settings.system-settings.email-settings');
})->name("email-settings");

Route::get('/email-templates', function () {
    return view('admin.pages.settings.system-settings.email-templates');
})->name("email-templates");

Route::get('/gdpr-cookies', function () {
    return view('admin.pages.settings.system-settings.gdpr-cookies');
})->name("gdpr-cookies");

Route::get('/sms-gateways', function () {
    return view('admin.pages.settings.system-settings.sms-gateways');
})->name("sms-gateways");

// other settings

Route::get('/clear-cache', function () {
    return view('admin.pages.settings.other-settings.clear-cache');
})->name("clear-cache");

Route::get('/cronjob', function () {
    return view('admin.pages.settings.other-settings.cronjob');
})->name("cronjob");

Route::get('/custom-css', function () {
    return view('admin.pages.settings.other-settings.custom-css');
})->name("custom-css");

Route::get('/custom-js', function () {
    return view('admin.pages.settings.other-settings.custom-js');
})->name("custom-js");

Route::get('/database-backup', function () {
    return view('admin.pages.settings.other-settings.database-backup');
})->name("database-backup");

Route::get('/sitemap', function () {
    return view('admin.pages.settings.other-settings.sitemap');
})->name("sitemap");

Route::get('/storage-settings', function () {
    return view('admin.pages.settings.other-settings.storage-settings');
})->name("storage-settings");

Route::get('/system-backup', function () {
    return view('admin.pages.settings.other-settings.system-backup');
})->name("system-backup");

Route::get('/system-update', function () {
    return view('admin.pages.settings.other-settings.system-update');
})->name("system-update");



// routes/web.php
Route::get('/test-stock', function () {
    $product = \App\Models\Product::first();
    if (!$product) return 'No product found';

    $available = \App\Services\InventoryService::productAvailableQty($product->id);
    dd("Product: {$product->name}, Available: {$available}");
});

Route::get('/dashboard', function () {


    $lowStockProducts = InventoryService::getLowStockProducts();
    $lowStockRawMaterials = InventoryService::getLowStockRawMaterials();
    $today = Carbon::today();
    $lastMonth = Carbon::now()->subMonth();

    // Get product counts - filter by status = 1 (active products)
    $totalProducts = Product::where('status', 1)->count();

    $productsThisMonth = Product::where('status', 1)
        ->where('created_at', '>=', $lastMonth)
        ->count();
    // Get completed orders (confirmed, shipped, delivered)
    $completedStatuses = ['confirmed', 'shipped', 'delivered'];

    $totalSales = Order::where('status', 'delivered')
        ->orWhereIn('status', $completedStatuses)
        ->whereNull('deleted_at')
        ->count();

    $salesThisMonth = Order::whereIn('status', $completedStatuses)
        ->whereNull('deleted_at')
        ->where('created_at', '>=', $lastMonth)
        ->count();
    // Get customer counts
    $totalCustomers = Customer::count();
    $customersThisMonth = Customer::where('created_at', '>=', $lastMonth)->count();
    $stats = [
        // Products
        'total_products' => $totalProducts,
        'new_products_this_month' => $productsThisMonth,

        // Orders/Sales
        'total_sales' => $totalSales,
        'sales_this_month' => $salesThisMonth,
        // Customers
        'total_customers' => $totalCustomers,
        'new_customers_this_month' => $customersThisMonth,
        // Total Orders Count
        'total_orders' => Order::whereNull('deleted_at')->count(),

        // Purchase (from invoices)
        'purchase' => Invoice::whereNull('deleted_at')
            ->where('status', 'paid')
            ->sum('grand_total'),

        // Expenses (you can customize this based on your needs)
        'expenses' => Order::whereNull('deleted_at')
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('total'),

        // Credits (unpaid orders)
        'credits' => Order::whereNull('deleted_at')
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('total'),

        // Keep your invoice stats if needed
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
        // Total Invoiced Amount (all invoices)
        'invoiced' => Invoice::whereNull('deleted_at')->sum('grand_total'),

        // Total Received (paid invoices)
        'received' => Invoice::whereNull('deleted_at')
            ->where('status', 'paid')
            ->sum('grand_total'),

        // Outstanding (unpaid, pending, draft invoices)
        'outstanding' => Invoice::whereNull('deleted_at')
            ->whereIn('status', ['unpaid', 'pending', 'draft'])
            ->sum('grand_total'),

        // Overdue (past due date and not paid)
        'overdue' => Invoice::whereNull('deleted_at')
            ->whereIn('status', ['unpaid', 'pending'])
            ->where('due_date', '<', $today)
            ->sum('grand_total'),

        // Additional stats you might want
        'total_invoices' => Invoice::whereNull('deleted_at')->count(),
        'paid_invoices' => Invoice::whereNull('deleted_at')->where('status', 'paid')->count(),
        'pending_invoices' => Invoice::whereNull('deleted_at')->whereIn('status', ['unpaid', 'pending'])->count(),
    ];

    return view('admin.pages.dashboard', compact('lowStockProducts', 'lowStockRawMaterials', 'stats'));
})->middleware('auth')->name('dashboard');


Route::get('/products', function () {
    return view('admin.pages.products');
})->name("products");



Route::get('/admin-roles', function () {
    return view('admin.pages.admin-roles');
})->name("roles");



// purchase routes

Route::get('/purchases/purchases-view', function () {
    return view('admin.pages.purchases.purchases-view');
})->name("purchases-view");



Route::get('/purchases/add-purchase', function () {
    return view('admin.pages.purchases.add-purchase');
})->name("add-purchase");




Route::get('/purchases/edit-purchase', function () {
    return view('admin.pages.purchases.edit-purchase');
})->name("edit-purchase");

// purchase order routes

Route::get('/purchaseorders/purchase-order-view', function () {
    return view('admin.pages.purchaseorders.purchase-order-view');
})->name("purchase-order-view");



Route::get('/purchaseorders/add-purchase-order', function () {
    return view('admin.pages.purchaseorders.add-purchase-order');
})->name("add-purchase-orders");




Route::get('/purchaseorders/edit-purchase-order', function () {
    return view('admin.pages.purchaseorders.edit-purchase-order');
})->name("edit-purchase-orders");

// suppliers route

Route::get('/suppliers/suppliers-view', function () {
    return view('admin.pages.suppliers.suppliers-view');
})->name("suppliers");




Route::get('/suppliers/supplier-payment', function () {
    return view('admin.pages.suppliers.supplier-payment');
})->name("supplier-payment");

// finance routes

Route::get('/finances/expenses', function () {
    return view('admin.pages.finances.expenses');
})->name("expenses");


Route::get('/finances/incomes', function () {
    return view('admin.pages.finances.incomes');
})->name("incomes");


Route::get('/finances/payments', function () {
    return view('admin.pages.finances.payments');
})->name("payments");




Route::get('/finances/transactions', function () {
    return view('admin.pages.finances.transactions');
})->name("transactions");


Route::get('/finances/bank-accounts', function () {
    return view('admin.pages.finances.bank-accounts');
})->name("bank-accounts");


Route::get('/finances/money-transfer', function () {
    return view('admin.pages.finances.money-transfer');
})->name("money-transfer");


Route::middleware(['auth'])->group(function () {
    Route::get('/general-settings/account-settings', [AccountSettingsController::class, 'index'])
        ->name('account-settings');
    
    Route::put('/general-settings/account-settings', [AccountSettingsController::class, 'update'])
    ->name('account-settings.update');
    
    Route::get('/account-settings/cities/{stateId}', [AccountSettingsController::class, 'getCitiesByState'])
    ->name('account-settings.cities');
    
    Route::delete('/general-settings/account-settings/image', [AccountSettingsController::class, 'deleteProfileImage'])
        ->name('account-settings.image.delete');
});


// controllers



// Keep your route as admin-roles
Route::get('/admin-roles', [RolePermissionController::class, 'rolesIndex'])

    ->name('roles.index');

Route::post('/admin-roles', [RolePermissionController::class, 'store'])->name('roles.storeRole');
Route::put('/admin-roles/{role}', [RolePermissionController::class, 'update'])->name('roles.updateRole');
Route::delete('/admin-roles/{role}', [RolePermissionController::class, 'destroy'])->name('roles.destroyRole');
Route::put('/admin-roles/{role}/permissions', [RolePermissionController::class, 'updateRolePermissions'])
    ->name('roles.update-permissions');



// Permissions routes

Route::get('/admin-permissions', [RolePermissionController::class, 'permissionsIndex'])->name('permissions.index');
Route::post('/admin-permissions', [RolePermissionController::class, 'storePermission'])->name('permissions.store');
Route::put('/admin-permissions/{permission}', [RolePermissionController::class, 'updatePermission'])->name('permissions.update');
Route::delete('/admin-permissions/{permission}', [RolePermissionController::class, 'destroyPermission'])->name('permissions.destroy');

// admin user register
// Users List Page
Route::get('/admin-users', [UserRegisterController::class, 'index'])->name('users.index');

// Add New User
Route::post('/admin-users', [UserRegisterController::class, 'store'])->name('users.store');

// Update Existing User
Route::put('/admin-users/{user}', [UserRegisterController::class, 'update'])->name('users.update');

// Update User Role
Route::put('/admin-users/{user}/role', [UserRegisterController::class, 'updateRole'])->name('users.update-role');

// Delete User
Route::delete('/admin-users/{user}', [UserRegisterController::class, 'destroy'])->name('users.destroy');

// Optional: Show User Details via AJAX
Route::get('/admin-users/{user}', [UserRegisterController::class, 'show'])->name('users.show');


// auth pages

Route::get('/', [AuthController::class, 'login'])->name('login');

Route::get('/auth/login', [AuthController::class, 'login']);

Route::post('/login', [AuthController::class, 'authenticate'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Product Units
Route::get('/units', [UnitController::class, 'index'])->name('units');
Route::post('/units/store', [UnitController::class, 'store'])->name('units.store');

Route::get('/units/{unit}/edit', [UnitController::class, 'edit'])->name('units.edit');
Route::put('/units/{unit}', [UnitController::class, 'update'])->name('units.update');
Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('units.delete');


Route::get('/category', [CategoryController::class, 'index'])->name('category');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.delete');


// products routes

// List all products

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Show Add Product form (using your add-product.blade.php)
Route::get('/add-product', [ProductController::class, 'create'])->name('add-product');

// Store new product
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Show Edit Product form (using your edit-product.blade.php)
Route::get('/edit-product/{product}', [ProductController::class, 'edit'])->name('edit-product');

// Update product
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

// Delete product
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::post('/products/generate-code', [ProductController::class, 'generateCode'])
    ->name('products.generate-code');


// customers
// List all customers
Route::get('/customers', [CustomerController::class, 'index'])
    ->name('customers.index');

// Show Add Customer form
Route::get('/customers/add-customer', [CustomerController::class, 'create'])
    ->name('add-customer');

// Store new customer
Route::post('/customers', [CustomerController::class, 'store'])
    ->name('customers.store');

// Show Edit Customer form
Route::get('/edit-customer/{customer}', [CustomerController::class, 'edit'])
    ->name('edit-customer');


// Update customer
Route::put('/customers/{customer}', [CustomerController::class, 'update'])
    ->name('customers.update');

// Delete customer
Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])
    ->name('customers.destroy');

Route::get('/get-cities/{state}', [LocationController::class, 'getCities'])
    ->name('get.cities');


// inventory
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
Route::get('/inventory/history', [InventoryController::class, 'getHistory'])
    ->name('inventory.history');


Route::delete('/inventory/{log}', [InventoryController::class, 'destroy'])
    ->name('inventory.destroy');



Route::resource('/rawmaterials/raw-materials', RawMaterialController::class);


// This creates all 7 RESTful routes for production rules
Route::resource('production-rules', ProductionRuleController::class);
// routes/web.php
Route::get('/admin/production-rules/raw-materials/{productId}', [ProductionRuleController::class, 'getRawMaterialsForProduct']);
// This creates all 7 RESTful routes for production batches
Route::resource('production-batches', controller: ProductionBatchController::class);

Route::resource('bill-of-materials', ProductionRecipeController::class);

Route::get('bill-of-materials/by-product/{product}', function ($productId) {
    $recipes = \App\Models\ProductionRecipe::with('rawMaterial')
        ->where('product_id', $productId)->get();

    return response()->json($recipes);
});

Route::get(
    'production-batches/consumptions/{batch}', // must be {batch}, not {batchId}
    [ProductionConsumptionController::class, 'consumptions']
)->name('production-batches.consumptions');
Route::put(
    '/production-batches/{batch}/consumptions',
    [ProductionConsumptionController::class, 'update']
)->name('production-consumptions.update');

// Store consumption for that batch

// Route::get('bill-of-materials/by-batch/{batch}', function($batchId){
//     try {
//         $batch = ProductionBatch::with('product.productionRecipes.rawMaterial.unit')->find($batchId);

//         if (!$batch) {
//             Log::info("Batch not found: $batchId");
//             return response()->json([], 200);
//         }

//         if (!$batch->product) {
//             Log::info("Batch $batchId has no product");
//             return response()->json([], 200);
//         }

//         $rawMaterials = $batch->product->productionRecipes->map(function($recipe){
//             $rawMaterial = $recipe->rawMaterial;
//             if (!$rawMaterial) return null; // skip if missing

//             $unit = $rawMaterial->unit;

//             return [
//                 'id' => $rawMaterial->id,
//                 'material_name' => $rawMaterial->material_name,
//                 'unit' => $unit ? [
//                     'id' => $unit->id,
//                     'short_name' => $unit->short_name,
//                 ] : null,
//             ];
//         })->filter(fn($rm) => $rm !== null);

//         return response()->json($rawMaterials);

//     } catch (\Throwable $e) {
//         Log::error("Error fetching batch $batchId: ".$e->getMessage());
//         return response()->json(['error' => 'Internal Server Error'], 500);
//     }
// });




// Resource routes for LaborType CRUD


// Rate Types
Route::resource('rate-types', RateTypeController::class)->names('rate-types');
Route::post('rate-types/{rate_type}/toggle-status', [RateTypeController::class, 'toggleStatus'])->name('rate-types.toggle-status');

// Work Types
Route::resource('work-types', WorkTypeController::class)->names('work-types');
Route::post('work-types/{work_type}/toggle-status', [WorkTypeController::class, 'toggleStatus'])->name('work-types.toggle-status');

// ✅ Labor Types Routes
Route::resource('labor-types', LaborTypeController::class)->names('labor-types');
// ✅ Auto-generate code route
Route::post('labor-types/generate-code', [LaborTypeController::class, 'generateCode'])->name('labor-types.generate-code');

// Additional routes
Route::post('labor-types/{id}/activate', [LaborTypeController::class, 'activate'])->name('labor-types.activate');
Route::post('labor-types/{id}/deactivate', [LaborTypeController::class, 'deactivate'])->name('labor-types.deactivate');
Route::post('labor-types/{id}/toggle-status', [LaborTypeController::class, 'toggleStatus'])->name('labor-types.toggle-status');


// Labor Cost Assignments
// ✅ Correct route definition
Route::resource('labor-cost-assignments', LaborCostAssignmentController::class)
    ->names('labor-cost-assignments');

// ✅ Additional route for index (if needed)
Route::get('labor-cost-assignments', [LaborCostAssignmentController::class, 'index'])
    ->name('labor-cost-assignments.index');
Route::get('labor-cost-assignments/labor-type/{id}/details', [LaborCostAssignmentController::class, 'getLaborTypeDetails'])->name('labor-cost-assignments.labor-type-details');

// Labor History
Route::get('labor-history', [LaborHistoryController::class, 'index'])->name('labor-history.index');
Route::get('labor-history/export', [LaborHistoryController::class, 'export'])->name('labor-history.export');

// Labor Cost Reports
Route::get('labor-cost-reports', [LaborCostReportController::class, 'index'])->name('labor-cost-reports.index');
Route::get('labor-cost-reports/generate', [LaborCostReportController::class, 'generate'])->name('labor-cost-reports.generate');
Route::get('labor-cost-reports/export-pdf', [LaborCostReportController::class, 'exportPdf'])->name('labor-cost-reports.export-pdf');
Route::get('labor-cost-reports/export-excel', [LaborCostReportController::class, 'exportExcel'])->name('labor-cost-reports.export-excel');


// Order Management - Salesman focused
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('orders', OrderController::class)->except(['edit', 'update']);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    // Status update route
    // CORRECT DEFINITION
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    // Order details AJAX route
    Route::get('orders/{order}/details', [OrderController::class, 'getOrderDetails'])->name('orders.details');
});


// Invoice Management Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {

    // ✅ Invoice routes with payment routes INSIDE
    Route::prefix('invoices')->name('admin.invoices.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/create', [InvoiceController::class, 'create'])->name('create');
        Route::post('/', [InvoiceController::class, 'store'])->name('store');
        Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
        Route::get('/{invoice}/edit', [InvoiceController::class, 'edit'])->name('edit');
        Route::put('/{invoice}', [InvoiceController::class, 'update'])->name('update');
        Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
        Route::patch('/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('update-status');
        Route::get('/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('pdf');

        // ✅ PAYMENT ROUTES - INSIDE the invoice group
        Route::get('/{invoice}/add-payment', [PaymentController::class, 'create'])->name('add-payment');
        Route::post('/{invoice}/record-payment', [PaymentController::class, 'store'])->name('record-payment');
        Route::get('/{invoice}/ledger', [PaymentController::class, 'getLedger'])->name('ledger');
        // ✅ CORRECTED FILTER ROUTE
        Route::post('/{invoice}/ledger/filter', [InvoiceController::class, 'filterLedger'])
            ->name('ledger.filter');
    });
});

// gate-passes
Route::name('admin.')->group(function () {
    // Custom route MUST be BEFORE resource
    Route::get('gate-passes/labor-rate/{id}', [GatePassController::class, 'getLaborRate'])
        ->name('gate-passes.labor-rate');

    // Resource route
    Route::resource('gate-passes', GatePassController::class);

    // NEW: Generate Slip route (AFTER resource)
    Route::get('gate-passes/slip/{batchNumber}', [GatePassController::class, 'generateSlip'])
        ->name('gate-passes.slip');
});



Route::get('/general-settings', [CaptchaSettingController::class, 'index'])->name('general-settings');
Route::post('/general-settings', [CaptchaSettingController::class, 'update'])->name('general-settings.update');
Route::get('/general-settings/check-domain', [CaptchaSettingController::class, 'checkDomain'])->name('general-settings.check-domain');


// System Settings
Route::get('/system-settings', [SystemSettingController::class, 'index'])
    ->name('settings.system-settings');
Route::post('/admin/settings/system-settings', [SystemSettingController::class, 'update'])
    ->name('settings.system-settings.update');
Route::delete('system-settings/remove-image/{type}', [SystemSettingController::class, 'removeImage'])
    ->name('settings.system-settings.remove-image');
