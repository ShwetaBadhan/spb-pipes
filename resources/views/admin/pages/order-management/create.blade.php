@extends('admin.layout.master')

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mt-4">Create New Order</h1>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.orders.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <!-- Customer Selection Section -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Customer Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Select Customer <span
                                                    class="text-danger">*</span></label>
                                            <select name="customer_id" class="form-select" id="customer-select" required>
                                                <option value="">-- Select Customer --</option>
                                                @forelse($customers as $customer)
                                                    <option value="{{ $customer->id }}" data-name="{{ $customer->name }}"
                                                        data-phone="{{ $customer->phone ?? '' }}"
                                                        data-email="{{ $customer->email ?? '' }}"
                                                        data-address="{{ $customer->shipping_address ?? '' }}">
                                                        {{ $customer->name }}
                                                        @if ($customer->phone)
                                                            - {{ $customer->phone }}
                                                        @endif
                                                    </option>
                                                @empty
                                                    <option disabled>No customers available</option>
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Customer Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="customer_name" id="customer_name"
                                                    class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Phone Number</label>
                                                <input type="text" name="customer_phone" id="customer_phone"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="customer_email" id="customer_email"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Address</label>
                                                <textarea name="customer_address" id="customer_address" class="form-control" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Items Section -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Order Items</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="order-items">
                                            <!-- First item row -->
                                            <div class="item-row mb-3 p-3 border rounded bg-light">
                                                <div class="row align-items-end">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Product <span
                                                                class="text-danger">*</span></label>
                                                        <select name="items[0][product_id]"
                                                            class="form-select product-select" required>
                                                            <option value="">-- Select Product --</option>
                                                            @foreach ($products as $product)
                                                                @php
                                                                    $badgeClass =
                                                                        $product['quantity'] < 5
                                                                            ? 'danger'
                                                                            : ($product['quantity'] < 10
                                                                                ? 'warning'
                                                                                : 'success');
                                                                @endphp
                                                                <option value="{{ $product['id'] }}"
                                                                    data-variant-id="{{ $product['variant_id'] }}"
                                                                    data-variant-name="{{ $product['variant_name'] }}"
                                                                    data-price="{{ $product['selling_price'] }}"
                                                                    data-stock="{{ $product['quantity'] }}">
                                                                    {{ $product['product_name'] }}

                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="text-muted d-block mt-1 stock-warning"
                                                            style="display:none;"></small>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Qty</label>
                                                        <input type="number" name="items[0][quantity]"
                                                            class="form-control quantity-input" min="1"
                                                            value="1" required>
                                                        <input type="hidden" name="items[0][variant_id]"
                                                            class="variant-id-input">
                                                        <input type="hidden" name="items[0][variant_name]"
                                                            class="variant-name-input">
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label class="form-label">Price</label>
                                                        <input type="number" name="items[0][unit_price]"
                                                            class="form-control price-input" step="0.01" min="0"
                                                            value="0.00" required readonly>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Amount</label>
                                                        <input type="text" class="form-control item-subtotal"
                                                            value="0.00" readonly>
                                                    </div>
                                                    <div class="col-md-1 d-flex align-items-end mb-2">
                                                        <button type="button" class="btn btn-danger btn-sm remove-item"
                                                            disabled>
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary mt-2" id="add-item-btn">
                                            <i class="fas fa-plus"></i> Add Item
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Order Summary</h5>
                                    </div>
                                    <div class="card-body">
                                       
                                     

                                        <div class="mb-3 p-3 bg-light rounded">
    <div class="d-flex justify-content-between mb-2">
        <span>Subtotal:</span>
        <strong>₹<span id="subtotal-amount">0.00</span></strong>
    </div>
    <hr>
    <div class="d-flex justify-content-between">
        <span><strong>Total:</strong></span>
        <strong class="text-primary fs-5">₹<span id="order-total">0.00</span></strong>
    </div>
</div>

                                        <button type="submit" class="btn btn-primary w-100">Create Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // ✅ Check if we're on the order create route
            const currentRoute = '{{ Route::currentRouteName() }}';
            const isCreatePage = currentRoute === 'admin.orders.create';

            // ✅ Stock Validation Errors (ONLY on create page)
            @if ($errors->has('stock'))
                if (isCreatePage) {
                    $(function() {
                        const errors = @json(explode("\n", $errors->first('stock')));

                        let errorHtml = '';
                        errors.forEach((error, index) => {
                            errorHtml += `<p style="margin: 8px 0; padding: 10px; background: rgba(220, 53, 69, 0.1); border-left: 3px solid #dc3545; border-radius: 4px;">
                    <i class="fas fa-exclamation-circle me-2" style="color: #dc3545;"></i>
                    <strong>Item #${index + 1}:</strong> ${error}
                </p>`;
                        });

                        Swal.fire({
                            icon: 'error',
                            title: '<strong><i class="fas fa-boxes me-2"></i>Insufficient Stock!</strong>',
                            html: `
                    <div style="text-align: left; max-height: 400px; overflow-y: auto;">
                        <p style="margin-bottom: 15px; color: #666;">
                            <i class="fas fa-info-circle me-2"></i>
                            Please adjust quantities or select different products before proceeding.
                        </p>
                        ${errorHtml}
                    </div>
                `,
                            confirmButtonText: '<i class="fas fa-times me-1"></i>OK',
                            confirmButtonColor: '#dc3545',
                            customClass: {
                                popup: 'swal2-wide'
                            },
                            width: '600px'
                        });
                    });
                }
            @endif

            // ✅ General Validation Errors (ONLY on create page)
            @if ($errors->any() && !$errors->has('stock'))
                if (isCreatePage) {
                    $(function() {
                        let errorMessages = [];
                        @foreach ($errors->all() as $error)
                            errorMessages.push("{{ $error }}");
                        @endforeach

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error!',
                            html: errorMessages.join('<br>'),
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#dc3545',
                            timer: 6000,
                            timerProgressBar: true
                        });
                    });
                }
            @endif

            // ✅ Success Message (ONLY on create page)
            @if (session('success'))
                if (isCreatePage) {
                    $(function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: '{{ session('success') }}',
                            timer: 5000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });
                    });
                }
            @endif
        });

        // Products data from backend
        const productsData = @json($products);

        // Auto-fill customer details
        document.getElementById('customer-select').addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            document.getElementById('customer_name').value = option.getAttribute('data-name') || '';
            document.getElementById('customer_phone').value = option.getAttribute('data-phone') || '';
            document.getElementById('customer_email').value = option.getAttribute('data-email') || '';
            document.getElementById('customer_address').value = option.getAttribute('data-address') || '';
        });
        // Auto-fill price AND variant info when product/variant is selected


        // Auto-fill price AND variant info when product/variant is selected
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select')) {
                const option = e.target.options[e.target.selectedIndex];
                const productId = option.value;
                const variantId = option.getAttribute('data-variant-id');
                const variantName = option.getAttribute('data-variant-name');
                const price = option.getAttribute('data-price');
                const stock = option.getAttribute('data-stock');

                if (productId && variantId) {
                    const row = e.target.closest('.item-row');

                    // Safety checks
                    const priceValue = parseFloat(price) || 0;
                    const stockValue = parseInt(stock) || 0;

                    row.querySelector('.price-input').value = priceValue.toFixed(2);
                    row.querySelector('.variant-id-input').value = variantId;
                    row.querySelector('.variant-name-input').value = variantName || '';

                    // Show stock warning
                    const stockWarning = row.querySelector('.stock-warning');
                    if (stockValue < 5 && stockValue > 0) {
                        stockWarning.innerHTML =
                            `<i class="fas fa-exclamation-circle me-1"></i> Low stock: Only ${stockValue} available`;
                        stockWarning.style.display = 'block';
                        stockWarning.style.color = 'orange';
                    } else if (stockValue === 0) {
                        stockWarning.innerHTML = `<i class="fas fa-times-circle me-1"></i> Out of stock!`;
                        stockWarning.style.display = 'block';
                        stockWarning.style.color = 'red';
                        stockWarning.style.fontWeight = 'bold';
                    } else {
                        stockWarning.style.display = 'none';
                    }

                    calculateRow(row);
                    calculateOrderTotal();
                }
            }
        });

        // Real-time stock validation on quantity change
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity-input')) {
                const row = e.target.closest('.item-row');
                const variantId = row.querySelector('.variant-id-input')?.value;
                const requestedQty = parseInt(e.target.value) || 0;
                const stock = parseInt(row.querySelector('.product-select option:checked')?.getAttribute(
                    'data-stock')) || 0;

                if (variantId && requestedQty > 0) {
                    const stockWarning = row.querySelector('.stock-warning');

                    if (requestedQty > stock) {
                        stockWarning.innerHTML = `<i class="fas fa-exclamation-triangle me-1"></i> 
                    Insufficient stock! Requested: ${requestedQty}, Available: ${stock}`;
                        stockWarning.style.display = 'block';
                        stockWarning.style.color = 'red';
                        stockWarning.style.fontWeight = 'bold';
                    } else if (stock < 5 && stock > 0) {
                        stockWarning.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i> 
                    Low stock: Only ${stock} available`;
                        stockWarning.style.display = 'block';
                        stockWarning.style.color = 'orange';
                    } else {
                        stockWarning.style.display = 'none';
                    }
                }

                calculateRow(row);
                calculateOrderTotal();
            }
        });

        // Update "Add Item" button to include variant fields
        document.getElementById('add-item-btn').addEventListener('click', function() {
            const rowCount = document.querySelectorAll('.item-row').length;

            // Build product options (flat structure)
            let productOptions = '';
            @foreach ($products as $product)
                @php
                    $badgeClass = $product['quantity'] < 5 ? 'danger' : ($product['quantity'] < 10 ? 'warning' : 'success');
                @endphp
                productOptions += `<option value="{{ $product['id'] }}"
               
                data-price="{{ $product['selling_price'] }}"
                data-stock="{{ $product['quantity'] }}">
            {{ $product['product_name'] }} 
            
        </option>`;
            @endforeach

            const newRow = `
        <div class="item-row mb-3 p-3 border rounded bg-light">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Product</label>
                    <select name="items[${rowCount}][product_id]" class="form-select product-select" required>
                        <option value="">-- Select Product --</option>
                        ${productOptions}
                    </select>
                    <small class="text-muted d-block mt-1 stock-warning" style="display:none;"></small>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Qty</label>
                    <input type="number" name="items[${rowCount}][quantity]" class="form-control quantity-input" min="1" value="1" required>
                    <input type="hidden" name="items[${rowCount}][variant_id]" class="variant-id-input">
                    <input type="hidden" name="items[${rowCount}][variant_name]" class="variant-name-input">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Price</label>
                    <input type="number" name="items[${rowCount}][unit_price]" class="form-control price-input" step="0.01" min="0" value="0.00" required readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Amount</label>
                    <input type="text" class="form-control item-subtotal" value="0.00" readonly>
                </div>
                <div class="col-md-1 d-flex align-items-end mb-2">
                    <button type="button" class="btn btn-danger btn-sm remove-item">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;

            document.getElementById('order-items').insertAdjacentHTML('beforeend', newRow);
        });

        // Calculate on quantity or price input
        document.addEventListener('input', function(e) {
            const row = e.target.closest('.item-row');

            if (row && (e.target.classList.contains('quantity-input') || e.target.classList.contains(
                'price-input'))) {
                // ✅ Check stock availability in real-time
                if (e.target.classList.contains('quantity-input')) {
                    const productId = row.querySelector('.product-select').value;
                    const requestedQty = parseInt(e.target.value) || 0;

                    if (productId && requestedQty > 0) {
                        const product = productsData.find(p => p.id == productId);
                        if (product && product.stock !== null) {
                            const stockWarning = row.querySelector('.stock-warning');

                            if (requestedQty > product.stock) {
                                stockWarning.innerHTML = `<i class="fas fa-exclamation-triangle me-1"></i> 
                            Insufficient stock! Requested: ${requestedQty}, Available: ${product.stock}`;
                                stockWarning.style.display = 'block';
                                stockWarning.style.color = 'red';
                                stockWarning.style.fontWeight = 'bold';
                            } else if (product.stock < 5) {
                                stockWarning.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i> 
                            Low stock: Only ${product.stock} available`;
                                stockWarning.style.display = 'block';
                                stockWarning.style.color = 'orange';
                            } else {
                                stockWarning.style.display = 'none';
                            }
                        }
                    }
                }

                calculateRow(row);
                calculateOrderTotal();
            }

          
        });

        // Calculate single row amount
        function calculateRow(row) {
            const qty = row.querySelector('.quantity-input').value;
            const price = row.querySelector('.price-input').value;
            const subtotal = row.querySelector('.item-subtotal');

            const amount = parseFloat(qty || 0) * parseFloat(price || 0);
            subtotal.value = amount.toFixed(2);
        }

        // Calculate order totals
       function calculateOrderTotal() {
    let subtotal = 0;

    document.querySelectorAll('.item-subtotal').forEach(function(input) {
        subtotal += parseFloat(input.value) || 0;
    });

    // Total = Subtotal (no tax/shipping)
    const total = subtotal;

    document.getElementById('subtotal-amount').textContent = subtotal.toFixed(2);
    document.getElementById('order-total').textContent = total.toFixed(2);
}


        // Remove item row
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-item')) {
                const row = e.target.closest('.item-row');
                const rowCount = document.querySelectorAll('.item-row').length;

                if (rowCount > 1) {
                    row.remove();
                    calculateOrderTotal();

                    if (document.querySelectorAll('.item-row').length === 1) {
                        document.querySelector('.remove-item').disabled = true;
                    }
                } else {
                    alert('At least one item is required');
                }
            }
        });

        // Initial calculation
        document.addEventListener('DOMContentLoaded', function() {
            calculateOrderTotal();
        });
    </script>
@endpush