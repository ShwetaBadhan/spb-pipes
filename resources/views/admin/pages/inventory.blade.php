@extends('admin.layout.master')
@section('title', 'Admin Inventory')
@section('content')
<div class="page-wrapper">
    <div class="content content-two">
        <!-- Breadcrumb -->
        <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
            <div>
                <h6>Inventory</h6>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                {{-- <div class="dropdown">
                    <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
                        data-bs-toggle="dropdown">
                        <i class="isax isax-export-1 me-1"></i>Export
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Download as PDF</a></li>
                        <li><a class="dropdown-item" href="#">Download as Excel</a></li>
                    </ul>
                </div> --}}
                <div>
                    <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#add_modal">
                        <i class="isax isax-add-circle5 me-1"></i>New Inventory
                    </a>
                </div>
            </div>
        </div>

        <!-- Table Search -->
        <div class="mb-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="table-search d-flex align-items-center mb-0">
                        <div class="search-input">
                            <a href="javascript:void(0);" class="btn-searchset">
                                <i class="isax isax-search-normal fs-12"></i>
                            </a>
                        </div>
                    </div>
                    <a class="btn btn-outline-white fw-normal d-inline-flex align-items-center"
                        href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#customcanvas">
                        <i class="isax isax-filter me-1"></i>Filter
                    </a>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="dropdown">
                        <a href="javascript:void(0);"
                            class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <i class="isax isax-sort me-1"></i>Sort By : <span class="fw-normal ms-1">Latest</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a href="javascript:void(0);" class="dropdown-item">Latest</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item">Oldest</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a href="javascript:void(0);"
                            class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="isax isax-grid-3 me-1"></i>Column
                        </a>
                        <ul class="dropdown-menu dropdown-menu">
                            <li>
                                <label class="dropdown-item d-flex align-items-center form-switch">
                                    <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                    <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                    <span>Product/Service</span>
                                </label>
                            </li>
                            <li>
                                <label class="dropdown-item d-flex align-items-center form-switch">
                                    <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                    <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                    <span>Code</span>
                                </label>
                            </li>
                            <li>
                                <label class="dropdown-item d-flex align-items-center form-switch">
                                    <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                    <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                    <span>Unit</span>
                                </label>
                            </li>
                            <li>
                                <label class="dropdown-item d-flex align-items-center form-switch">
                                    <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                    <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                    <span>Quantity</span>
                                </label>
                            </li>
                            <li>
                                <label class="dropdown-item d-flex align-items-center form-switch">
                                    <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                    <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                    <span>Selling Price</span>
                                </label>
                            </li>
                            <li>
                                <label class="dropdown-item d-flex align-items-center form-switch">
                                    <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                    <input class="form-check-input m-0 me-2" type="checkbox">
                                    <span>Purchase Price</span>
                                </label>
                            </li>
                            <li>
                                <label class="dropdown-item d-flex align-items-center form-switch">
                                    <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                    <input class="form-check-input m-0 me-2" type="checkbox">
                                    <span>Status</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table List -->
        <div class="table-responsive">
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            @endif
            @if (session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '{{ session('error') }}',
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            @endif

            <table class="table table-nowrap datatable">
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort">
                            <div class="form-check form-check-md">
                                <input class="form-check-input" type="checkbox" id="select-all">
                            </div>
                        </th>
                        <th class="no-sort">Product/Raw Material</th>
                        <th class="no-sort">Code</th>
                        <th class="no-sort">Unit</th>
                        <th>Original Quantity</th>
                        <th>Available Quantity</th>
                        <th>Source</th>
                        <th class="no-sort">Status</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Products --}}
                    @foreach ($products as $product)
                        @php
                            $available = \App\Services\InventoryService::productAvailableQty($product->id);
                            $latestLog = $product->inventoryLogs->sortByDesc('id')->first();
                        @endphp
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : asset('assets/img/products/default.jfif') }}"
                                        alt="" class="me-2" width="30">
                                    {{ $product->name }}
                                </div>
                            </td>
                            <td>{{ $product->code ?? '—' }}</td>
                            <td>{{ optional($product->unit)->name ?? '—' }}</td>
                            <td>{{ $product->variants->sum('quantity') }}</td>
                            <td>{{ $available }}</td>
                            {{-- Source Column --}}
                            <td>
                                @if($latestLog)
                                    @if(str_contains($latestLog->notes ?? '', 'Order #'))
                                        <span class="badge bg-primary">
                                            <i class="fas fa-shopping-cart me-1"></i>Order
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-hand-holding me-1"></i>Manual
                                        </span>
                                    @endif
                                @else
                                    <span class="badge bg-light">-</span>
                                @endif
                            </td>
                            {{-- Status Column --}}
                            @php
                                $available = \App\Services\InventoryService::productAvailableQty($product->id);
                                $minAlert = $product->variants->min('alert_quantity') ?? 0;
                                if ($available <= 0) {
                                    $statusClass = 'danger';
                                    $statusText = 'Out of Stock';
                                } elseif ($minAlert > 0 && $available <= $minAlert) {
                                    $statusClass = 'warning';
                                    $statusText = 'Low Stock';
                                } else {
                                    $statusClass = 'success';
                                    $statusText = 'In Stock';
                                }
                            @endphp
                            <td>
                                <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                            </td>
                            <td class="action-item">
                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <i class="isax isax-more"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#"
                                            class="dropdown-item d-flex align-items-center view-history-btn"
                                            data-item-id="{{ $product->id }}" data-item-type="product"
                                            data-name="{{ $product->name }}" data-code="{{ $product->code }}"
                                            data-unit="{{ optional($product->unit)->name ?? 'N/A' }}"
                                            data-bs-toggle="modal" data-bs-target="#view_history">
                                            <i class="isax isax-eye me-2"></i> View History
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach

                    {{-- Raw Materials --}}
                    @foreach ($allRawMaterials as $raw)
                        @php
                            $latestLog = $raw->inventoryLogs->sortByDesc('id')->first();
                            $available = \App\Services\InventoryService::rawAvailableQty($raw->id);
                        @endphp
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td><span class="badge bg-info">Raw</span> {{ $raw->material_name }}</td>
                            <td>—</td>
                            <td>{{ optional($raw->unit)->name ?? '—' }}</td>
                            <td>—</td>
                            <td>{{ $available }}</td>
                            {{-- Source Column --}}
                            <td>
                                @if($latestLog)
                                    @if(str_contains($latestLog->notes ?? '', 'Order #'))
                                        <span class="badge bg-primary">
                                            <i class="fas fa-shopping-cart me-1"></i>Order
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-hand-holding me-1"></i>Manual
                                        </span>
                                    @endif
                                @else
                                    <span class="badge bg-light">-</span>
                                @endif
                            </td>
                            {{-- Status Column --}}
                            @php
                                $available = \App\Services\InventoryService::rawAvailableQty($raw->id);
                                $minStock = $raw->min_stock ?? 0;
                                if ($available <= 0) {
                                    $statusClass = 'danger';
                                    $statusText = 'Out of Stock';
                                } elseif ($available <= $minStock) {
                                    $statusClass = 'warning';
                                    $statusText = 'Low Stock';
                                } else {
                                    $statusClass = 'success';
                                    $statusText = 'In Stock';
                                }
                            @endphp
                            <td>
                                <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                            </td>
                            <td class="action-item">
                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <i class="isax isax-more"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#"
                                            class="dropdown-item d-flex align-items-center view-history-btn"
                                            data-bs-toggle="modal" data-bs-target="#view_history"
                                            data-item-type="raw_material" data-item-id="{{ $raw->id }}"
                                            data-name="{{ $raw->material_name }}" data-code="—"
                                            data-unit="{{ optional($raw->unit)->name }}">
                                            <i class="isax isax-eye me-2"></i> View History
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div id="add_modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Inventory</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inventory.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Item Type <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" name="item_type" value="product"
                                    id="Radio-sm-1" checked>
                                <label class="form-check-label" for="Radio-sm-1">Product</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="item_type" value="raw_material"
                                    id="Radio-sm-2">
                                <label class="form-check-label" for="Radio-sm-2">Raw Material</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Item <span class="text-danger">*</span></label>
                        <select class="form-select" name="item_id" id="item-select" required>
                            <option value="">Select</option>
                            @foreach ($allProducts as $product)
                                <option value="{{ $product->id }}" data-code="{{ $product->code }}"
                                    data-unit="{{ optional($product->unit)->name ?? 'N/A' }}" data-type="product">
                                    {{ $product->name }}
                                </option>
                            @endforeach
                            @foreach ($allRawMaterials as $raw)
                                <option value="{{ $raw->id }}"
                                    data-unit="{{ optional($raw->unit)->name ?? 'N/A' }}" data-type="raw_material">
                                    {{ $raw->material_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" class="form-control" id="code-field" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Units</label>
                                <input type="text" class="form-control" id="unit-field" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="quantity" required min="0">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select select" name="status" required>
                                    <option value="">Select</option>
                                    <option value="stock_in">Stock In</option>
                                    <option value="stock_out">Stock Out</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                    <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add New</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View History Modal -->
<div id="view_history" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Inventory History</h4>
                <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal"
                    aria-label="Close"><i class="fa-solid fa-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="bg-light d-flex align-items-center justify-content-between flex-wrap row-gap-3 p-3 rounded mb-3">
                    <div>
                        <h6 class="fs-14 fw-semibold mb-1" id="history-product-name">—</h6>
                        <span class="text-primary" id="history-product-code">—</span>
                    </div>
                </div>
                <!-- History Table -->
                <div class="table-responsive border border-bottom-0">
                    <table class="table" id="inventory-history-table">
                        <thead class="thead-light">
        <tr>
            <th>Date</th>
            <th>Unit</th>
            <th>Adjustments</th>
            <th>Stock</th>
            <th>Reason</th>
            <th>Notes</th>
        </tr>
    </thead>
                        <tbody id="inventory-history-body">
                            <tr>
                                <td colspan="6" class="text-center">Loading history...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const itemSelect = document.getElementById('item-select');
    const codeField = document.getElementById('code-field');
    const unitField = document.getElementById('unit-field');
    const radioButtons = document.querySelectorAll('input[name="item_type"]');
    
    // Keep a copy of all options
    const allOptions = Array.from(itemSelect.options);
    
    // Function to filter items based on selected type
    function filterItems(type) {
        itemSelect.innerHTML = '<option value="">Select</option>'; // reset
        allOptions.forEach(option => {
            if (option.dataset.type === type) {
                itemSelect.appendChild(option);
            }
        });
        codeField.value = '';
        unitField.value = '';
    }
    
    // Listen for radio changes
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            filterItems(this.value);
        });
    });
    
    // Listen for item select change to populate code and unit
    itemSelect.addEventListener('change', function() {
        const selected = this.selectedOptions[0];
        if (!selected) return;
        codeField.value = selected.dataset.code ?? 'N/A';
        unitField.value = selected.dataset.unit ?? '';
    });
    
    // Initialize on page load
    filterItems(document.getElementById('Radio-sm-1').checked ? 'product' : 'raw_material');
});

// ✅ View History Button Click Handler
document.querySelectorAll('.view-history-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const itemId = this.dataset.itemId;
        const itemType = this.dataset.itemType;
        const name = this.dataset.name;
        const code = this.dataset.code || '—';
        
        // Update modal header
        document.getElementById('history-product-name').textContent = name;
        document.getElementById('history-product-code').textContent = code;
        
        // Loading state
        const tbody = document.getElementById('inventory-history-body');
        tbody.innerHTML = `<tr><td colspan="6" class="text-center">Loading...</td></tr>`;
        
        // Fetch history
        fetch(`/inventory/history?item_type=${itemType}&item_id=${itemId}`)
            .then(res => res.json())
            .then(data => {
                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="6" class="text-center">No history found.</td></tr>`;
                    return;
                }
                
                // ✅ Update table header to include Notes column
                document.querySelector('#inventory-history-table thead tr').innerHTML = `
                    <th>Date</th>
                    <th>Unit</th>
                    <th>Adjustments</th>
                    <th>Stock</th>
                    <th>Reason</th>
                    <th>Notes</th>
                `;
                
                let rows = '';
                data.forEach(log => {
            // ✅ FIX: Proper source detection
            let sourceBadge = '';
            if (log.source && log.source.type === 'order') {
                sourceBadge = `<span class="badge bg-primary ms-2">Order ${log.source.reference}</span>`;
            } else {
                sourceBadge = `<span class="badge bg-secondary ms-2">Manual</span>`;
            }
            
            rows += `
            <tr>
                <td><h6 class="fw-medium fs-14">${log.date}</h6></td>
                <td class="text-dark">${log.unit}</td>
                <td class="${log.adjustment_class} fw-medium">${log.adjustment}</td>
                <td>${log.stock}</td>
                <td>
                    <span class="${log.badge_class}">${log.reason}</span>
                    ${sourceBadge}
                </td>
                <td title="${log.notes}">
                    <small>${log.notes.length > 50 ? log.notes.substring(0, 50) + '...' : log.notes}</small>
                </td>
            </tr>`;
        });
                tbody.innerHTML = rows;
            })
            .catch(err => {
                console.error(err);
                tbody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Failed to load history.</td></tr>`;
            });
    });
});
</script>
@endpush