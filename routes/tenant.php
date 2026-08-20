<?php

declare(strict_types=1);

use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\Admin\LanguageSettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CaptchaSettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailSettingController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\GatePassController;
use App\Http\Controllers\GdprCookieController;
use App\Http\Controllers\IntegrationSettingController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceSettingController;
use App\Http\Controllers\LaborCostAssignmentController;
use App\Http\Controllers\LaborCostReportController;
use App\Http\Controllers\LaborHistoryController;
use App\Http\Controllers\LaborTypeController;
use App\Http\Controllers\LocalizationSettingController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaintenanceModeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\NotificationSettingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductionBatchController;
use App\Http\Controllers\ProductionConsumptionController;
use App\Http\Controllers\ProductionRecipeController;
use App\Http\Controllers\ProductionRuleController;
use App\Http\Controllers\RateTypeController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SecuritySettingController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Controllers\WorkTypeController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\ScopeSessions;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| These routes run on tenant domains only (e.g. foo.localhost). Tenancy is
| initialized per-domain and every request is scoped to the current tenant.
|
*/

Route::middleware(['web', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class, ScopeSessions::class])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Auth Routes (Public)
    |--------------------------------------------------------------------------
    */
    Route::middleware([])->group(function () {
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('login.submit');
        Route::get('/auth/register', fn () => view('admin.auth.register'))->name('register');
        Route::get('/auth/login-as/{token}', [AuthController::class, 'loginAs'])->name('auth.login-as');
        Route::get('/subscription-required', [SubscriptionController::class, 'show'])->name('subscription.required');
    });

    /*
    |--------------------------------------------------------------------------
    | Authenticated Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'subscription.active'])->group(function () {

        // Logout
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /*
        |--------------------------------------------------------------
        | Products, Categories & Units
        |--------------------------------------------------------------
        */
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/add-product', [ProductController::class, 'create'])->name('add-product');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/edit-product/{product}', [ProductController::class, 'edit'])->name('edit-product');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::post('/products/generate-code', [ProductController::class, 'generateCode'])->name('products.generate-code');

        Route::get('/category', [CategoryController::class, 'index'])->name('category');
        Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
        Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.delete');

        Route::get('/units', [UnitController::class, 'index'])->name('units');
        Route::post('/units/store', [UnitController::class, 'store'])->name('units.store');
        Route::get('/units/{unit}/edit', [UnitController::class, 'edit'])->name('units.edit');
        Route::put('/units/{unit}', [UnitController::class, 'update'])->name('units.update');
        Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('units.delete');

        /*
        |--------------------------------------------------------------
        | Customers
        |--------------------------------------------------------------
        */
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/add-customer', [CustomerController::class, 'create'])->name('add-customer');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/edit-customer/{customer}', [CustomerController::class, 'edit'])->name('edit-customer');
        Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
        Route::get('/get-cities/{state}', [LocationController::class, 'getCities'])->name('get.cities');

        /*
        |--------------------------------------------------------------
        | Orders
        |--------------------------------------------------------------
        */
        Route::middleware('tenant.feature:orders')->group(function () {
            Route::prefix('admin')->name('admin.')->group(function () {
                Route::resource('orders', OrderController::class)->except(['edit', 'update']);
                Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
                Route::get('orders/{order}/details', [OrderController::class, 'getOrderDetails'])->name('orders.details');
            });
        });

        /*
        |--------------------------------------------------------------
        | Invoices & Payments
        |--------------------------------------------------------------
        */
        Route::middleware('tenant.feature:invoices')->group(function () {
            Route::prefix('admin/invoices')->name('admin.invoices.')->group(function () {
                Route::get('/', [InvoiceController::class, 'index'])->name('index');
                Route::get('/create', [InvoiceController::class, 'create'])->name('create');
                Route::post('/', [InvoiceController::class, 'store'])->name('store');
                Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
                Route::get('/{invoice}/edit', [InvoiceController::class, 'edit'])->name('edit');
                Route::put('/{invoice}', [InvoiceController::class, 'update'])->name('update');
                Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
                Route::patch('/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('update-status');
                Route::get('/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('pdf');
                Route::get('/{invoice}/add-payment', [PaymentController::class, 'create'])->name('add-payment');
                Route::post('/{invoice}/record-payment', [PaymentController::class, 'store'])->name('record-payment');
                Route::get('/{invoice}/ledger', [PaymentController::class, 'getLedger'])->name('ledger');
                Route::post('/{invoice}/ledger/filter', [InvoiceController::class, 'filterLedger'])->name('ledger.filter');
            });
        });

        /*
        |--------------------------------------------------------------
        | Gate Passes
        |--------------------------------------------------------------
        */
        Route::middleware('tenant.feature:gate_passes')->group(function () {
            Route::name('admin.')->group(function () {
                Route::get('gate-passes/labor-rate/{id}', [GatePassController::class, 'getLaborRate'])->name('gate-passes.labor-rate');
                Route::resource('gate-passes', GatePassController::class);
                Route::get('gate-passes/slip/{batchNumber}', [GatePassController::class, 'generateSlip'])->name('gate-passes.slip');
            });
        });

        /*
        |--------------------------------------------------------------
        | Inventory & Raw Materials
        |--------------------------------------------------------------
        */
        Route::middleware('tenant.feature:inventory')->group(function () {
            Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
            Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
            Route::get('/inventory/history', [InventoryController::class, 'getHistory'])->name('inventory.history');
            Route::delete('/inventory/{log}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
            Route::resource('/rawmaterials/raw-materials', RawMaterialController::class);
        });

        /*
        |--------------------------------------------------------------
        | Production
        |--------------------------------------------------------------
        */
        Route::middleware('tenant.feature:production')->group(function () {
            Route::resource('production-rules', ProductionRuleController::class);
            Route::get('/admin/production-rules/raw-materials/{productId}', [ProductionRuleController::class, 'getRawMaterialsForProduct']);
            Route::resource('production-batches', ProductionBatchController::class);
            Route::resource('bill-of-materials', ProductionRecipeController::class);
            Route::get('bill-of-materials/by-product/{product}', function ($productId) {
                $recipes = \App\Models\ProductionRecipe::with('rawMaterial')
                    ->where('product_id', $productId)->get();
                return response()->json($recipes);
            });
            Route::get('production-batches/consumptions/{batch}', [ProductionConsumptionController::class, 'consumptions'])->name('production-batches.consumptions');
            Route::put('/production-batches/{batch}/consumptions', [ProductionConsumptionController::class, 'update'])->name('production-consumptions.update');
        });

        /*
        |--------------------------------------------------------------
        | Labor
        |--------------------------------------------------------------
        */
        Route::middleware('tenant.feature:labor')->group(function () {
            Route::resource('rate-types', RateTypeController::class)->names('rate-types');
            Route::post('rate-types/{rate_type}/toggle-status', [RateTypeController::class, 'toggleStatus'])->name('rate-types.toggle-status');

            Route::resource('work-types', WorkTypeController::class)->names('work-types');
            Route::post('work-types/{work_type}/toggle-status', [WorkTypeController::class, 'toggleStatus'])->name('work-types.toggle-status');

            Route::resource('labor-types', LaborTypeController::class)->names('labor-types');
            Route::post('labor-types/generate-code', [LaborTypeController::class, 'generateCode'])->name('labor-types.generate-code');
            Route::post('labor-types/{id}/activate', [LaborTypeController::class, 'activate'])->name('labor-types.activate');
            Route::post('labor-types/{id}/deactivate', [LaborTypeController::class, 'deactivate'])->name('labor-types.deactivate');
            Route::post('labor-types/{id}/toggle-status', [LaborTypeController::class, 'toggleStatus'])->name('labor-types.toggle-status');

            Route::resource('labor-cost-assignments', LaborCostAssignmentController::class)->names('labor-cost-assignments');
            Route::get('labor-cost-assignments/labor-type/{id}/details', [LaborCostAssignmentController::class, 'getLaborTypeDetails'])->name('labor-cost-assignments.labor-type-details');

            Route::get('labor-history', [LaborHistoryController::class, 'index'])->name('labor-history.index');
            Route::get('labor-history/export', [LaborHistoryController::class, 'export'])->name('labor-history.export');

            Route::get('labor-cost-reports', [LaborCostReportController::class, 'index'])->name('labor-cost-reports.index');
            Route::get('labor-cost-reports/generate', [LaborCostReportController::class, 'generate'])->name('labor-cost-reports.generate');
            Route::get('labor-cost-reports/export-pdf', [LaborCostReportController::class, 'exportPdf'])->name('labor-cost-reports.export-pdf');
            Route::get('labor-cost-reports/export-excel', [LaborCostReportController::class, 'exportExcel'])->name('labor-cost-reports.export-excel');
        });

        /*
        |--------------------------------------------------------------
        | Purchases (Placeholder Views)
        |--------------------------------------------------------------
        */
        Route::middleware('tenant.feature:purchases')->group(function () {
            Route::get('/purchases/purchases-view', fn () => view('admin.pages.purchases.purchases-view'))->name('purchases-view');
            Route::get('/purchases/add-purchase', fn () => view('admin.pages.purchases.add-purchase'))->name('add-purchase');
            Route::get('/purchases/edit-purchase', fn () => view('admin.pages.purchases.edit-purchase'))->name('edit-purchase');

            Route::get('/purchaseorders/purchase-order-view', fn () => view('admin.pages.purchaseorders.purchase-order-view'))->name('purchase-order-view');
            Route::get('/purchaseorders/add-purchase-order', fn () => view('admin.pages.purchaseorders.add-purchase-order'))->name('add-purchase-orders');
            Route::get('/purchaseorders/edit-purchase-order', fn () => view('admin.pages.purchaseorders.edit-purchase-order'))->name('edit-purchase-orders');
        });

        /*
        |--------------------------------------------------------------
        | Suppliers (Placeholder Views)
        |--------------------------------------------------------------
        */
        Route::middleware('tenant.feature:suppliers')->group(function () {
            Route::get('/suppliers/suppliers-view', fn () => view('admin.pages.suppliers.suppliers-view'))->name('suppliers');
            Route::get('/suppliers/supplier-payment', fn () => view('admin.pages.suppliers.supplier-payment'))->name('supplier-payment');
        });

        /*
        |--------------------------------------------------------------
        | Finances (Placeholder Views)
        |--------------------------------------------------------------
        */
        Route::middleware('tenant.feature:finances')->group(function () {
            Route::get('/finances/expenses', fn () => view('admin.pages.finances.expenses'))->name('expenses');
            Route::get('/finances/incomes', fn () => view('admin.pages.finances.incomes'))->name('incomes');
            Route::get('/finances/payments', fn () => view('admin.pages.finances.payments'))->name('payments');
            Route::get('/finances/transactions', fn () => view('admin.pages.finances.transactions'))->name('transactions');
            Route::get('/finances/bank-accounts', fn () => view('admin.pages.finances.bank-accounts'))->name('bank-accounts');
            Route::get('/finances/money-transfer', fn () => view('admin.pages.finances.money-transfer'))->name('money-transfer');
        });

        /*
        |--------------------------------------------------------------
        | Billing & Subscriptions
        |--------------------------------------------------------------
        */
        Route::get('/plans-billings', [BillingController::class, 'index'])->name('billing.plans-billings');
        Route::post('/billing/checkout', [BillingController::class, 'checkout'])->name('billing.checkout');
        Route::get('/billing/return', [BillingController::class, 'return'])->name('billing.return');
        Route::post('/billing/razorpay/verify', [BillingController::class, 'verifyRazorpay'])->name('billing.razorpay.verify');

        /*
        |--------------------------------------------------------------
        | Admin Users
        |--------------------------------------------------------------
        */
        Route::get('/admin-users', [UserRegisterController::class, 'index'])->name('users.index');
        Route::get('/admin-users/{user}', [UserRegisterController::class, 'show'])->name('users.show');
        Route::post('/admin-users', [UserRegisterController::class, 'store'])->name('users.store');
        Route::put('/admin-users/{user}', [UserRegisterController::class, 'update'])->name('users.update');
        Route::put('/admin-users/{user}/role', [UserRegisterController::class, 'updateRole'])->name('users.update-role');
        Route::delete('/admin-users/{user}', [UserRegisterController::class, 'destroy'])->name('users.destroy');

        /*
        |--------------------------------------------------------------
        | Roles & Permissions
        |--------------------------------------------------------------
        */
        Route::get('/admin-roles', [RolePermissionController::class, 'rolesIndex'])->name('roles.index');
        Route::post('/admin-roles', [RolePermissionController::class, 'store'])->name('roles.storeRole');
        Route::put('/admin-roles/{role}', [RolePermissionController::class, 'update'])->name('roles.updateRole');
        Route::delete('/admin-roles/{role}', [RolePermissionController::class, 'destroy'])->name('roles.destroyRole');
        Route::put('/admin-roles/{role}/permissions', [RolePermissionController::class, 'updateRolePermissions'])->name('roles.update-permissions');

        Route::get('/admin-permissions', [RolePermissionController::class, 'permissionsIndex'])->name('permissions.index');
        Route::post('/admin-permissions', [RolePermissionController::class, 'storePermission'])->name('permissions.store');
        Route::put('/admin-permissions/{permission}', [RolePermissionController::class, 'updatePermission'])->name('permissions.update');
        Route::delete('/admin-permissions/{permission}', [RolePermissionController::class, 'destroyPermission'])->name('permissions.destroy');

        /*
        |--------------------------------------------------------------
        | Settings — Account
        |--------------------------------------------------------------
        */
        Route::prefix('general-settings')->group(function () {
            Route::get('account-settings', [AccountSettingsController::class, 'index'])->name('account-settings');
            Route::put('account-settings', [AccountSettingsController::class, 'update'])->name('account-settings.update');
            Route::get('account-settings/cities/{stateId}', [AccountSettingsController::class, 'getCitiesByState'])->name('account-settings.cities');
            Route::delete('account-settings/image', [AccountSettingsController::class, 'deleteProfileImage'])->name('account-settings.image.delete');
        });

        /*
        |--------------------------------------------------------------
        | Settings — General (Captcha)
        |--------------------------------------------------------------
        */
        Route::get('/general-settings', [CaptchaSettingController::class, 'index'])->name('general-settings');
        Route::post('/general-settings', [CaptchaSettingController::class, 'update'])->name('general-settings.update');
        Route::get('/general-settings/check-domain', [CaptchaSettingController::class, 'checkDomain'])->name('general-settings.check-domain');

        /*
        |--------------------------------------------------------------
        | Settings — Security
        |--------------------------------------------------------------
        */
        Route::prefix('security-settings')->group(function () {
            Route::get('/', [SecuritySettingController::class, 'index'])->name('security-settings');
            Route::post('update', [SecuritySettingController::class, 'updateSettings'])->name('security-settings.update');
            Route::post('password', [SecuritySettingController::class, 'changePassword'])->name('security-settings.password');
            Route::post('phone', [SecuritySettingController::class, 'updatePhone'])->name('security-settings.phone');
            Route::delete('phone', [SecuritySettingController::class, 'removePhone'])->name('security-settings.phone.remove');
            Route::post('email', [SecuritySettingController::class, 'updateEmail'])->name('security-settings.email');
            Route::post('deactivate', [SecuritySettingController::class, 'deactivateAccount'])->name('security-settings.deactivate');
            Route::post('delete', [SecuritySettingController::class, 'deleteAccount'])->name('security-settings.delete');
            Route::delete('device/{id}', [SecuritySettingController::class, 'deleteDevice'])->name('security-settings.device.delete');
        });

        /*
        |--------------------------------------------------------------
        | Settings — Notifications
        |--------------------------------------------------------------
        */
        Route::prefix('notifications-settings')->group(function () {
            Route::get('/', [NotificationSettingController::class, 'index'])->name('notifications-settings');
            Route::post('update', [NotificationSettingController::class, 'update'])->name('notifications-settings.update');
        });

        /*
        |--------------------------------------------------------------
        | Settings — Integrations
        |--------------------------------------------------------------
        */
        Route::prefix('integrations-settings')->group(function () {
            Route::get('/', [IntegrationSettingController::class, 'index'])->name('integrations-settings');
            Route::post('{integrationKey}/toggle', [IntegrationSettingController::class, 'toggle'])->name('integrations-settings.toggle');
            Route::delete('{integrationKey}/remove', [IntegrationSettingController::class, 'remove'])->name('integrations-settings.remove');
            Route::get('{integrationKey}/callback', [IntegrationSettingController::class, 'connectCallback'])->name('integrations-settings.callback');
            Route::get('{integrationKey}/connect', [IntegrationSettingController::class, 'connect'])->name('integrations-settings.connect');
        });

        /*
        |--------------------------------------------------------------
        | Settings — Website Settings
        |--------------------------------------------------------------
        */
        Route::get('/ai-configuration', fn () => view('admin.pages.settings.website-settings.ai-configuration'))->name('ai-configuration');
        Route::get('/appearance-settings', fn () => view('admin.pages.settings.website-settings.appearance-settings'))->name('appearance-settings');
        Route::get('/authentication-settings', fn () => view('admin.pages.settings.website-settings.authentication-settings'))->name('authentication-settings');
        Route::get('/plugin-manager', fn () => view('admin.pages.settings.website-settings.plugin-manager'))->name('plugin-manager');
        Route::get('/preference-settings', fn () => view('admin.pages.settings.website-settings.preference-settings'))->name('preference-settings');
        Route::get('/prefixes-settings', fn () => view('admin.pages.settings.website-settings.prefixes-settings'))->name('prefixes-settings');
        Route::get('/seo-setup', fn () => view('admin.pages.settings.website-settings.seo-setup'))->name('seo-setup');

        Route::prefix('language-settings')->group(function () {
            Route::get('/', [LanguageSettingController::class, 'index'])->name('language-settings');
            Route::post('/', [LanguageSettingController::class, 'store'])->name('language-settings.store');
            Route::put('/{id}', [LanguageSettingController::class, 'update'])->name('language-settings.update');
            Route::delete('/{id}', [LanguageSettingController::class, 'destroy'])->name('language-settings.destroy');
            Route::post('/{id}/toggle-status', [LanguageSettingController::class, 'toggleStatus'])->name('language-settings.toggle-status');
            Route::post('/{id}/toggle-rtl', [LanguageSettingController::class, 'toggleRTL'])->name('language-settings.toggle-rtl');
            Route::post('/{id}/set-default', [LanguageSettingController::class, 'setDefault'])->name('language-settings.set-default');
            Route::post('/{id}/toggle-platform/{platform}', [LanguageSettingController::class, 'togglePlatform'])->name('language-settings.toggle-platform');
        });

        Route::prefix('localization-settings')->group(function () {
            Route::get('/', [LocalizationSettingController::class, 'index'])->name('localization-settings');
            Route::post('/', [LocalizationSettingController::class, 'update'])->name('localization-settings.update');
        });

        Route::prefix('maintenance-mode')->group(function () {
            Route::get('/', [MaintenanceModeController::class, 'index'])->name('maintenance-mode');
            Route::put('/', [MaintenanceModeController::class, 'update'])->name('maintenance-mode.update');
        });

        /*
        |--------------------------------------------------------------
        | Settings — App Settings
        |--------------------------------------------------------------
        */
        Route::get('/barcode-settings', fn () => view('admin.pages.settings.app-settings.barcode-settings'))->name('barcode-settings');
        Route::get('/custom-fields', fn () => view('admin.pages.settings.app-settings.custom-fields'))->name('custom-fields');
        Route::get('/esignatures', fn () => view('admin.pages.settings.app-settings.esignatures'))->name('esignatures');
        Route::get('/sass-settings', fn () => view('admin.pages.settings.app-settings.sass-settings'))->name('sass-settings');
        Route::get('/thermal-printer', fn () => view('admin.pages.settings.app-settings.thermal-printer'))->name('thermal-printer');

        Route::prefix('invoice-settings')->group(function () {
            Route::get('/', [InvoiceSettingController::class, 'index'])->name('invoice-settings');
            Route::post('/', [InvoiceSettingController::class, 'store'])->name('invoice-settings.store');
            Route::get('/templates', [InvoiceSettingController::class, 'templates'])->name('invoice-templates-settings');
        });

        /*
        |--------------------------------------------------------------
        | Settings — Finance Settings
        |--------------------------------------------------------------
        */
        Route::prefix('bank-accounts')->group(function () {
            Route::get('/', [BankAccountController::class, 'index'])->name('bank-accounts-settings');
            Route::post('/', [BankAccountController::class, 'store'])->name('bank-accounts.store');
            Route::put('/{id}', [BankAccountController::class, 'update'])->name('bank-accounts.update');
            Route::delete('/{id}', [BankAccountController::class, 'destroy'])->name('bank-accounts.destroy');
        });

        Route::prefix('currencies')->group(function () {
            Route::get('/', [CurrencyController::class, 'index'])->name('currencies');
            Route::post('/', [CurrencyController::class, 'store'])->name('currencies.store');
            Route::put('/{id}', [CurrencyController::class, 'update'])->name('currencies.update');
            Route::delete('/{id}', [CurrencyController::class, 'destroy'])->name('currencies.destroy');
            Route::patch('/{id}/toggle', [CurrencyController::class, 'toggleStatus'])->name('currencies.toggle');
            Route::post('/{id}/set-default', [CurrencyController::class, 'setDefault'])->name('currencies.default');
        });

        Route::prefix('payment-methods')->group(function () {
            Route::get('/', [PaymentMethodController::class, 'index'])->name('payment-methods');
            Route::post('/', [PaymentMethodController::class, 'store'])->name('payment-methods.store');
            Route::put('/{id}', [PaymentMethodController::class, 'update'])->name('payment-methods.update');
            Route::patch('/{id}/toggle', [PaymentMethodController::class, 'toggleStatus'])->name('payment-methods.toggle');
            Route::delete('/{id}', [PaymentMethodController::class, 'destroy'])->name('payment-methods.destroy');
            Route::post('/{id}/test-connection', [PaymentMethodController::class, 'testConnection'])->name('payment-methods.test-connection');
        });

        Route::prefix('tax-rates')->group(function () {
            Route::get('/', [TaxController::class, 'index'])->name('tax-rates');
            Route::post('/', [TaxController::class, 'storeRate'])->name('tax-rates.store');
            Route::put('/{id}', [TaxController::class, 'updateRate'])->name('tax-rates.update');
            Route::delete('/{id}', [TaxController::class, 'destroyRate'])->name('tax-rates.destroy');
        });

        Route::prefix('tax-groups')->group(function () {
            Route::post('/', [TaxController::class, 'storeGroup'])->name('tax-groups.store');
            Route::put('/{id}', [TaxController::class, 'updateGroup'])->name('tax-groups.update');
            Route::delete('/{id}', [TaxController::class, 'destroyGroup'])->name('tax-groups.destroy');
        });

        /*
        |--------------------------------------------------------------
        | Settings — System Settings
        |--------------------------------------------------------------
        */
        Route::prefix('email-settings')->group(function () {
            Route::get('/', [EmailSettingController::class, 'index'])->name('email-settings');
            Route::post('/', [EmailSettingController::class, 'store'])->name('email-settings.store');
            Route::put('/{id}', [EmailSettingController::class, 'update'])->name('email-settings.update');
            Route::patch('/{id}/toggle', [EmailSettingController::class, 'toggleStatus'])->name('email-settings.toggle');
            Route::delete('/{id}', [EmailSettingController::class, 'destroy'])->name('email-settings.destroy');
            Route::post('/{id}/send-test', [EmailSettingController::class, 'sendTestEmail'])->name('email-settings.send-test');
        });

        Route::prefix('email-templates')->group(function () {
            Route::get('/', [EmailTemplateController::class, 'index'])->name('email-templates');
            Route::post('/', [EmailTemplateController::class, 'store'])->name('email-templates.store');
            Route::put('/{id}', [EmailTemplateController::class, 'update'])->name('email-templates.update');
            Route::delete('/{id}', [EmailTemplateController::class, 'destroy'])->name('email-templates.destroy');
            Route::patch('/{id}/toggle', [EmailTemplateController::class, 'toggleStatus'])->name('email-templates.toggle');
            Route::get('/{id}/preview', [EmailTemplateController::class, 'preview'])->name('email-templates.preview');
        });

        Route::prefix('gdpr-cookies')->group(function () {
            Route::get('/', [GdprCookieController::class, 'index'])->name('gdpr-cookies');
            Route::post('/', [GdprCookieController::class, 'store'])->name('gdpr-cookies.store');
            Route::patch('/toggle', [GdprCookieController::class, 'toggleStatus'])->name('gdpr-cookies.toggle');
        });

        Route::get('/sms-gateways', fn () => view('admin.pages.settings.system-settings.sms-gateways'))->name('sms-gateways');

        Route::prefix('system-settings')->group(function () {
            Route::get('/', [SystemSettingController::class, 'index'])->name('settings.system-settings');
            Route::post('/admin/update', [SystemSettingController::class, 'update'])->name('settings.system-settings.update');
            Route::delete('/remove-image/{type}', [SystemSettingController::class, 'removeImage'])->name('settings.system-settings.remove-image');
        });

        /*
        |--------------------------------------------------------------
        | Settings — Other Settings (Placeholder Views)
        |--------------------------------------------------------------
        */
        Route::get('/clear-cache', fn () => view('admin.pages.settings.other-settings.clear-cache'))->name('clear-cache');
        Route::get('/cronjob', fn () => view('admin.pages.settings.other-settings.cronjob'))->name('cronjob');
        Route::get('/custom-css', fn () => view('admin.pages.settings.other-settings.custom-css'))->name('custom-css');
        Route::get('/custom-js', fn () => view('admin.pages.settings.other-settings.custom-js'))->name('custom-js');
        Route::get('/database-backup', fn () => view('admin.pages.settings.other-settings.database-backup'))->name('database-backup');
        Route::get('/sitemap', fn () => view('admin.pages.settings.other-settings.sitemap'))->name('sitemap');
        Route::get('/storage-settings', fn () => view('admin.pages.settings.other-settings.storage-settings'))->name('storage-settings');
        Route::get('/system-backup', fn () => view('admin.pages.settings.other-settings.system-backup'))->name('system-backup');
        Route::get('/system-update', fn () => view('admin.pages.settings.other-settings.system-update'))->name('system-update');
    });

    /*
    |--------------------------------------------------------------
    | Debug / Test Routes
    |--------------------------------------------------------------
    */
    Route::get('/test-stock', function () {
        $product = \App\Models\Product::first();
        if (! $product) {
            return 'No product found';
        }
        $available = \App\Services\InventoryService::productAvailableQty($product->id);
        dd("Product: {$product->name}, Available: {$available}");
    });

    /*
    |--------------------------------------------------------------
    | Fallback
    |--------------------------------------------------------------
    */
    Route::fallback(fn () => abort(404));
});
