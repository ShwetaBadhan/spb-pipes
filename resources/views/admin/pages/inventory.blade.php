@extends('admin.layout.master')
@section('title', 'Admin Inventory')
@section('content')
    <!-- ========================
           Start Page Content
          ========================= -->
    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content content-two">

            <!-- Start Breadcrumb -->
            <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <h6>Inventory</h6>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <i class="isax isax-export-1 me-1"></i>Export
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">Download as PDF</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Download as Excel</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#add_modal">
                            <i class="isax isax-add-circle5 me-1"></i>New Inventory
                        </a>
                    </div>
                </div>
            </div>
            <!-- End Breadcrumb -->

            <!-- Table Search Start -->
            <div class="mb-3">

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="table-search d-flex align-items-center mb-0">
                            <div class="search-input">
                                <a href="javascript:void(0);" class="btn-searchset"><i
                                        class="isax isax-search-normal fs-12"></i></a>
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
                            <ul class="dropdown-menu  dropdown-menu-end">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">Latest</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">Oldest</a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                <i class="isax isax-grid-3 me-1"></i>Column
                            </a>
                            <ul class="dropdown-menu  dropdown-menu">
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
            <!-- Table Search End -->

            <!-- Table List Start -->
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
            <th class="no-sort">Product/Service</th>
            <th class="no-sort">Code</th>
            <th class="no-sort">Unit</th>
            <th>Original Quantity</th>
            <th>Available Quantity</th>
            <th class="no-sort">Status</th>
            <th class="no-sort">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            @foreach ($product->variants as $variant)
                @php
                    // Get latest inventory log for this product
                    $latestLog = $product->inventoryLogs()
                        ->orderBy('id', 'desc')
                        ->first();
                @endphp
                <tr>
                    <td>
                        <div class="form-check form-check-md">
                            <input class="form-check-input" type="checkbox">
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center avatar avatar-sm rounded-circle me-2 flex-shrink-0">
                            @if ($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('assets/img/products/default.jfif') }}" alt="Default">
                            @endif
                            <div>
                                <h6 class="fs-14 fw-medium mb-0">
                                    <a href="javascript:void(0);">{{ $product->name ?? '—' }}</a>
                                </h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="javascript:void(0);" class="link-default">{{ $product->code ?? '—' }}</a>
                    </td>
                    <td class="text-dark">{{ optional($product->unit)->name ?? '—' }}</td>
                    <td>{{ $variant->quantity }}</td>
                    <td>
    {{ $variant->available_qty }}
</td>
                    <td>
                        @if ($latestLog)
                            <span class="badge bg-{{ $latestLog->status === 'stock_in' ? 'success' : 'danger' }}">
                                {{ ucfirst(str_replace('_', ' ', $latestLog->status)) }}
                            </span>
                        @else
                            <span class="badge bg-secondary">No Log</span>
                        @endif
                    </td>
                    <td class="action-item">
                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                            <i class="isax isax-more"></i>
                        </a>
                        <ul class="dropdown-menu">
                        <li>
    <a href="#" class="dropdown-item d-flex align-items-center view-history-btn"
        data-bs-toggle="modal"
        data-bs-target="#view_history"
        data-product="{{ $product->id }}"
        data-variant="{{ $variant->id ?? '' }}"
        data-name="{{ $product->name }}"
        data-code="{{ $product->code }}"
        data-unit="{{ optional($product->unit)->name ?? 'N/A' }}"
    >
        <i class="isax isax-eye me-2"></i> View History
    </a>
</li>
                            <li>
                                <a href="javascript:void(0);"
                                    class="edit-inventory-btn dropdown-item d-flex align-items-center"
                                    data-bs-toggle="modal"
                                    data-bs-target="#edit_modal"
                                    data-id="{{ $latestLog ? $latestLog->id : '' }}"
                                    data-product="{{ $product->id }}"
                                    data-code="{{ $product->code }}"
                                    data-unit="{{ optional($product->unit)->name }}"
                                    data-selling="{{ $variant->selling_price }}"
                                    data-purchase="{{ $variant->purchase_price }}"
                                    data-quantity="{{ $latestLog ? $latestLog->quantity : $variant->available_qty }}"
                                    data-status="{{ $latestLog ? $latestLog->status : 'stock_in' }}"
                                >
                                    <i class="isax isax-edit me-2"></i>Edit
                                </a>
                            </li>
                            <li>
                                <!-- Delete Trigger -->
<a href="javascript:void(0);"
   class="dropdown-item d-flex align-items-center"
   data-bs-toggle="modal"
   data-bs-target="#delete_log_{{ $latestLog->id }}">
    <i class="isax isax-trash me-2"></i> Delete
</a>
                            </li>
                        </ul>
                    </td>
                </tr>
                  <!-- Start Delete Modal  -->
  <!-- Delete Modal -->
<div class="modal fade" id="delete_log_{{ $latestLog->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="mb-3">
                    <img src="assets/img/icons/delete.svg" alt="Delete">
                </div>
                <h6 class="mb-1">Delete this log?</h6>
                <p class="mb-3">It will be removed from history.</p>
                <form action="{{ route('inventory.destroy', $latestLog->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
            @endforeach
        @endforeach
    </tbody>
</table>
            </div>
            <!-- Table List End -->

        </div>
        <!-- End Content -->



    </div>

    <!-- ========================
           End Page Content
          ========================= -->


    <!--  Start Add Modal  -->
    <!-- Add Modal -->
    <div id="add_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Inventory</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <form action="{{ route('inventory.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">


                        <div class="mb-3">
                            <label class="form-label">Item <span class="text-danger">*</span></label>
                            <select class="form-select" name="item_id" id="item-select" required>
                                <option value="">Select</option>
                                @foreach ($allProducts as $product)
                                    <!-- allProducts -->
                                    <option value="{{ $product->id }}" data-code="{{ $product->code }}"
                                        data-unit="{{ optional($product->unit)->name ?? 'N/A' }}"
                                        data-selling="{{ optional($product->variants->first())->selling_price ?? '0' }}"
                                        data-purchase="{{ optional($product->variants->first())->purchase_price ?? '0' }}">
                                        {{ $product->name }}
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Selling Price</label>
                                    <input type="text" class="form-control" id="selling-field" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Purchase Price</label>
                                    <input type="text" class="form-control" id="purchase-field" readonly>
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
    <!-- End Add Modal -->

 <!-- Start Edit Modal  -->
{{-- <div id="edit_modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Inventory</h4>
               <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close"><i class="fa-solid fa-x"></i></button>
            </div>
            <form id="editInventoryForm" method="POST" action="{{ route('inventory.store') }}">
                @csrf
               
                 <input type="hidden" name="id" id="edit_inventory_id">
    <input type="hidden" name="item_id" id="edit_item_id"> <!-- ✅ Add this -->

                <div class="modal-body">
                   

                    <div class="mb-3">
                        <label class="form-label">Item <span class="text-danger">*</span></label>
                       <input type="text" class="form-control" value="{{ $product->name }}" readonly>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Code</label>
                            <input type="text" class="form-control" id="edit_item_code" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Units</label>
                            <input type="text" class="form-control" id="edit_item_unit" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Selling Price ($)</label>
                            <input type="text" class="form-control" id="edit_item_selling" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Purchase Price ($)</label>
                            <input type="text" class="form-control" id="edit_item_purchase" readonly>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="quantity" id="edit_item_quantity" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" id="edit_item_status" required>
                                <option value="">Select</option>
                                <option value="stock_in">Stock In</option>
                                <option value="stock_out">Stock Out</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
<!-- End Edit Modal -->



    <!-- Start View History Modal  -->
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
        <div class="d-flex align-items-center">
            <!-- Optional: Keep download/print buttons or remove for now -->
        </div>
    </div>

    <!-- History Table Container -->
    <div class="table-responsive border border-bottom-0">
        <table class="table" id="inventory-history-table">
            <thead class="thead-light">
                <tr>
                    <th>Date</th>
                    <th>Unit</th>
                    <th>Adjustments</th>
                    <th>Stock</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody id="inventory-history-body">
                <tr>
                    <td colspan="5" class="text-center">Loading history...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
            </div>
        </div>
    </div>
    <!-- End View History Modal -->

  

@endsection


@push('scripts')
    <script>
        document.addEventListener('change', function(e) {
            if (e.target && e.target.id === 'item-select') {

                const option = e.target.options[e.target.selectedIndex];
                if (!option) return;

                document.getElementById('code-field').value =
                    option.getAttribute('data-code') || '';

                document.getElementById('unit-field').value =
                    option.getAttribute('data-unit') || '';

                document.getElementById('selling-field').value =
                    option.getAttribute('data-selling') || '';

                document.getElementById('purchase-field').value =
                    option.getAttribute('data-purchase') || '';
            }
        });

   document.querySelectorAll('.edit-inventory-btn').forEach(button => {
    button.addEventListener('click', function() {
        const modal = document.getElementById('edit_modal');
        const productId = this.dataset.product;
        const code = this.dataset.code;
        const unit = this.dataset.unit;
        const selling = this.dataset.selling;
        const purchase = this.dataset.purchase;
        const quantity = this.dataset.quantity;
        const status = this.dataset.status;

        // Clear log ID (since we're creating new log, not updating)
        document.getElementById('edit_inventory_id').value = '';

        // ✅ Set the product ID as item_id
        document.getElementById('edit_item_id').value = productId;

        // Populate display fields (readonly)
        document.getElementById('edit_item_code').value = code;
        document.getElementById('edit_item_unit').value = unit;
        document.getElementById('edit_item_selling').value = selling;
        document.getElementById('edit_item_purchase').value = purchase;
        document.getElementById('edit_item_quantity').value = quantity;
        document.getElementById('edit_item_status').value = status;

        new bootstrap.Modal(modal).show();
    });
});
document.querySelectorAll('.view-history-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const productId = this.dataset.product;
        const name = this.dataset.name;
        const code = this.dataset.code;

        // Update header
        document.getElementById('history-product-name').textContent = name;
        document.getElementById('history-product-code').textContent = code;

        // Show loading
        document.getElementById('inventory-history-body').innerHTML = 
            '<tr><td colspan="5" class="text-center">Loading...</td></tr>';

        // Fetch history
        fetch(`/inventory/history/${productId}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('inventory-history-body');
                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center">No history found.</td></tr>';
                    return;
                }

                let rows = '';
                data.forEach(log => {
                    rows += `
                        <tr>
                            <td><h6 class="fw-medium fs-14">${log.date}</h6></td>
                            <td class="text-dark">${log.unit}</td>
                            <td class="${log.adjustment_class} fw-medium">${log.adjustment}</td>
                            <td>${log.stock}</td>
                            <td class="text-dark">${log.reason}</td>
                        </tr>
                    `;
                });
                tbody.innerHTML = rows;
            })
            .catch(err => {
                console.error('Error loading history:', err);
                document.getElementById('inventory-history-body').innerHTML = 
                    '<tr><td colspan="5" class="text-center text-danger">Failed to load history.</td></tr>';
            });
    });
});

    </script>
@endpush
