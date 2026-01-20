<!-- Sidenav Menu Start -->
<div class="two-col-sidebar" id="two-col-sidebar">
    <div class="twocol-mini">

        <!-- Add -->
        <div class="dropdown">
            <a class="btn btn-primary bg-gradient btn-sm btn-icon rounded-circle d-flex align-items-center justify-content-center"
                data-bs-toggle="dropdown" href="javascript:void(0);" role="button" data-bs-display="static"
                data-bs-reference="parent">
                <i class="isax isax-add"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-start">
                <li>
                    <a href="{{ route('add-invoice') }}" class="dropdown-item d-flex align-items-center">
                        <i class="isax isax-document-text-1 me-2"></i>Invoice
                    </a>
                </li>
                <li>
                    <a href="{{ route('expenses') }}" class="dropdown-item d-flex align-items-center">
                        <i class="isax isax-money-send me-2"></i>Expense
                    </a>
                </li>


                <li>
                    <a href="{{ route('add-purchase-orders') }}" class="dropdown-item d-flex align-items-center">
                        <i class="isax isax-document me-2"></i>Purchase Order
                    </a>
                </li>


            </ul>
        </div>
        <!-- /Add -->

        <ul class="menu-list">
            <li>
                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-title="Settings"><i class="isax isax-setting-25"></i></a>
            </li>
            <li>
                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-title="Documentation"><i class="isax isax-document-normal4"></i></a>
            </li>
            <li>
                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-title="Changelog"><i class="isax isax-cloud-change5"></i></a>
            </li>
            <li>
                <a href="{{ route('login') }}"><i class="isax isax-login-15"></i></a>
            </li>
        </ul>
    </div>
    <div class="sidebar" id="sidebar-two">

        <!-- Start Logo -->
        <div class="sidebar-logo">
            <a href="{{ route('dashboard') }}" class="logo logo-normal">
                <img src="{{ url('assets/img/logo/logo-spb.png') }} " alt="Logo">

            </a>
            <a href="{{ route('dashboard') }}" class="logo-small">
                <img src="{{ url('assets/img/logo-small.svg') }}" alt="Logo">
            </a>
            <a href="{{ route('dashboard') }}" class="dark-logo">
                <img src="{{ url('assets/img/logo-white.svg') }}" alt="Logo">
            </a>
            <a href="{{ route('dashboard') }}" class="dark-small">
                <img src="{{ url('assets/img/logo-small-white.svg') }}" alt="Logo">
            </a>

            <!-- Sidebar Hover Menu Toggle Button -->
            <a id="toggle_btn" href="javascript:void(0);">
                <i class="isax isax-menu-1"></i>
            </a>
        </div>
        <!-- End Logo -->

        <!-- Search -->
        <div class="sidebar-search">
            <div class="input-icon-end position-relative">
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-icon-addon">
                    <i class="isax isax-search-normal"></i>
                </span>
            </div>
        </div>
        <!-- /Search -->

        <!--- Sidenav Menu -->
        <div class="sidebar-inner" data-simplebar>
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title"><span>Main</span></li>
                    <li>
                        <ul>
                            <li>
                                <a href="{{ route('dashboard') }}" class="active">
                                    <i class="isax isax-element-45"></i><span>Dashboard</span>

                                </a>

                            </li>



                        </ul>
                    </li>
                    <li class="menu-title"><span>Inventory & Sales</span></li>
                    <li>
                        <ul>
                            <li class="submenu">
                                @canany(['view-product', 'view-category', 'view-unit'])
                                    <a href="javascript:void(0);">
                                        <i class="isax isax-box5"></i><span>Product / Services</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        @can('view-product')
                                            <li><a href="{{ route('products.index') }}">Products</a></li>
                                        @endcan
                                        @can('view-category')
                                            <li><a href="{{ route('category') }}">Category</a></li>
                                        @endcan
                                        @can('view-unit')
                                            <li><a href="{{ route('units') }}">Units</a></li>
                                        @endcan
                                    </ul>
                                @endcanany
                            </li>
                            <li>
                                @can('view-inventory')
                                    <a href="{{ route('inventory.index') }}">
                                        <i class="isax isax-lifebuoy5"></i><span>Inventory</span>
                                    </a>
                                @endcan
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-receipt-item5"></i><span>Accounts</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('invoices-view') }}">Invoices</a></li>
                                    <li><a href="{{ route('add-invoice') }}">Create Invoice</a></li>
                                    <li><a href="{{ route('invoice-details') }}">Invoice Details</a></li>


                                </ul>
                            </li>


                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-profile-2user5"></i><span>Customers</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('customers.index') }}">Customers</a></li>
                                    <li><a href="">Customer Details</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-title"><span>Purchases</span></li>
                    <li>
                        <ul>
                            <!-- Purchases -->
                            <li>
                                @can('view-purchase')
                                    <a href="{{ route('purchases-view') }}">
                                        <i class="isax isax-bag-tick-25"></i><span>Purchases</span>
                                    </a>
                                @endcan
                            </li>
                            <li>
                                <a href="{{ route('purchase-order-view') }}">
                                    <i class="isax isax-document-forward5"></i><span>Purchase Orders</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('suppliers') }}">
                                    <i class="isax isax-security-user5"></i><span>Suppliers</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('supplier-payment') }}">
                                    <i class="isax isax-coin-15"></i><span>Supplier Payments</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-title"><span>Finance & Accounts</span></li>
                    <li>
                        <ul>
                            <li>
                                <a href="{{ route('expenses') }}">
                                    <i class="isax isax-money-send5"></i><span>Expenses</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('incomes') }}">
                                    <i class="isax isax-money-recive5"></i><span>Incomes</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('payments') }}">
                                    <i class="isax isax-money-tick5"></i><span>Payments</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('transactions') }}">
                                    <i class="isax isax-moneys5"></i><span>Transactions</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('bank-accounts') }}">
                                    <i class="isax isax-card-tick-15"></i><span>Bank Accounts</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('money-transfer') }}">
                                    <i class="isax isax-convert-card5"></i><span>Money Transfer</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-title"><span>Manage</span></li>
                    <li>
                        <ul>
                            <!-- Manage Users (Admin Only) -->
                            <li class="submenu">
                              
                                    <a href="javascript:void(0);">
                                        <i class="isax isax-profile-2user5"></i><span>Manage Users</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li><a href="{{ route('users.index') }}">Admin Users</a></li>
                                        <li><a href="{{ route('roles.index') }}">Roles</a></li>
                                        <li><a href="{{ route('permissions.index') }}">Permissions</a></li>
                                    </ul>
                              
                            </li>



                        </ul>
                    </li>
                    {{-- <li class="menu-title"><span>Administration</span></li>
							<li>
								<ul>
									<li class="submenu">
										<a href="javascript:void(0);">
											<i class="isax isax-chart-35"></i><span>Reports</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li class="submenu submenu-two">
												<a href="javascript:void(0);">Item Reports<span class="menu-arrow"></span></a>
												<ul>
													<li><a href="stock-summary">Stock Summary</a></li>
													<li><a href="inventory-report">Inventory</a></li>
													<li><a href="best-seller">Best Seller</a></li>
													<li><a href="low-stock">Low Stock</a></li>
													<li><a href="stock-history">Stock History</a></li>
													<li><a href="sold-stock">Sold Stock</a></li>
												</ul>
											</li>
											<li class="submenu submenu-two">
												<a href="javascript:void(0);">Transaction Reports<span class="menu-arrow"></span></a>
												<ul>
													<li><a href="sales-report.html">Sales</a></li>
													<li><a href="sales-returns.html">Sales Return</a></li>
													<li><a href="sales-orders.html">Sales Orders</a></li>
													<li><a href="purchases-report.html">Purchases</a></li>
													<li><a href="purchase-return-report.html">Purchase Return</a></li>
													<li><a href="purchase-orders-report.html">Purchase Orders</a></li>
													<li><a href="quotation-report.html">Quotation</a></li>
												</ul>
											</li>
											<li class="submenu submenu-two">
												<a href="javascript:void(0);">Finance Reports<span class="menu-arrow"></span></a>
												<ul>
													<li><a href="payment-summary.html">Payment Summary</a></li>
													<li><a href="tax-report.html">Taxes</a></li>
												</ul>
											</li>
											<li class="submenu submenu-two">
												<a href="javascript:void(0);">Accounting Reports<span class="menu-arrow"></span></a>
												<ul>
													<li><a href="expense-report.html">Expenses</a></li>
													<li><a href="income-report.html">Income</a></li>
													<li><a href="profit-loss-report.html">Profit & Loss</a></li>
													<li><a href="annual-report.html">Annual Report</a></li>
													<li><a href="balance-sheet.html">Balance Sheet</a></li>
													<li><a href="trial-balance.html">Trial Balance</a></li>
													<li><a href="cash-flow.html">Cash Flow</a></li>
													<li><a href="account-statement.html">Account Statement</a></li>
												</ul>
											</li>
											<li class="submenu submenu-two">
												<a href="javascript:void(0);">User Reports<span class="menu-arrow"></span></a>
												<ul>
													<li>
														<a href="customers-report.html">Customers</a>
													</li>
													<li>
														<a href="customer-due-report.html">Customer Due Report</a>
													</li>
													<li>
														<a href="supplier-report.html">Supplier</a>
													</li>
												</ul>
											</li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">
											<i class="isax isax-setting-25"></i><span>Settings</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li class="submenu submenu-two">
												<a href="javascript:void(0);">General Settings<span class="menu-arrow"></span></a>
												<ul>
													<li><a href="account-settings.html">Account Settings</a></li>
													<li><a href="plans-billings.html">Plans & Billing</a></li>
													<li><a href="notifications-settings.html">Notifications</a></li>
													<li><a href="integrations-settings.html">Integrations</a></li>
												</ul>
											</li>
											<li class="submenu submenu-two">
												<a href="javascript:void(0);">Website Settings<span class="menu-arrow"></span></a>
												<ul>
													<li><a href="company-settings.html">Company Settings</a></li>
													<li><a href="localization-settings.html">Localization</a></li>
													<li><a href="preference-settings.html">Preference</a></li>
													<li><a href="seo-setup.html">SEO Setup</a></li>
													<li><a href="language-settings.html">Language</a></li>
													<li><a href="maintenance-mode.html">Maintenance Mode</a></li>
													<li><a href="authentication-settings.html">Authentication</a></li>
													<li><a href="ai-configuration.html">AI Configuration</a></li>
													<li><a href="appearance-settings.html">Appearance</a></li>
													<li><a href="plugin-manager.html">Plugin Manager</a></li>
												</ul>
											</li>
											<li class="submenu submenu-two">
												<a href="javascript:void(0);">App Settings<span class="menu-arrow"></span></a>
												<ul>
													<li><a href="invoice-settings.html">Invoice Settings</a></li>
													<li><a href="invoice-templates-settings.html">Invoice Templates</a></li>
													<li><a href="esignatures.html">eSignatures</a></li>
													<li><a href="barcode-settings.html">Barcode</a></li>
													<li><a href="thermal-printer.html">Thermal Printer</a></li>
													<li><a href="custom-fields.html">Custom Fields</a></li>
													<li><a href="sass-settings.html">SaaS Settings</a></li>
												</ul>
											</li>
											<li class="submenu submenu-two">
												<a href="javascript:void(0);">System Settings<span class="menu-arrow"></span></a>
												<ul>
													<li><a href="email-settings.html">Email Settings</a></li>
													<li><a href="email-templates.html">Email Templates</a></li>
													<li><a href="sms-gateways.html">SMS Gateways</a></li>
													<li><a href="gdpr-cookies.html">GDPR Cookies</a></li>
												</ul>
											</li>
											<li class="submenu submenu-two">
												<a href="javascript:void(0);">Finance Settings<span class="menu-arrow"></span></a>
												<ul>
													<li>
														<a href="payment-methods.html">Payment Methods</a>
													</li>
													<li>
														<a href="bank-accounts.html">Bank Accounts</a>
													</li>
													<li>
														<a href="tax-rates.html">Tax Rates</a>
													</li>
													<li>
														<a href="currencies.html">Currencies</a>
													</li>
												</ul>
											</li>
											<li class="submenu submenu-two">
												<a href="javascript:void(0);">Other Settings<span class="menu-arrow"></span></a>
												<ul>
													<li>
														<a href="custom-css.html">Custom CSS</a>
													</li>
													<li>
														<a href="custom-js.html">Custom JS</a>
													</li>
													<li>
														<a href="clear-cache.html">Clear Cache</a>
													</li>
													<li>
														<a href="sitemap.html">Sitemap</a>
													</li>
													<li>
														<a href="storage.html">Storage</a>
													</li>
													<li>
														<a href="cronjob.html">Cronjob</a>
													</li>
													<li>
														<a href="system-backup.html">System Backup</a>
													</li>
													<li>
														<a href="database-backup.html">Database Backup</a>
													</li>
												</ul>
											</li>
										</ul>
									</li>
								</ul>
							</li>
							 --}}


                    {{-- <li class="menu-title"><span>Authentication</span></li>
							<li>
								<ul>
									<li>
										<a href="{{ route("login") }}">
											<i class="isax isax-login-15"></i><span>Login</span>
										</a>
									</li>
									
									<li>
										<a href="forgot-password.html">
											<i class="isax isax-password-check5"></i><span>Forgot Password</span>
										</a>
									</li>
									<li>
										<a href="reset-password.html">
											<i class="isax isax-refresh-right-square5"></i><span>Reset Password</span>
										</a>
									</li>
									<li>
										<a href="email-verification.html">
											<i class="isax isax-sms-tracking5"></i><span>Email Verification</span>
										</a>
									</li>
									<li>
										<a href="two-step-verification.html">
											<i class="isax isax-security5"></i><span>2 Step Verification</span>
										</a>
									</li>
									<li>
										<a href="lock-screen.html">
											<i class="isax isax-lock-circle5"></i><span>Lock Screen</span>
										</a>
									</li>
								</ul>
							</li>
						 --}}

                </ul>

            </div>
        </div>
    </div>
</div>
<!-- Sidenav Menu End -->
