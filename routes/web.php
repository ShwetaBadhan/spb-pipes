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
// Route::get('/', function () {
//     return view('admin.auth.login');
// })-> name("login");

Route::get('/auth/register', function () {
    return view('admin.auth.register');
})-> name("register");

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

    return view('admin.pages.dashboard', compact('lowStockProducts', 'lowStockRawMaterials'));
})->middleware('auth')->name('dashboard');

// Route::get('/admin-users', function () {
//     return view('admin.pages.admin-users');
// })-> name("admin-users");

// Route::get('/admin-roles', function () {
//     return view('admin.pages.admin-roles');
// })-> name("roles");

// Route::get('/admin-permissions', function () {
//     return view('admin.pages.admin-permissions');
// })-> name("permissions");

// Route::get('/inventory', function () {
//     return view('admin.pages.inventory');
// })-> name("inventory");

Route::get('/products', function () {
    return view('admin.pages.products');
})-> name("products");

// Route::get('/category', function () {
//     return view('admin.pages.category');
// })-> name("category");

// Route::get('/units', function () {
//     return view('admin.pages.units');
// })-> name("units");

// Route::get('/add-product', function () {
//     return view('admin.pages.add-product');
// })-> name("add-product");

// Route::get('/edit-product', function () {
//     return view('admin.pages.edit-product');
// })-> name("edit-product");


Route::get('/admin-roles', function () {
    return view('admin.pages.admin-roles');
})-> name("roles");


// invoice routes

Route::get('/invoices/invoices-view', function () {
    return view('admin.pages.invoices.invoices-view');
})-> name("invoices-view");



Route::get('/invoices/add-invoice', function () {
    return view('admin.pages.invoices.add-invoice');
})-> name("add-invoice");




Route::get('/invoices/edit-invoice', function () {
    return view('admin.pages.invoices.edit-invoice');
})-> name("edit-invoice");



Route::get('/invoices/invoice-details', function () {
    return view('admin.pages.invoices.invoice-details');
})-> name("invoice-details");

// customer routes

// Route::get('/customers/customers-view', function () {
//     return view('admin.pages.customers.customers-view');
// })-> name("customers-view");



// Route::get('/customers/add-customer', function () {
//     return view('admin.pages.customers.add-customer');
// })-> name("add-customer");




// Route::get('/customers/edit-customer', function () {
//     return view('admin.pages.customers.edit-customer');
// })-> name("edit-customers");



// Route::get('/customers/customer-details', function () {
//     return view('admin.pages.customers.customer-details');
// })-> name("customer-details");

// purchase routes

Route::get('/purchases/purchases-view', function () {
    return view('admin.pages.purchases.purchases-view');
})-> name("purchases-view");



Route::get('/purchases/add-purchase', function () {
    return view('admin.pages.purchases.add-purchase');
})-> name("add-purchase");




Route::get('/purchases/edit-purchase', function () {
    return view('admin.pages.purchases.edit-purchase');
})-> name("edit-purchase");

// purchase order routes

Route::get('/purchaseorders/purchase-order-view', function () {
    return view('admin.pages.purchaseorders.purchase-order-view');
})-> name("purchase-order-view");



Route::get('/purchaseorders/add-purchase-order', function () {
    return view('admin.pages.purchaseorders.add-purchase-order');
})-> name("add-purchase-orders");




Route::get('/purchaseorders/edit-purchase-order', function () {
    return view('admin.pages.purchaseorders.edit-purchase-order');
})-> name("edit-purchase-orders");

// suppliers route

Route::get('/suppliers/suppliers-view', function () {
    return view('admin.pages.suppliers.suppliers-view');
})-> name("suppliers");




Route::get('/suppliers/supplier-payment', function () {
    return view('admin.pages.suppliers.supplier-payment');
})-> name("supplier-payment");

// finance routes

Route::get('/finances/expenses', function () {
    return view('admin.pages.finances.expenses');
})-> name("expenses");


Route::get('/finances/incomes', function () {
    return view('admin.pages.finances.incomes');
})-> name("incomes");


Route::get('/finances/payments', function () {
    return view('admin.pages.finances.payments');
})-> name("payments");


Route::get('/finances/transactions', function () {
    return view('admin.pages.finances.transactions');
})-> name("transactions");


Route::get('/finances/bank-accounts', function () {
    return view('admin.pages.finances.bank-accounts');
})-> name("bank-accounts");


Route::get('/finances/money-transfer', function () {
    return view('admin.pages.finances.money-transfer');
})-> name("money-transfer");


Route::get('/settings/account-setting', function () {
    return view('admin.pages.settings.account-setting');
})-> name("account-settings");


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

Route::get('bill-of-materials/by-product/{product}', function($productId) {
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