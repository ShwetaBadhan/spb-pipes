{{-- resources/views/admin/components/top-header.blade.php --}}
@php
use App\Models\Product;
use App\Models\RawMaterial;
use App\Services\InventoryService;

$lowStockNotifications = collect();

if (auth()->check()) {

    // ========================
    // PRODUCTS LOW STOCK
    // ========================
    $products = Product::with('variants')->get();

    foreach ($products as $product) {
        $available = InventoryService::productAvailableQty($product->id);
        $minAlert  = $product->variants->min('alert_quantity') ?? 0;

        if ($minAlert > 0 && $available <= $minAlert) {
            $lowStockNotifications->push([
                'type'      => 'product',
                'name'      => $product->name,
                'status'    => $available <= 0 ? 'Out of Stock' : 'Low Stock',
                'available' => $available,
                'image'     => $product->image_path ?? null,
                'url'       => route('inventory.index'),
            ]);
        }
    }

    // ========================
    // RAW MATERIAL LOW STOCK
    // ========================
    $raws = RawMaterial::all();

    foreach ($raws as $raw) {
        $available = InventoryService::rawAvailableQty($raw->id);
        $minStock  = $raw->min_stock ?? 0;

        if ($minStock > 0 && $available <= $minStock) {
            $lowStockNotifications->push([
                'type'      => 'raw',
                'name'      => $raw->material_name,
                'status'    => $available <= 0 ? 'Out of Stock' : 'Low Stock',
                'available' => $available,
                'image'     => null,
                'url'       => route('inventory.index'),
            ]);
        }
    }

    // Max 5 notifications
    $lowStockNotifications = $lowStockNotifications->take(5);
}
@endphp

<!-- Topbar Start -->
		<div class="header">						
			<div class="main-header">
				
				<!-- Logo -->
				<div class="header-left">
					<a href="{{ route('dashboard') }}" class="logo">
						<img src="{{url ('assets/img/logo.svg')}}" alt="Logo">
					</a>
					<a href="{{ route('dashboard') }}" class="dark-logo">
						<img src="{{url ('assets/img/logo-white.svg')}}" alt="Logo">
					</a>
				</div>

				<!-- Sidebar Menu Toggle Button -->
				<a id="mobile_btn" class="mobile_btn" href="#sidebar">
					<span class="bar-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
				</a>

				<div class="header-user">
					<div class="nav user-menu nav-list">	
						<div class="me-auto d-flex align-items-center" id="header-search">	

                           
							<!-- Breadcrumb -->
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb breadcrumb-divide mb-0">
									<li class="breadcrumb-item d-flex align-items-center"><a href="index.html"><i class="isax isax-home-2 me-1"></i>Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
								</ol>
							</nav>	

						</div>
	
						<div class="d-flex align-items-center">	

							<!-- Search -->
							<div class="input-icon-end position-relative me-2">
								<input type="text" class="form-control" placeholder="Search">
								<span class="input-icon-addon">
									<i class="isax isax-search-normal"></i>
								</span>
							</div>
							<!-- /Search -->

						{{-- resources/views/admin/components/top-header.blade.php --}}


							<!-- Notification -->
							<div class="notification_item me-2">
								<a href="#" class="btn btn-menubar position-relative" id="notification_popup" data-bs-toggle="dropdown" data-bs-auto-close="outside">
									<i class="isax isax-notification-bing5"></i>
									<span class="position-absolute badge bg-success border border-white"></span>
								</a>
								<div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg" style="min-height: 300px;">
							
									<div class="p-2 border-bottom">
										<div class="row align-items-center">
											<div class="col">
												<h6 class="m-0 fs-16 fw-semibold"> Notifications</h6>
											</div>
											<div class="col-auto">
												<div class="dropdown">
													<a href="#" class="dropdown-toggle drop-arrow-none link-dark" data-bs-toggle="dropdown" data-bs-offset="0,15" aria-expanded="false">
														<i class="isax isax-setting-2 fs-16 text-body align-middle"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-end">
														<!-- item-->
														<a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-bell-check me-1"></i>Mark as Read</a>
														<!-- item-->
														<a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-trash me-1"></i>Delete All</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<!-- Notification Dropdown -->
									<div class="notification-body position-relative z-2 rounded-0" data-simplebar>

@forelse($lowStockNotifications as $index => $item)
<div class="dropdown-item notification-item py-2 text-wrap border-bottom"
     id="notification-low-{{ $index }}">

    <div class="d-flex">

        <!-- IMAGE / ICON -->
        <div class="flex-shrink-0 me-2">
            <div class="avatar-sm">
                <span class="avatar-title bg-soft-warning text-warning fs-18 rounded-circle">

                    @if (!empty($item['image']))
                        <img src="{{ asset('storage/' . $item['image']) }}"
                             alt="{{ $item['name'] }}"
                             class="rounded-circle"
                             width="36" height="36">
                    @else
                        <i class="isax isax-warning-2"></i>
                    @endif

                </span>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="flex-grow-1">
            <p class="mb-0 fw-semibold text-dark">
                {{ $item['name'] }}
            </p>

            <p class="mb-1 fs-14">
                {{ $item['status'] }}
                <span class="text-muted">
                    (Available: {{ $item['available'] }})
                </span>
            </p>

            <div class="d-flex justify-content-between align-items-center">
                <span class="fs-12 text-muted">
                    <i class="isax isax-clock me-1"></i> Just now
                </span>

                <div class="notification-action d-flex align-items-center gap-2">
                    <a href="{{ $item['url'] }}"
                       class="btn rounded-circle text-info p-0"
                       data-bs-toggle="tooltip"
                       title="View Inventory">
                        <i class="isax isax-eye fs-12"></i>
                    </a>

                    <button class="btn rounded-circle text-danger p-0"
                            data-bs-dismiss="alert">
                        <i class="isax isax-close-circle fs-12"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
@empty
<div class="dropdown-item py-3 text-center text-muted">
    No low stock alerts 🎉
</div>
@endforelse

</div>


    <!-- View All -->
    <div class="p-2 border-top text-center">
        <a href="{{ route('inventory.index') }}" class="text-center fw-medium fs-14 text-primary">
            View All Inventory
        </a>
    </div>
			 </div>				</div>

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
								<a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"  data-bs-auto-close="outside">
									<span class="avatar online">
									    
										<img src="{{url ('assets/img/profiles/avatar-01.jpg')}}" alt="Img" class="img-fluid rounded-circle">
									</span>
								</a>
								<div class="dropdown-menu p-2">
									<div class="bg-light  p-2 mb-2">
										{{-- <span class="avatar avatar-lg me-2">
											<img src="assets/img/profiles/avatar-01.jpg" alt="img" class="rounded-circle" >
										</span> --}}
										<div>
    {{-- <h6 class="fs-14 fw-medium mb-1">{{ ucfirst(auth()->user()->name) }}</h6>
   <p class="fs-13">
    {{ ucfirst(auth()->user()->getRoleNames()->first()) }}
</p> --}}

</div>

									</div>

									<!-- Item-->
									<a class="dropdown-item d-flex align-items-center" href="#">
										<i class="isax isax-profile-circle me-2"></i>Profile Settings
									</a>

									<!-- Item-->
									{{-- <a class="dropdown-item d-flex align-items-center" href="inventory-report.html">
										<i class="isax isax-document-text me-2"></i>Reports
									</a>

									<!-- Item-->
									<div class="form-check form-switch form-check-reverse d-flex align-items-center justify-content-between dropdown-item mb-0">
										<label class="form-check-label" for="notify"><i class="isax isax-notification me-2"></i>Notifications</label>
										<input class="form-check-input" type="checkbox" role="switch" id="notify">
									</div> --}}

									<hr class="dropdown-divider my-2">

									<!-- Item-->
									{{-- <a class="dropdown-item logout d-flex align-items-center" href="login.html">
										<i class="isax isax-logout me-2"></i>Sign Out
									</a> --}}
									<a class="dropdown-item logout d-flex align-items-center"
   href="#"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="isax isax-logout me-2"></i> Sign Out
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
								</div>
							</div>

						</div>
					</div>
				</div>

				<!-- Mobile Menu -->
				<div class="dropdown mobile-user-menu profile-dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"  data-bs-auto-close="outside">
						<span class="avatar avatar-md online">
							<img src="{{ url('assets/img/profiles/avatar-01.jpg')}}" alt="Img" class="img-fluid rounded-circle">
						</span>
					</a>
					<div class="dropdown-menu p-2 mt-0">
						<a class="dropdown-item d-flex align-items-center" href="profile.html">
							<i class="isax isax-profile-circle me-2"></i>Profile Settings
						</a>
						<a class="dropdown-item d-flex align-items-center" href="reports.html">
							<i class="isax isax-document-text me-2"></i>Reports
						</a>
						<a class="dropdown-item d-flex align-items-center" href="account-settings.html">
							<i class="isax isax-setting me-2"></i>Settings
						</a>
						<a class="dropdown-item logout d-flex align-items-center" href="login.html">
							<i class="isax isax-logout me-2"></i>Signout
						</a>
					</div>
				</div>
				<!-- /Mobile Menu -->

			</div>
		</div>
		<!-- Topbar End -->