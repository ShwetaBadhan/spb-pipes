@extends('admin.layout.master')

@section('content')
    <!-- ========================
                 Start Page Content
                ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content content-two">

            <!-- Page Header -->
            <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <h6>Order Details</h6>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">

                    <div>
                        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="isax isax-add-circle5 me-1"></i>Add Order
                        </a>

                    </div>
                </div>
            </div>
            <!-- End Page Header -->

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        timer: 5000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            @endif

            @if ($errors->any())
                <script>
                    let errorMessages = [];
                    @foreach ($errors->all() as $error)
                        errorMessages.push("{{ $error }}");
                    @endforeach

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: errorMessages.join('<br>'),
                        timer: 6000,
                        timerProgressBar: true,
                        showConfirmButton: true
                    });
                </script>
            @endif
            <ul class="nav nav-tabs nav-bordered mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="#tab1" data-bs-toggle="tab">
                        <i class="isax isax-document-text me-1"></i>All
                        <span class="badge bg-secondary ms-1">{{ $orders->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tab2" data-bs-toggle="tab">
                        <i class="isax isax-clock me-1"></i>Pending
                        <span class="badge bg-warning ms-1">{{ $orders->where('status', 'pending')->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tab3" data-bs-toggle="tab">
                        <i class="isax isax-check-circle me-1"></i>Confirmed
                        <span class="badge bg-info ms-1">{{ $orders->where('status', 'confirmed')->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tab4" data-bs-toggle="tab">
                        <i class="isax isax-setting-2 me-1"></i>Processing
                        <span class="badge bg-primary ms-1">{{ $orders->where('status', 'processing')->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tab5" data-bs-toggle="tab">
                        <i class="isax isax-close-circle me-1"></i>Cancelled
                        <span class="badge bg-danger ms-1">{{ $orders->where('status', 'cancelled')->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tab6" data-bs-toggle="tab">
                        <i class="isax isax-truck me-1"></i>Shipped
                        <span class="badge bg-success ms-1">{{ $orders->where('status', 'shipped')->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tab7" data-bs-toggle="tab">
                        <i class="isax isax-check-square me-1"></i>Delivered
                        <span class="badge bg-success ms-1">{{ $orders->where('status', 'delivered')->count() }}</span>
                    </a>
                </li>
            </ul>
            <!-- Tab Content -->
            <div class="tab-content">
                <!-- All Orders Tab -->
                <div class="tab-pane show active" id="tab1">
                    @include('admin.pages.order-management.partials.order-table', [
                        'orders' => $orders,
                        'statusFilter' => null,
                    ])
                </div>

                <!-- Pending Orders Tab -->
                <div class="tab-pane" id="tab2">
                    @include('admin.pages.order-management.partials.order-table', [
                        'orders' => $orders->where('status', 'pending'),
                        'statusFilter' => 'pending',
                    ])
                </div>

                <!-- Confirmed Orders Tab -->
                <div class="tab-pane" id="tab3">
                    @include('admin.pages.order-management.partials.order-table', [
                        'orders' => $orders->where('status', 'confirmed'),
                        'statusFilter' => 'confirmed',
                    ])
                </div>

                <!-- Processing Orders Tab -->
                <div class="tab-pane" id="tab4">
                    @include('admin.pages.order-management.partials.order-table', [
                        'orders' => $orders->where('status', 'processing'),
                        'statusFilter' => 'processing',
                    ])
                </div>

                <!-- Cancelled Orders Tab -->
                <div class="tab-pane" id="tab5">
                    @include('admin.pages.order-management.partials.order-table', [
                        'orders' => $orders->where('status', 'cancelled'),
                        'statusFilter' => 'cancelled',
                    ])
                </div>

                <!-- Shipped Orders Tab -->
                <div class="tab-pane" id="tab6">
                    @include('admin.pages.order-management.partials.order-table', [
                        'orders' => $orders->where('status', 'shipped'),
                        'statusFilter' => 'shipped',
                    ])
                </div>

                <!-- Delivered Orders Tab -->
                <div class="tab-pane" id="tab7">
                    @include('admin.pages.order-management.partials.order-table', [
                        'orders' => $orders->where('status', 'delivered'),
                        'statusFilter' => 'delivered',
                    ])
                </div>
            </div>


        </div>
        <!-- End Content -->

    </div>

    <!-- ========================
               End Page Content
              ========================= -->

    <!-- Order Details Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="orderDetailsModalLabel">
                        <i class="isax isax-receipt-item me-2"></i>Order Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Loading Spinner -->
                    <div id="modal-loading" class="text-center py-5" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading order details...</p>
                    </div>

                    <!-- Order Details Content -->
                    <div id="modal-content" style="display: none;">
                        <!-- Order Header -->
                        <div class="row mb-4 pb-3 border-bottom">
                            <div class="col-md-6">
                                <h6 class="mb-1">Order Number</h6>
                                <p class="fw-bold text-primary fs-5" id="modal-order-number"></p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <h6 class="mb-1">Status</h6>
                                <span class="badge" id="modal-status-badge"></span>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="mb-4">
                            <h6 class="mb-3"><i class="isax isax-user me-2"></i>Customer Information</h6>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Name</small>
                                    <p class="mb-0 fw-medium" id="modal-customer-name"></p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Phone</small>
                                    <p class="mb-0" id="modal-customer-phone"></p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Email</small>
                                    <p class="mb-0" id="modal-customer-email"></p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Address</small>
                                    <p class="mb-0" id="modal-customer-address"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="mb-4">
                            <h6 class="mb-3"><i class="isax isax-shopping-cart me-2"></i>Order Items</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Unit Price</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modal-order-items">
                                        <!-- Items will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="mb-4">
                            <h6 class="mb-3"><i class="isax isax-receipt-item me-2"></i>Order Summary</h6>
                            <div class="bg-light p-3 rounded">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <strong>₹<span id="modal-subtotal">0.00</span></strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax:</span>
                                    <strong>₹<span id="modal-tax">0.00</span></strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <strong>₹<span id="modal-shipping">0.00</span></strong>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">Total:</span>
                                    <strong class="text-primary fs-5">₹<span id="modal-total">0.00</span></strong>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="mb-4">
                            <h6 class="mb-3"><i class="isax isax-note me-2"></i>Additional Information</h6>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Created At</small>
                                    <p class="mb-0" id="modal-created-at"></p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Notes</small>
                                    <p class="mb-0" id="modal-notes">-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Status Change Modal -->
    <!-- Status Change Modal - Simple Form -->
    <div class="modal fade" id="statusChangeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="isax isax-edit me-2"></i>Change Order Status
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="statusChangeForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <input type="hidden" id="status-order-id" name="order_id">

                        <div class="mb-3">
                            <label class="form-label">Current Status</label>
                            <div class="h5" id="current-status-display"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Change To <span class="text-danger">*</span></label>
                            <select class="form-select" id="new-status" name="status" required>
                                <option value="">-- Select Status --</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="isax isax-check-circle me-1"></i>Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Prevent duplicate script execution
        if (typeof window.orderManagementScriptLoaded === 'undefined') {
            window.orderManagementScriptLoaded = true;

            $(document).ready(function() {
                console.log('Order Management Script Loaded');

                // ========== View Order Modal ==========
                $('#orderDetailsModal').off('show.bs.modal').on('show.bs.modal', function(event) {
                    const button = $(event.relatedTarget);
                    const orderId = button.data('order-id');

                    console.log('Opening order details modal for order:', orderId);

                    // Show loading
                    $('#modal-loading').show();
                    $('#modal-content').hide();

                    // Fetch order details
                    $.ajax({
                        url: '{{ url('admin/orders') }}/' + orderId + '/details',
                        method: 'GET',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('Order details loaded successfully');

                            // Populate modal
                            $('#modal-order-number').text(response.order.order_number);
                            $('#modal-customer-name').text(response.order.customer_name || '-');
                            $('#modal-customer-phone').text(response.order.customer_phone ||
                                '-');
                            $('#modal-customer-email').text(response.order.customer_email ||
                                '-');
                            $('#modal-customer-address').text(response.order.customer_address ||
                                '-');
                            $('#modal-subtotal').text(parseFloat(response.order.subtotal)
                                .toFixed(2));
                            $('#modal-tax').text(parseFloat(response.order.tax || 0).toFixed(
                                2));
                            $('#modal-shipping').text(parseFloat(response.order.shipping_cost ||
                                0).toFixed(2));
                            $('#modal-total').text(parseFloat(response.order.total).toFixed(2));
                            $('#modal-created-at').text(response.order.created_at);
                            $('#modal-notes').text(response.order.notes || '-');

                            // Set status badge
                            const status = response.order.status;
                            const badgeClass = getStatusBadgeClass(status);
                            $('#modal-status-badge')
                                .text(status.charAt(0).toUpperCase() + status.slice(1))
                                .removeClass()
                                .addClass('badge bg-' + badgeClass);

                            // Populate items
                            let itemsHtml = '';
                            if (response.items && response.items.length > 0) {
                                response.items.forEach(function(item) {
                                    itemsHtml += `
                                <tr>
                                    <td>
                                        <strong>${item.product_name}</strong>
                                        ${item.variant_name ? '<br><small class="text-muted">' + item.variant_name + '</small>' : ''}
                                    </td>
                                    <td>${item.quantity}</td>
                                    <td>₹${parseFloat(item.unit_price).toFixed(2)}</td>
                                    <td>₹${parseFloat(item.subtotal).toFixed(2)}</td>
                                </tr>
                            `;
                                });
                            } else {
                                itemsHtml =
                                    `<tr><td colspan="4" class="text-center text-muted">No items found</td></tr>`;
                            }
                            $('#modal-order-items').html(itemsHtml);

                            // Hide loading, show content
                            $('#modal-loading').hide();
                            $('#modal-content').show();
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                            $('#modal-loading').hide();
                            $('#modal-content').show();
                            $('#modal-order-items').html(`
                        <tr>
                            <td colspan="4" class="text-center text-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Failed to load order details
                            </td>
                        </tr>
                    `);
                        }
                    });
                });

                // ========== Change Status Modal ==========
                $(document).off('click', '.change-status-btn').on('click', '.change-status-btn', function() {
                    const orderId = $(this).data('order-id');
                    const currentStatus = $(this).data('current-status');

                    console.log('Opening status change modal for order:', orderId, 'Current status:',
                        currentStatus);

                    // Set order ID
                    $('#status-order-id').val(orderId);

                    // Display current status with badge
                    const badgeClass = getStatusBadgeClass(currentStatus);
                    $('#current-status-display').html(`
                <span class="badge bg-${badgeClass} fs-5">
                    ${currentStatus.charAt(0).toUpperCase() + currentStatus.slice(1)}
                </span>
            `);

                    // Open modal
                    $('#statusChangeModal').modal('show');
                });

                // ========== Status Change Form Submit ==========
                $('#statusChangeForm').off('submit').on('submit', function(e) {
                    e.preventDefault();

                    const orderId = $('#status-order-id').val();
                    const newStatus = $('#new-status').val();

                    console.log('Status change form submitted for order:', orderId, 'New status:',
                        newStatus);

                    if (!newStatus) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning!',
                            text: 'Please select a status',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        return;
                    }

                    // Prevent double submission
                    const submitBtn = $(this).find('button[type="submit"]');
                    if (submitBtn.prop('disabled')) {
                        console.log('Form already submitting, ignoring duplicate submission');
                        return;
                    }

                    // Disable submit button
                    submitBtn.prop('disabled', true).html(
                        '<i class="fas fa-spinner fa-spin me-1"></i>Updating...');

                    // Show loading
                    Swal.fire({
                        title: 'Updating Status...',
                        html: `<div class="d-flex flex-column align-items-center">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <small>Processing order status change...</small>
                </div>`,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading(null);
                        }
                    });

                    $.ajax({
                        url: '{{ url('admin/orders') }}/' + orderId + '/status',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            _method: 'PATCH',
                            status: newStatus
                        },
                        success: function(response) {
                            console.log('Status update successful:', response);

                            // Close modal
                            $('#statusChangeModal').modal('hide');

                            // Update status badge in the table
                            const statusBadge = $(`#status-badge-${orderId}`);
                            if (statusBadge.length > 0) {
                                const badgeClass = getStatusBadgeClass(response.new_status);
                                statusBadge
                                    .text(response.new_status.charAt(0).toUpperCase() + response
                                        .new_status.slice(1))
                                    .removeClass()
                                    .addClass('badge bg-' + badgeClass);

                                // Update status in dropdown button text
                                const dropdownBtn = $(`#status-dropdown-${orderId} button`);
                                if (dropdownBtn.length > 0) {
                                    dropdownBtn.removeClass().addClass(
                                        `btn btn-sm dropdown-toggle bg-${badgeClass} text-white`
                                    );
                                }
                            }

                            // Update status in order details modal if open
                            if ($('#orderDetailsModal').is(':visible')) {
                                const modalBadgeClass = getStatusBadgeClass(response
                                    .new_status);
                                $('#modal-status-badge')
                                    .text(response.new_status.charAt(0).toUpperCase() + response
                                        .new_status.slice(1))
                                    .removeClass()
                                    .addClass('badge bg-' + modalBadgeClass);
                            }

                            // Re-enable submit button
                            submitBtn.prop('disabled', false).html(
                                '<i class="isax isax-check-circle me-1"></i>Update Status');

                            // Show success message (ONLY ONE TIME)
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                html: `<strong>Status updated to "${response.new_status}"</strong><br>
                               ${response.old_status === 'pending' && response.new_status === 'confirmed' ? '✅ Stock deducted successfully!' : 
                                 response.old_status !== 'cancelled' && response.new_status === 'cancelled' ? '🔄 Stock restored successfully!' : ''}`,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function(xhr) {
                            console.error('Status update error:', xhr);

                            let errorMsg = 'Failed to update status';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }

                            // Re-enable submit button
                            submitBtn.prop('disabled', false).html(
                                '<i class="isax isax-check-circle me-1"></i>Update Status');

                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                html: `<strong>${errorMsg}</strong><br>
                               <small class="text-muted">Check console for details</small>`,
                                timer: 4000,
                                showConfirmButton: true
                            });
                        }
                    });
                });

                // Reset status modal when closed
                $('#statusChangeModal').off('hidden.bs.modal').on('hidden.bs.modal', function() {
                    $('#statusChangeForm')[0].reset();
                    $('#current-status-display').html('');
                });

                // Helper function for status badge
                function getStatusBadgeClass(status) {
                    const classes = {
                        'pending': 'warning',
                        'confirmed': 'info',
                        'processing': 'primary',
                        'shipped': 'success',
                        'delivered': 'success',
                        'cancelled': 'danger'
                    };
                    return classes[status] || 'secondary';
                }
            });
        }
    </script>
@endpush
