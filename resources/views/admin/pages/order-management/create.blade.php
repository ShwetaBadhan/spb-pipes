@extends('admin.layout.master')

@section('content')
  <!-- ========================
         Start Page Content
        ========================= -->

    <div class="page-wrapper">

       <div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Create New Order</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.orders.store') }}" method="POST" id="order-form">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <!-- Customer Details Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Customer Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                        <input type="text" name="customer_name" class="form-control" 
                                               value="{{ old('customer_name') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" name="customer_phone" class="form-control" 
                                               value="{{ old('customer_phone') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="customer_email" class="form-control" 
                                               value="{{ old('customer_email') }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea name="customer_address" class="form-control" rows="2">{{ old('customer_address') }}</textarea>
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
                                    <!-- Items added dynamically -->
                                </div>
                                <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addItem()">
                                    <i data-feather="plus"></i> Add Item
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
                                <div class="mb-3">
                                    <label class="form-label">Tax</label>
                                    <input type="number" name="tax" class="form-control" step="0.01" value="0" min="0" id="tax-input">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Shipping Cost</label>
                                    <input type="number" name="shipping_cost" class="form-control" step="0.01" value="0" min="0" id="shipping-input">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                                </div>
                                
                                <div class="mb-3 p-3 bg-light rounded">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <strong>₹<span id="subtotal-amount">0.00</span></strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Tax:</span>
                                        <strong>₹<span id="tax-amount">0.00</span></strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Shipping:</span>
                                        <strong>₹<span id="shipping-amount">0.00</span></strong>
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
let itemCount = 0;
const products = @json($products);

function addItem() {
    const itemHtml = `
        <div class="item-row mb-3 p-3 border rounded bg-light" data-index="${itemCount}">
            <div class="row align-items-end">
                <div class="col-md-5">
                    <label class="form-label">Product</label>
                    <select name="items[${itemCount}][product_id]" class="form-select product-select" required
                            onchange="updateProductDetails(${itemCount})">
                        <option value="">Select Product</option>
                        ${products.map(p => `<option value="${p.id}" data-price="${p.price || 0}">${p.name}</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Qty</label>
                    <input type="number" name="items[${itemCount}][quantity]" class="form-control quantity-input" 
                           min="1" value="1" required onchange="calculateSubtotal(${itemCount})">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Price</label>
                    <input type="number" name="items[${itemCount}][unit_price]" class="form-control price-input" 
                           step="0.01" min="0" required onchange="calculateSubtotal(${itemCount})">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Amount</label>
                    <input type="text" class="form-control subtotal" value="0.00" readonly>
                </div>
                <div class="col-md-1 d-flex align-items-end mb-2">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${itemCount})">
                        <i data-feather="trash-2"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('order-items').insertAdjacentHTML('beforeend', itemHtml);
    itemCount++;
    feather.replace();
}

function updateProductDetails(index) {
    const select = document.querySelector(`[name="items[${index}][product_id]"]`);
    const price = select.options[select.selectedIndex].getAttribute('data-price');
    
    if (price) {
        document.querySelector(`[name="items[${index}][unit_price]"]`).value = parseFloat(price).toFixed(2);
        calculateSubtotal(index);
    }
}

function calculateSubtotal(index) {
    const quantity = parseFloat(document.querySelector(`[name="items[${index}][quantity]"]`).value) || 0;
    const price = parseFloat(document.querySelector(`[name="items[${index}][unit_price]"]`).value) || 0;
    const subtotal = quantity * price;
    
    document.querySelectorAll(`.item-row[data-index="${index}"] .subtotal`)[0].value = subtotal.toFixed(2);
    calculateOrderTotal();
}

function removeItem(index) {
    if (document.querySelectorAll('.item-row').length > 1) {
        document.querySelectorAll(`.item-row[data-index="${index}"]`)[0].remove();
        calculateOrderTotal();
    } else {
        alert('At least one item is required');
    }
}

function calculateOrderTotal() {
    let subtotal = 0;
    document.querySelectorAll('.subtotal').forEach(input => {
        subtotal += parseFloat(input.value) || 0;
    });
    
    const tax = parseFloat(document.getElementById('tax-input').value) || 0;
    const shipping = parseFloat(document.getElementById('shipping-input').value) || 0;
    const total = subtotal + tax + shipping;
    
    document.getElementById('subtotal-amount').textContent = subtotal.toFixed(2);
    document.getElementById('tax-amount').textContent = tax.toFixed(2);
    document.getElementById('shipping-amount').textContent = shipping.toFixed(2);
    document.getElementById('order-total').textContent = total.toFixed(2);
}

// Initialize with one item
addItem();
</script>
@endpush