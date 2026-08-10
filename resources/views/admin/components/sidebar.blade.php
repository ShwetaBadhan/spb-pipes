<div class="main-wrapper">		

<!-- Sidenav Menu Start -->
<div class="two-col-sidebar" id="two-col-sidebar">

    <div class="sidebar" id="sidebar-two">

        <!-- Start Logo -->
        <div class="sidebar-logo">
            <a href="{{ route('dashboard') }}" class="logo logo-normal">
                <img src="{{ $system_white_logo ? asset('storage/' . $system_white_logo) : asset('assets/img/logo-spb.png') }} "
                    alt="Logo">
            </a>
            <a href="{{ route('dashboard') }}" class="logo-small">
                <img src="{{ $system_single_logo ? asset('storage/' . $system_single_logo) : asset('assets/img/logo-small.png') }} "
                    alt="Logo">
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
                            @can('view-dashboard')
                                <li>
                                    <a href="{{ route('dashboard') }}"
                                        class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                        <i class="isax isax-element-45"></i><span>Dashboard</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>

                    @canany(['view-inventory-sales', 'view-products', 'manage-products', 'manage-category',
                        'manage-units', 'manage-production', 'manage-raw-materials', 'view-inventory', 'manage-invoices',
                        'manage-customers'])
                        <li class="menu-title"><span>Inventory & Sales</span></li>

                        <li>
                            <ul>
                                <!-- Product / Services -->
                                @canany(['view-products', 'manage-products', 'manage-category', 'manage-units'])
                                    <li class="submenu">
                                        @can('view-products')
                                            <a href="javascript:void(0);">
                                                <i class="isax isax-box5"></i><span>Product / Services</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                        @endcan
                                        <ul>
                                            @can('manage-products')
                                                <li>
                                                    <a href="{{ route('products.index') }}"
                                                        class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Products</a>
                                                </li>
                                            @endcan

                                            @can('manage-category')
                                                <li>
                                                    <a href="{{ route('category') }}"
                                                        class="{{ request()->routeIs('category*') ? 'active' : '' }}">Category</a>
                                                </li>
                                            @endcan

                                            @can('manage-units')
                                                <li>
                                                    <a href="{{ route('units') }}"
                                                        class="{{ request()->routeIs('units*') ? 'active' : '' }}">Units</a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcanany

                                <!-- Production -->
                                @canany(['manage-production', 'manage-production-rules', 'manage-production-batches',
                                    'manage-bom'])
                                    <li class="submenu">
                                        @can('manage-production')
                                            <a href="javascript:void(0);">
                                                <i class="isax isax-box5"></i><span>Production</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                        @endcan
                                        <ul>
                                            @can('manage-production-rules')
                                                <li><a href="{{ route('production-rules.index') }}" class="{{ request()->routeIs('production-rules.*') ? 'active' : '' }}">Add Rules</a></li>
                                            @endcan

                                            @can('manage-production-batches')
                                                <li><a href="{{ route('production-batches.index') }}" class="{{ request()->routeIs('production-batches.*') ? 'active' : '' }}">Add Batches</a></li>
                                            @endcan

                                            @can('manage-bom')
                                                <li><a href="{{ route('bill-of-materials.index') }}" class="{{ request()->routeIs('bill-of-materials.*') ? 'active' : '' }}">Bill of Materials (BOM)</a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcanany

                                <!-- Raw Material -->
                                @can('manage-raw-materials')
                                    <li>
                                        <a href="{{ route('raw-materials.index') }}" class="{{ request()->routeIs('raw-materials.*') ? 'active' : '' }}">
                                            <i class="isax isax-layer5"></i>
                                            <span>Raw Material</span>
                                        </a>
                                    </li>
                                @endcan

                                <!-- Inventory -->
                                @can('view-inventory')
                                    <li>
                                        <a href="{{ route('inventory.index') }}" class="{{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                                            <i class="isax isax-lifebuoy5"></i><span>Inventory</span>
                                        </a>
                                    </li>
                                @endcan

                                <!-- Accounts -->
                                @canany(['manage-invoices', 'view-invoices', 'create-invoices'])
                                    <li class="submenu">
                                        @can('manage-invoices')
                                            <a href="javascript:void(0);">
                                                <i class="isax isax-receipt-item5"></i><span>Accounts</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                        @endcan
                                        <ul>
                                            @can('view-invoices')
                                                <li><a href="{{ route('admin.invoices.index') }}" class="{{ request()->routeIs('admin.invoices.index') ? 'active' : '' }}">Invoices</a></li>
                                            @endcan

                                            @can('create-invoices')
                                                <li><a href="{{ route('admin.invoices.create') }}" class="{{ request()->routeIs('admin.invoices.create') ? 'active' : '' }}">Create Invoice</a></li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcanany

                                <!-- Customers -->
                                @canany(['manage-customers', 'view-customers'])
                                    <li class="submenu">
                                        @can('manage-customers')
                                            <a href="javascript:void(0);">
                                                <i class="isax isax-profile-2user5"></i><span>Customers</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                        @endcan
                                        <ul>
                                            @can('view-customers')
                                                <li><a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*', 'add-customer') ? 'active' : '' }}">Customers</a></li>
                                            @endcan

                                        </ul>
                                    </li>
                                @endcanany
                            </ul>
                        </li>
                    @endcanany

                    @canany(['view-order-management', 'manage-orders', 'view-orders'])
                        <li class="menu-title"><span>Order Management</span></li>

                        <li>
                            <ul>
                                <li class="submenu">
                                    @can('manage-orders')
                                        <a href="javascript:void(0);">
                                            <i class="isax isax-shopping-cart"></i>
                                            <span>Orders</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                    @endcan
                                    <ul>
                                        @can('view-orders')
                                            <li><a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">All Orders</a></li>
                                        @endcan

                                        @can('create-orders')
                                            <li><a href="{{ route('admin.orders.create') }}" class="{{ request()->routeIs('admin.orders.create') ? 'active' : '' }}">Create New Order</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    @endcanany

                    @canany(['view-management', 'manage-gate-passes', 'view-gate-passes'])
                        <li class="menu-title"><span>Gate Pass Management</span></li>

                        <li>
                            <ul>
                                <li class="submenu">
                                    @can('manage-gate-passes')
                                        <a href="javascript:void(0);">
                                            <i class="isax isax-scan"></i>
                                            <span>Gate Pass</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                    @endcan
                                    <ul>
                                        @can('view-gate-passes')
                                            <li><a href="{{ route('admin.gate-passes.index') }}" class="{{ request()->routeIs('admin.gate-passes.index') ? 'active' : '' }}">All Passes</a></li>
                                        @endcan

                                        @can('create-gate-passes')
                                            <li><a href="{{ route('admin.gate-passes.create') }}" class="{{ request()->routeIs('admin.gate-passes.create') ? 'active' : '' }}">Create Pass</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    @endcanany

                    @canany(['view-costing', 'manage-labor', 'manage-work-types', 'manage-rate-types',
                        'manage-labor-types', 'manage-labor-assignments', 'view-labor-history', 'view-labor-reports'])

                        <li class="menu-title"><span>Costing</span></li>
                        <li>
                            <ul>
                                <!-- Labor Management -->
                                <li class="submenu">
                                    @can('manage-labor')
                                        <a href="javascript:void(0);">
                                            <i class="isax isax-user-edit"></i>
                                            <span>Labor Management</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                    @endcan
                                    <ul>
                                        @can('manage-work-types')
                                            <li><a href="{{ route('work-types.index') }}" class="{{ request()->routeIs('work-types.*') ? 'active' : '' }}">Manage Work Types</a></li>
                                        @endcan

                                        @can('manage-rate-types')
                                            <li><a href="{{ route('rate-types.index') }}" class="{{ request()->routeIs('rate-types.*') ? 'active' : '' }}">Manage Rate Types</a></li>
                                        @endcan

                                        @can('manage-labor-types')
                                            <li><a href="{{ route('labor-types.index') }}" class="{{ request()->routeIs('labor-types.*') ? 'active' : '' }}">Manage Labor Types</a></li>
                                        @endcan

                                        @can('manage-labor-assignments')
                                            <li><a href="{{ route('labor-cost-assignments.index') }}" class="{{ request()->routeIs('labor-cost-assignments.*') ? 'active' : '' }}">Labor Cost Assignment</a>
                                            </li>
                                        @endcan

                                        @can('view-labor-history')
                                            <li><a href="{{ route('labor-history.index') }}" class="{{ request()->routeIs('labor-history.*') ? 'active' : '' }}">Labor History</a></li>
                                        @endcan

                                        @can('view-labor-reports')
                                            <li><a href="{{ route('labor-cost-reports.index') }}" class="{{ request()->routeIs('labor-cost-reports.*') ? 'active' : '' }}">Labor Cost Reports</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    @endcanany



                    @canany(['view-manage', 'manage-users', 'view-users', 'manage-roles', 'manage-permissions'])
                        <li class="menu-title"><span>Manage</span></li>

                        <li>
                            <ul>
                                <!-- Manage Users (Admin Only) -->
                                <li class="submenu">
                                    @can('manage-users')
                                        <a href="javascript:void(0);">
                                            <i class="isax isax-profile-2user5"></i><span>Manage Users</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                    @endcan
                                    <ul>
                                        @can('view-users')
                                            <li><a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">Admin Users</a></li>
                                        @endcan

                                        @can('manage-roles')
                                            <li><a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">Roles</a></li>
                                        @endcan

                                        @can('manage-permissions')
                                            <li><a href="{{ route('permissions.index') }}" class="{{ request()->routeIs('permissions.*') ? 'active' : '' }}">Permissions</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    @endcanany

                    <li class="menu-title"><span>Administration</span></li>
                    @canany(['edit-general-settings', 'edit-system-settings'])
                        <li>
                            <ul>
                                <li class="submenu">
                                    @canany(['edit-general-settings', 'edit-system-settings'])
                                        <a href="javascript:void(0);">
                                            <i class="isax isax-setting-25"></i><span>Settings</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                    @endcanany
                                    <ul>
                                        <li class="submenu submenu-two">
                                            <a href="javascript:void(0);">General Settings<span
                                                    class="menu-arrow"></span></a>
                                            <ul>
                                                <li><a href="{{ route('account-settings') }}" class="{{ request()->routeIs('account-settings*') ? 'active' : '' }}">Account Settings</a></li>
                                                {{-- <li><a href="{{ route ('plans-billings')}}">Plans & Billing</a></li> --}}
                                                <li><a href="{{ route('notifications-settings') }}" class="{{ request()->routeIs('notifications-settings*') ? 'active' : '' }}">Notifications</a>
                                                </li>
                                                <li><a href="{{ route('general-settings') }}" class="{{ request()->routeIs('general-settings*') ? 'active' : '' }}">Integrations</a></li>
                                            </ul>
                                        </li>
                                        <li class="submenu submenu-two">
                                            <a href="javascript:void(0);">Website Settings<span
                                                    class="menu-arrow"></span></a>
                                            <ul>
                                                <li><a href="{{ route('settings.system-settings') }}" class="{{ request()->routeIs('settings.system-settings*') ? 'active' : '' }}">Company
                                                        Settings</a></li>
                                                <li><a href="{{ route('localization-settings') }}" class="{{ request()->routeIs('localization-settings*') ? 'active' : '' }}">Localization</a></li>
                                                {{-- <li><a href="{{ route ('preference-settings')}}">Preference</a></li> --}}
                                                {{-- <li><a href="{{ route ('seo-setup')}}">SEO Setup</a></li> --}}
                                                <li><a href="{{ route('language-settings') }}" class="{{ request()->routeIs('language-settings*') ? 'active' : '' }}">Language</a></li>
                                                <li><a href="{{ route('maintenance-mode') }}" class="{{ request()->routeIs('maintenance-mode*') ? 'active' : '' }}">Maintenance Mode</a></li>
                                                {{-- <li><a href="{{ route('authentication-settings') }}">Authentication</a></li> --}}
                                                {{-- <li><a href="{{ route('ai-configuration') }}">AI Configuration</a></li> --}}
                                                {{-- <li><a href="{{ route('appearance-settings') }}">Appearance</a></li> --}}
                                                {{-- <li><a href="{{ route('plugin-manager')}}">Plugin Manager</a></li> --}}
                                            </ul>
                                        </li>
                                        <li class="submenu submenu-two">
                                            <a href="javascript:void(0);">App Settings<span class="menu-arrow"></span></a>
                                            <ul>
                                                <li><a href="{{ route('invoice-settings') }}" class="{{ request()->routeIs('invoice-settings*') ? 'active' : '' }}">Invoice Settings</a></li>
                                                <li><a href="{{ route('invoice-templates-settings') }}" class="{{ request()->routeIs('invoice-templates-settings*') ? 'active' : '' }}">Invoice
                                                        Templates</a></li>
                                                {{-- <li><a href="{{ route ('esignatures')}}">eSignatures</a></li>
													<li><a href="{{ route ('barcode-settings')}}">Barcode</a></li>
													<li><a href="{{ route ('thermal-printer')}}">Thermal Printer</a></li>
													<li><a href="{{ route ('custom-fields')}}">Custom Fields</a></li>
													<li><a href="{{ route ('sass-settings')}}">SaaS Settings</a></li> --}}
                                            </ul>
                                        </li>
                                        <li class="submenu submenu-two">
                                            <a href="javascript:void(0);">System Settings<span
                                                    class="menu-arrow"></span></a>
                                            <ul>
                                                <li><a href="{{ route('email-settings') }}" class="{{ request()->routeIs('email-settings*') ? 'active' : '' }}">Email Settings</a></li>
                                                <li><a href="{{ route('email-templates') }}" class="{{ request()->routeIs('email-templates*') ? 'active' : '' }}">Email Templates</a></li>
                                                {{-- <li><a href="{{ route ('sms-gateways')}}">SMS Gateways</a></li> --}}
                                                <li><a href="{{ route('gdpr-cookies') }}" class="{{ request()->routeIs('gdpr-cookies*') ? 'active' : '' }}">GDPR Cookies</a></li>
                                            </ul>
                                        </li>
                                        <li class="submenu submenu-two">
                                            <a href="javascript:void(0);">Finance Settings<span
                                                    class="menu-arrow"></span></a>
                                            <ul>
                                                <li>
                                                    <a href="{{ route('payment-methods') }}" class="{{ request()->routeIs('payment-methods*') ? 'active' : '' }}">Payment Methods</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('bank-accounts') }}" class="{{ request()->routeIs('bank-accounts*') ? 'active' : '' }}">Bank Accounts</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('tax-rates') }}" class="{{ request()->routeIs('tax-rates*') ? 'active' : '' }}">Tax Rates</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('currencies') }}" class="{{ request()->routeIs('currencies*') ? 'active' : '' }}">Currencies</a>
                                                </li>
                                            </ul>
                                        </li>
                                        {{-- <li class="submenu submenu-two">
												<a href="javascript:void(0);">Other Settings<span class="menu-arrow"></span></a>
												<ul>
													<li>
														<a href="{{ route ('custom-css')}}">Custom CSS</a>
													</li>
													<li>
														<a href="{{ route ('custom-js')}}">Custom JS</a>
													</li>
													<li>
														<a href="{{ route ('clear-cache')}}">Clear Cache</a>
													</li>
													<li>
														<a href="{{ route ('sitemap')}}">Sitemap</a>
													</li>
													<li>
														<a href="{{ route ('storage-settings')}}">Storage Settings</a>
													</li>
													<li>
														<a href="{{ route ('cronjob')}}">Cronjob</a>
													</li>
													<li>
														<a href="{{ route ('system-backup')}}">System Backup</a>
													</li>
													<li>
														<a href="{{ route ('database-backup')}}">Database Backup</a>
													</li>
												</ul>
											</li> --}}
                                    </ul>

                                </li>
                            </ul>
                        </li>

                    @endcanany

                </ul>

            </div>
        </div>
    </div>
</div>
</div>
<!-- Sidenav Menu End -->

@push('scripts')
<script>
    $(function () {
        $('.sidebar-menu li.submenu a.active').each(function () {
            $(this).parents('li.submenu').each(function () {
                var $head = $(this).children('a:first');
                var $sub = $(this).children('ul:first');
                if (!$head.hasClass('subdrop')) $head.addClass('subdrop');
                if ($sub.length) $sub.show();
            });
        });
    });
</script>
@endpush
