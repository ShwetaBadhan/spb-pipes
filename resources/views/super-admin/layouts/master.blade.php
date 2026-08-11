<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Super Admin') — SBP Pipes</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/iconsax.css') }}">
    <style>
        body { background: #f4f6f9; }
        .sa-sidebar {
            background: #0d2137; min-height: 100vh; width: 240px; position: fixed;
            top: 0; left: 0; overflow-y: auto; z-index: 100;
        }
        .sa-sidebar .brand { color: #fff; font-weight: 700; padding: 18px 20px; font-size: 18px; border-bottom: 1px solid rgba(255,255,255,.08); }
        .sa-sidebar .brand span { color: #4da8da; }
        .sa-sidebar a.nav-link { color: #a9bfd4; padding: 11px 20px; font-size: 14px; display: flex; align-items: center; gap: 10px; }
        .sa-sidebar a.nav-link:hover { color: #fff; background: rgba(255,255,255,.06); }
        .sa-sidebar a.nav-link.active { color: #fff; background: #143a5c; border-left: 3px solid #4da8da; }
        .sa-main { margin-left: 240px; padding: 24px; }
        .sa-topbar { background: #fff; border-bottom: 1px solid #e3e8ef; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .stat-card { background: #fff; border-radius: 10px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(16,24,40,.08); }
        .stat-card .label { color: #6b7280; font-size: 13px; }
        .stat-card .value { font-size: 26px; font-weight: 700; color: #0d2137; }
        .card { border: none; box-shadow: 0 1px 3px rgba(16,24,40,.08); border-radius: 10px; }
        .table thead th { background: #f8fafc; font-size: 12px; text-transform: uppercase; letter-spacing: .03em; color: #6b7280; }
    </style>
</head>
<body>

@if(auth('super_admin')->check())
<div class="sa-sidebar">
    <div class="brand">SBP <span>Control</span></div>
    <nav class="nav flex-column mt-2">
        <a class="nav-link @if(request()->routeIs('super-admin.dashboard')) active @endif"
           href="{{ route('super-admin.dashboard') }}"><i class="iconsax" data-icon="home-2"></i> Dashboard</a>
        <a class="nav-link @if(request()->routeIs('super-admin.tenants.*')) active @endif"
           href="{{ route('super-admin.tenants.index') }}"><i class="iconsax" data-icon="buildings"></i> Tenants</a>
        <a class="nav-link @if(request()->routeIs('super-admin.plans.*')) active @endif"
           href="{{ route('super-admin.plans.index') }}"><i class="iconsax" data-icon="dollar-square"></i> Plans</a>
        <a class="nav-link @if(request()->routeIs('super-admin.addons.*')) active @endif"
           href="{{ route('super-admin.addons.index') }}"><i class="iconsax" data-icon="add-square"></i> Add-ons</a>
        <a class="nav-link @if(request()->routeIs('super-admin.subscriptions.*')) active @endif"
           href="{{ route('super-admin.subscriptions.index') }}"><i class="iconsax" data-icon="tick-circle"></i> Subscriptions</a>
        <a class="nav-link @if(request()->routeIs('super-admin.billing.*')) active @endif"
           href="{{ route('super-admin.billing.index') }}"><i class="iconsax" data-icon="wallet-1"></i> Billing</a>
        <a class="nav-link @if(request()->routeIs('super-admin.reports.*')) active @endif"
           href="{{ route('super-admin.reports.index') }}"><i class="iconsax" data-icon="chart-2"></i> Reports</a>
        <a class="nav-link @if(request()->routeIs('super-admin.audit-logs.*')) active @endif"
           href="{{ route('super-admin.audit-logs.index') }}"><i class="iconsax" data-icon="document-text"></i> Audit Logs</a>
        <a class="nav-link @if(request()->routeIs('super-admin.settings.*')) active @endif"
           href="{{ route('super-admin.settings.index') }}"><i class="iconsax" data-icon="setting-2"></i> Settings</a>
    </nav>
</div>
@endif

<div class="sa-main">
    @if(auth('super_admin')->check())
    <div class="sa-topbar">
        <div>
            <h5 class="mb-0">@yield('title', 'Super Admin')</h5>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small">{{ auth('super_admin')->user()->name }}</span>
            <form method="POST" action="{{ route('super-admin.logout') }}">
                @csrf
                <button class="btn btn-sm btn-outline-secondary">Logout</button>
            </form>
        </div>
    </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</div>

<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
