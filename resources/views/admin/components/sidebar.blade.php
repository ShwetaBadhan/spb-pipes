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
                    <a href="" class="dropdown-item d-flex align-items-center">
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
                <img src="{{ $system_white_logo ? asset('storage/' . $system_white_logo) : asset('assets/img/logo-spb.png') }} " alt="Logo">

            </a>
            <a href="{{ route('dashboard') }}" class="logo-small">

                <img src="{{ $system_single_logo ? asset('storage/' . $system_single_logo) : asset('assets/img/logo-small.png') }} " alt="Logo">

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

                                <a href="javascript:void(0);">
                                    <i class="isax isax-box5"></i><span>Product / Services</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>

                                    <li><a href="{{ route('products.index') }}">Products</a></li>

                                    <li><a href="{{ route('category') }}">Category</a></li>

                                    <li><a href="{{ route('units') }}">Units</a></li>

                                </ul>

                            </li>
                            <li class="submenu">

                                <a href="javascript:void(0);">
                                    <i class="isax isax-box5"></i><span>Production</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>

                                    <li><a href="{{ route('production-rules.index') }}">Add Rules</a></li>
                                    <li><a href="{{ route('production-batches.index') }}">Add Batches</a></li>
                                    <li><a href="{{ route('bill-of-materials.index') }}">Bill of Materials (BOM)</a>
                                    </li>
                                    {{-- <li>
    <a href="{{ route('production-batches.consumptions') }}">
        Production Consumption
    </a>

</li> --}}



                                </ul>

                            </li>
                            <li>

                                <a href="{{ route('raw-materials.index') }}">
                                    <i class="isax isax-layer5"></i>

                                    <span>Raw Material</span>
                                </a>


                            </li>
                            <li>

                                <a href="{{ route('inventory.index') }}">
                                    <i class="isax isax-lifebuoy5"></i><span>Inventory</span>
                                </a>

                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-receipt-item5"></i><span>Accounts</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('admin.invoices.index') }}">Invoices</a></li>
                                    <li><a href="{{ route('admin.invoices.create') }}">Create Invoice</a></li>
                                    {{-- <li><a href="{{ route('admin.invoices.add-payment') }}">Create Payment</a></li>
 --}}

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
                    <li class="menu-title"><span>Order Management</span></li>
                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-shopping-cart"></i>
                                    <span>Orders</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('admin.orders.index') }}">All Orders</a></li>
                                    {{-- <li><a href="{{ route('admin.orders.create') }}">Create New Order</a></li> --}}

                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-title"><span>Gate Pass Management</span></li>
                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-scan"></i>
                                    <span>Gate Pass</span>


                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <!-- CORRECTED ROUTE NAME BELOW -->
                                    <li><a href="{{ route('admin.gate-passes.index') }}">All Passes</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-title"><span>Costing</span></li>
                    <li>
                        <ul>
                            <!-- ⚙️ LABOR MASTER (COMMON) -->
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-user-edit"></i>
                                    <span>Labor Management</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('work-types.index') }}">Manage Work Types</a></li>
                                    <li><a href="{{ route('rate-types.index') }}">Manage Rate Types</a></li>
                                    <li><a href="{{ route('labor-types.index') }}">Manage Labor Types</a></li>
                                    <li><a href="{{ route('labor-cost-assignments.index') }}">Labor Cost
                                            Assignment</a></li>
                                    <li><a href="{{ route('labor-history.index') }}">Labor History</a></li>
                                    <li><a href="{{ route('labor-cost-reports.index') }}">Labor Cost Reports</a></li>
                                </ul>
                            </li>


                        </ul>
                    </li>

                    {{-- <li class="menu-title"><span>Purchases</span></li>
                    <li>
                        <ul>
                            <!-- Purchases -->
                            <li>

                                <a href="{{ route('purchases-view') }}">
                                    <i class="isax isax-bag-tick-25"></i><span>Purchases</span>
                                </a>

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
                    </li> --}}
                    {{-- <li class="menu-title"><span>Finance & Accounts</span></li>
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
                    </li> --}}
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
                    <li class="menu-title"><span>Administration</span></li>
                    <li>
                        <ul>

                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-setting-25"></i><span>Settings</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('general-settings') }}">General Settings</a>

                                    </li>


                                    <li>
                                        <a href="{{ route('settings.system-settings') }}">System Settings</a>

                                    </li>


                                </ul>
                            </li>
                        </ul>
                    </li>



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
