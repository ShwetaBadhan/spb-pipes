<!-- Central Admin Sidebar -->
<div class="two-col-sidebar" id="two-col-sidebar">

    <div class="sidebar" id="sidebar-two">

        <!-- Start Logo -->
        <div class="sidebar-logo">
            <a href="{{ route('central.dashboard') }}" class="logo logo-normal">
                <img src="{{ asset('assets/img/logo-spb.png') }}" alt="Logo">
            </a>
            <a href="{{ route('central.dashboard') }}" class="logo-small">
                <img src="{{ asset('assets/img/logo-small.png') }}" alt="Logo">
            </a>

            <!-- Sidebar Hover Menu Toggle Button -->
            <a id="toggle_btn" href="javascript:void(0);">
                <i class="isax isax-menu-1"></i>
            </a>
        </div>
        <!-- End Logo -->

        <!--- Sidenav Menu -->
        <div class="sidebar-inner" data-simplebar>
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>

                    <li class="menu-title"><span>Main</span></li>
                    <li>
                        <ul>
                            <li>
                                <a href="{{ route('central.dashboard') }}"
                                    class="{{ request()->routeIs('central.dashboard') ? 'active' : '' }}">
                                    <i class="isax isax-element-45"></i><span>Dashboard</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-title"><span>Management</span></li>
                    <li>
                        <ul>
                            <li>
                                <a href="{{ route('central.tenants.index') }}"
                                    class="{{ request()->routeIs('central.tenants.*') ? 'active' : '' }}">
                                    <i class="isax isax-building"></i><span>Tenants</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('central.plans.index') }}"
                                    class="{{ request()->routeIs('central.plans.*') ? 'active' : '' }}">
                                    <i class="isax isax-crown"></i><span>Plans</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('central.admins.index') }}"
                                    class="{{ request()->routeIs('central.admins.*') ? 'active' : '' }}">
                                    <i class="isax isax-profile-2user5"></i><span>Admin Users</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-title"><span>System</span></li>
                    <li>
                        <ul>
                            <li>
                                <a href="{{ route('central.settings.index') }}"
                                    class="{{ request()->routeIs('central.settings.*') ? 'active' : '' }}">
                                    <i class="isax isax-setting-25"></i><span>Settings</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
        <!-- /Sidenav Menu -->

    </div>
</div>
<!-- Sidebar End -->
