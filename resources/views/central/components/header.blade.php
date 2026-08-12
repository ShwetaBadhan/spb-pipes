<!-- Central Admin Header -->
<div class="header">
    <div class="main-header">

        <!-- Logo -->
        <div class="header-left">
            <a href="{{ route('central.dashboard') }}" class="logo logo-normal">
                <img src="{{ asset('assets/img/logo-spb.png') }}" alt="Logo">
            </a>
            <a href="{{ route('central.dashboard') }}" class="logo-small">
                <img src="{{ asset('assets/img/logo-small.png') }}" alt="Logo">
            </a>
        </div>

        <!-- Sidebar Menu Toggle Button -->
        <a id="mobile_btn" class="mobile_btn" href="#sidebar">
            <span class="bar-icon">
                <span></span><span></span><span></span>
            </span>
        </a>

        <div class="header-user">
            <div class="nav user-menu nav-list">
                <div class="me-auto d-flex align-items-center" id="header-search">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-divide mb-0">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a href="{{ route('central.dashboard') }}"><i class="isax isax-home-2 me-1"></i>Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ \Illuminate\Support\Str::title(str_replace('-', ' ', request()->segment(2) ?: 'Dashboard')) }}
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="d-flex align-items-center">
                    <!-- Light/Dark Mode Button -->
                    <div class="me-2 theme-item">
                        <a href="javascript:void(0);" id="dark-mode-toggle" class="theme-toggle btn btn-menubar">
                            <i class="isax isax-moon"></i>
                        </a>
                        <a href="javascript:void(0);" id="light-mode-toggle" class="theme-toggle btn btn-menubar">
                            <i class="isax isax-sun-1"></i>
                        </a>
                    </div>

                    <!-- User Dropdown -->
                    <div class="dropdown profile-dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <span class="avatar online">
                                <img src="{{ url('assets/img/profiles/avatar-01.jpg') }}" alt="Img"
                                    class="img-fluid rounded-circle">
                            </span>
                        </a>
                        <div class="dropdown-menu p-2">
                            @if (auth('central')->check())
                                <div class="bg-light p-2 mb-2">
                                    <span class="avatar avatar-lg me-2">
                                        <img src="{{ url('assets/img/profiles/avatar-01.jpg') }}" alt="img"
                                            class="rounded-circle">
                                    </span>
                                    <div>
                                        <h6 class="fs-14 fw-medium mb-1">{{ auth('central')->user()->name }}</h6>
                                        <p class="fs-13">{{ auth('central')->user()->is_superadmin ? 'Super Admin' : 'Admin' }}</p>
                                    </div>
                                </div>

                                <a class="dropdown-item d-flex align-items-center" href="{{ route('central.settings.index') }}">
                                    <i class="isax isax-setting-2 me-2"></i>Central Settings
                                </a>

                                <hr class="dropdown-divider my-2">

                                <a class="dropdown-item logout d-flex align-items-center" href="#"
                                    onclick="event.preventDefault(); document.getElementById('central-logout-form').submit();">
                                    <i class="isax isax-logout me-2"></i> Sign Out
                                </a>
                                <form id="central-logout-form" action="{{ route('central.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @endif
                        </div>
                    </div>
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
                <a class="dropdown-item logout d-flex align-items-center" href="#"
                    onclick="event.preventDefault(); document.getElementById('central-logout-form-mobile').submit();">
                    <i class="isax isax-logout me-2"></i>Signout
                </a>
                <form id="central-logout-form-mobile" action="{{ route('central.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
        <!-- /Mobile Menu -->

    </div>
</div>
<!-- Header End -->
