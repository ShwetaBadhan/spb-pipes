<div class="main-wrapper">		
    <!-- Topbar Start -->
    <div class="header">
        <div class="main-header">

            <!-- Logo -->
            <div class="header-left">
                <a href="{{ route('dashboard') }}" class="logo logo-normal">
                    <img src="{{ tenant_storage_url($system_white_logo) ?? asset('assets/img/logo-spb.png') }}" alt="Logo">
                </a>
                <a href="{{ route('dashboard') }}" class="logo-small">
                    <img src="{{ tenant_storage_url($system_single_logo) ?? asset('assets/img/logo-small.png') }}" alt="Logo">
                </a>
            </div>

            <!-- Sidebar Menu Toggle Button -->
            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span><span></span><span></span>
                </span>
            </a>

            <div class="header-user">
                <div class="nav user-menu nav-list border-bottom">
                    <div class="me-auto d-flex align-items-center" id="header-search">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-divide mb-0">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a href="{{ route('dashboard') }}"><i class="isax isax-home-2 me-1"></i>Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="d-flex align-items-center">
                        <!-- Notification -->
                        <div class="notification_item me-2">
                            <a href="#" class="btn btn-menubar position-relative" id="notification_popup"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                <i class="isax isax-notification-bing5"></i>
                                <span class="position-absolute badge bg-success border border-white"></span>
                            </a>
                            <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg" style="min-height: 300px;">
                                <div class="p-2 border-bottom">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold">Notifications</h6>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle drop-arrow-none link-dark"
                                                    data-bs-toggle="dropdown" data-bs-offset="0,15" aria-expanded="false">
                                                    <i class="isax isax-setting-2 fs-16 text-body align-middle"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="javascript:void(0);" class="dropdown-item">
                                                        <i class="ti ti-bell-check me-1"></i>Mark as Read
                                                    </a>
                                                    <a href="javascript:void(0);" class="dropdown-item">
                                                        <i class="ti ti-trash me-1"></i>Delete All
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notification Dropdown -->
                                <div class="notification-body position-relative z-2 rounded-0" data-simplebar>
                                   
                                </div>

                                <!-- View All -->
                                <div class="p-2 border-top text-center">
                                    <a href="javascript:void(0);"
                                        class="text-center fw-medium fs-14 text-primary">
                                        View All Notifications
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Light/Dark Mode Button -->
                        <div class="me-2 theme-item">
                            <a href="javascript:void(0);" id="dark-mode-toggle" class="theme-toggle btn btn-menubar">
                                <i class="isax isax-moon"></i>
                            </a>
                            <a href="javascript:void(0);" id="light-mode-toggle" class="theme-toggle btn btn-menubar">
                                <i class="isax isax-sun-1"></i>
                            </a>
                        </div>

                        <!-- ✅ FIXED: User Dropdown with Null Checks -->
                        <div class="dropdown profile-dropdown border rounded-pill me-2 p-1">
                            <a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                <span class="avatar online">
                                    <img src="{{ url('assets/img/profiles/avatar-01.jpg') }}" alt="Img" class="img-fluid rounded-circle">
                                </span>
                                <span class="mx-2 d-none d-lg-block">
                                    <span class="text-dark fw-semibold d-block fs-14">
                                        {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                                    </span> 
                                </span>
                            </a>
                            <div class="dropdown-menu p-2">
                                @if (Auth::check())                                    
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('account-settings') }}">
                                        <i class="isax isax-profile-circle me-2"></i> Settings
                                    </a> 

                                    <hr class="dropdown-divider my-2">

                                    <a class="dropdown-item logout d-flex align-items-center" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="isax isax-logout me-2"></i> Sign Out
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>  
                                                                  
                                @endif
                                
                            </div>
                        </div>
                        <!-- ✅ END Fixed User Dropdown -->

                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="dropdown mobile-user-menu profile-dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center" 
                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <span class="avatar avatar-md online">
                        <img src="{{ url('assets/img/profiles/avatar-01.jpg') }}" alt="Img"
                            class="img-fluid rounded-circle">
                    </span>
                </a>
                <div class="dropdown-menu p-2 mt-0">
                    @if(Auth::check())
                        <a class="dropdown-item logout d-flex align-items-center" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                            <i class="isax isax-logout me-2"></i>Signout
                        </a>
                        <a class="dropdown-item logout d-flex align-items-center" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                            <i class="isax isax-logout me-2"></i>Signout
                        </a>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>                    
                    @endif
                </div>
            </div>
            <!-- /Mobile Menu -->

        </div>
    </div>
</div>
<!-- Topbar End -->