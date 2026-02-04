@extends("admin.layout.master")
@section("title","Add Invoice")
@section('content')

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-11 mx-auto">
            {{-- ✅ ERROR MESSAGES DISPLAY --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="isax isax-danger"></i> Validation Failed!</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <ul class="mb-0 mt-2 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="isax isax-danger"></i> Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="isax isax-tick-circle"></i> Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6><a href="{{ route('admin.invoices.index') }}"><i class="isax isax-arrow-left me-2"></i>Invoice</a></h6>
                        <a href="{{ route('admin.invoices.show', ['invoice' => 0]) }}" class="btn btn-outline-white d-inline-flex align-items-center"><i class="isax isax-eye me-1"></i>Preview</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-3">Invoice Details</h6>
                            <form action="{{ route('admin.invoices.store') }}" method="POST">
                                @csrf
                                
                                <div class="border-bottom mb-3 pb-1">
                                    <div class="row justify-content-between">
                                        <div class="col-xl-5 col-lg-7">
                                            <div class="row gx-3">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Invoice Number</label>
                                                        <input type="text" class="form-control" placeholder="Auto-generated" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Reference Number</label>
                                                        <input type="text" name="reference_number" class="form-control" placeholder="Optional">
                                                    </div>
                                                </div>
                                              <div class="col-lg-12">
    <div class="input-group position-relative mb-3">
        <input type="date" name="invoice_date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
        <span class="input-icon-addon fs-16 text-gray-9">
            <i class="isax isax-calendar-2"></i>
        </span>
    </div>
</div>
<div class="col-lg-12">
    <div class="input-group position-relative mb-3">
        <input type="date" name="due_date" class="form-control" value="{{ now()->addDays(7)->format('Y-m-d') }}" required>
        <span class="input-icon-addon fs-16 text-gray-9">
            <i class="isax isax-calendar-2"></i>
        </span>
    </div>
</div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-4 col-lg-5">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Customer</label>
                                                        <select name="customer_id" class="select" required>
                                                            <option value="">Select Customer</option>
                                                            @foreach($customers as $customer)
                                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="select">
                                                            <option value="draft">Draft</option>
                                                            <option value="sent">Sent</option>
                                                            <option value="paid">Paid</option>
                                                            <option value="unpaid">Unpaid</option>
                                                            <option value="cancelled">Cancelled</option>
                                                            <option value="partially-paid">Partially Paid</option>
                                                            <option value="refunded">Refunded</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-3">
        <div class="form-check form-switch me-4">
            {{-- ✅ Add hidden input before checkbox --}}
            <input type="hidden" name="enable_tax" value="0">
            <input class="form-check-input" type="checkbox" role="switch" id="enable_tax" name="enable_tax" value="1" checked>
            <label class="form-check-label" for="enable_tax">Enable Tax</label>
        </div>
    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Tax Rate</label>
                                                         <select class="form-select" id="tax_type" name="tax_type">
            <option value="none">No Tax</option>
            <option value="gst_5">GST 5%</option>
            <option value="gst_12">GST 12%</option>
            <option value="gst_18" selected>GST 18%</option>
            <option value="gst_28">GST 28%</option>
            <option value="cgst_sgst">CGST 9% + SGST 9%</option>
            <option value="igst">IGST 18%</option>
        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-bottom mb-3">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h6 class="mb-3">Items & Details</h6>
                                            <div class="table-responsive rounded border-bottom-0 border mb-3">
                                                <table class="table table-nowrap add-table m-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Product/Service</th>
                                                            <th>Quantity</th>
                                                            <th>Unit</th>
                                                            <th>Rate</th>
                                                            <th>Discount (%)</th>
                                                            <th>Amount</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="add-tbody" id="invoice-items">
                                                        <tr>
                                                            <td>
                                                                <select name="items[0][item_name]" class="form-select item-select" required>
                                                                    <option value="">Select Product</option>
                                                                    @foreach($products as $product)
                                                                        <option value="{{ $product->name }}" data-price="{{ $product->variants->first()->selling_price ?? 0 }}">
                                                                            {{ $product->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="items[0][quantity]" class="form-control quantity-input" value="1" min="1" required>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="items[0][unit]" class="form-control" value="Pcs">
                                                            </td>
                                                            <td>
                                                                <input type="number" name="items[0][rate]" class="form-control rate-input" value="0.00" step="0.01" min="0" required>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="items[0][discount_percent]" class="form-control discount-input" value="0" min="0" max="100">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control amount-input" value="0.00" readonly>
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0);" class="text-danger remove-item">
                                                                    <i class="isax isax-close-circle"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <a href="#" class="d-inline-flex align-items-center add-item" id="add-item-btn">
                                                <i class="isax isax-add-circle5 text-primary me-1"></i>Add New
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border-bottom mb-3 pb-3">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <div class="mb-3">
                                                <label class="form-label">Notes</label>
                                                <textarea name="notes" class="form-control" rows="3" placeholder="Additional notes..."></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-5">
                                            <div class="mb-3">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <h6 class="fs-14 fw-semibold">Subtotal</h6>
                                                    <h6 class="fs-14 fw-semibold"><span id="subtotal-amount">0.00</span></h6>
                                                </div>
                                                
                                                <div id="tax-breakdown">
                                                    <!-- Tax rows will be added here -->
                                                </div>
                                                
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <h6 class="fs-14 fw-semibold">Total Tax</h6>
                                                    <h6 class="fs-14 fw-semibold"><span id="total-tax-amount">0.00</span></h6>
                                                </div>
                                                
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <h6 class="fs-14 fw-semibold">Shipping Cost</h6>
                                                    <input type="number" name="shipping_cost" class="form-control" value="0" step="0.01" min="0" style="width: 120px;" id="shipping-input">
                                                </div>
                                                
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <h6 class="fs-14 fw-semibold">Discount</h6>
                                                    <input type="number" name="discount_amount" class="form-control" value="0" step="0.01" min="0" style="width: 120px;" id="discount-input">
                                                </div>
                                                
                                                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                                    <div class="form-check form-switch me-4">
        {{-- ✅ Add hidden input before checkbox --}}
        <input type="hidden" name="round_off" value="0">
        <input class="form-check-input" type="checkbox" role="switch" id="round_off" name="round_off" value="1" checked>
        <label class="form-check-label" for="round_off">Round Off Total</label>
    </div>
    <h6 class="fs-14 fw-semibold"><span id="grand-total">0.00</span></h6>
                                                </div>
                                                
                                                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                                    <h6>Grand Total (INR)</h6>
                                                    <h6><span id="final-total">0.00</span></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between">
                                    <button type="button" class="btn btn-outline-white" onclick="window.location.href='{{ route('admin.invoices.index') }}'">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Invoice</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
     // ✅ Handle form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        // Set round_off value
        const roundOffCheckbox = document.getElementById('round_off');
        const roundOffInput = document.createElement('input');
        roundOffInput.type = 'hidden';
        roundOffInput.name = 'round_off';
        roundOffInput.value = roundOffCheckbox.checked ? '1' : '0';
        this.appendChild(roundOffInput);
        
        // Set enable_tax value
        const enableTaxCheckbox = document.getElementById('enable_tax');
        const enableTaxInput = document.createElement('input');
        enableTaxInput.type = 'hidden';
        enableTaxInput.name = 'enable_tax';
        enableTaxInput.value = enableTaxCheckbox.checked ? '1' : '0';
        this.appendChild(enableTaxInput);
    });
   
    let itemCount = 0;
    
    // Auto-fill price when product is selected
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('item-select')) {
            const price = e.target.options[e.target.selectedIndex].getAttribute('data-price');
            if (price) {
                const row = e.target.closest('tr');
                row.querySelector('.rate-input').value = parseFloat(price).toFixed(2);
                calculateRow(row);
                calculateTotals();
            }
        }
    });
    
    // Calculate on input change
    document.addEventListener('input', function(e) {
        const row = e.target.closest('tr');
        if (row && (e.target.classList.contains('quantity-input') || 
                   e.target.classList.contains('rate-input') || 
                   e.target.classList.contains('discount-input'))) {
            calculateRow(row);
            calculateTotals();
        }
        
        // Recalculate on shipping/discount change
        if (e.target.id === 'shipping-input' || e.target.id === 'discount-input') {
            calculateTotals();
        }
    });
    
    // Calculate single row
    function calculateRow(row) {
        const qty = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const rate = parseFloat(row.querySelector('.rate-input').value) || 0;
        const discount = parseFloat(row.querySelector('.discount-input').value) || 0;
        
        let amount = qty * rate;
        
        if (discount > 0) {
            amount = amount - (amount * discount / 100);
        }
        
        row.querySelector('.amount-input').value = amount.toFixed(2);
    }
    
    // Calculate all totals
    function calculateTotals() {
        // Calculate subtotal
        let subtotal = 0;
        document.querySelectorAll('.amount-input').forEach(input => {
            subtotal += parseFloat(input.value) || 0;
        });
        
        document.getElementById('subtotal-amount').textContent = subtotal.toFixed(2);
        
        // Calculate tax based on selected tax type
        const taxType = document.getElementById('tax_type').value;
        let totalTax = 0;
        const taxBreakdown = document.getElementById('tax-breakdown');
        taxBreakdown.innerHTML = '';
        
        if (taxType !== 'none') {
            switch(taxType) {
                case 'gst_5':
                    totalTax = (subtotal * 5) / 100;
                    addTaxRow('GST 5%', totalTax);
                    break;
                case 'gst_12':
                    totalTax = (subtotal * 12) / 100;
                    addTaxRow('GST 12%', totalTax);
                    break;
                case 'gst_18':
                    totalTax = (subtotal * 18) / 100;
                    addTaxRow('GST 18%', totalTax);
                    break;
                case 'gst_28':
                    totalTax = (subtotal * 28) / 100;
                    addTaxRow('GST 28%', totalTax);
                    break;
                case 'cgst_sgst':
                    const cgst = (subtotal * 9) / 100;
                    const sgst = (subtotal * 9) / 100;
                    totalTax = cgst + sgst;
                    addTaxRow('CGST 9%', cgst);
                    addTaxRow('SGST 9%', sgst);
                    break;
                case 'igst':
                    totalTax = (subtotal * 18) / 100;
                    addTaxRow('IGST 18%', totalTax);
                    break;
            }
        }
        
        document.getElementById('total-tax-amount').textContent = totalTax.toFixed(2);
        
        // Get shipping and discount
        const shipping = parseFloat(document.getElementById('shipping-input').value) || 0;
        const discount = parseFloat(document.getElementById('discount-input').value) || 0;
        
        // Calculate grand total
        let grandTotal = subtotal + totalTax + shipping - discount;
        
        // Round off if needed
        const roundOff = document.getElementById('round_off').checked;
        if (roundOff) {
            grandTotal = Math.round(grandTotal);
        }
        
        document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
        document.getElementById('final-total').textContent = grandTotal.toFixed(2);
    }
    
    // Add tax row to breakdown
    function addTaxRow(name, amount) {
        const taxBreakdown = document.getElementById('tax-breakdown');
        const row = document.createElement('div');
        row.className = 'd-flex align-items-center justify-content-between mb-2';
        row.innerHTML = `<span>${name}</span><strong>₹${amount.toFixed(2)}</strong>`;
        taxBreakdown.appendChild(row);
    }
    
    // Add new item row
    document.getElementById('add-item-btn').addEventListener('click', function(e) {
        e.preventDefault();
        itemCount++;
        
        const newRow = `
            <tr>
                <td>
                    <select name="items[${itemCount}][item_name]" class="select item-select" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->name }}" data-price="{{ $product->variants->first()->selling_price ?? 0 }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="items[${itemCount}][quantity]" class="form-control quantity-input" value="1" min="1" required>
                </td>
                <td>
                    <input type="text" name="items[${itemCount}][unit]" class="form-control" value="Pcs">
                </td>
                <td>
                    <input type="number" name="items[${itemCount}][rate]" class="form-control rate-input" value="0.00" step="0.01" min="0" required>
                </td>
                <td>
                    <input type="number" name="items[${itemCount}][discount_percent]" class="form-control discount-input" value="0" min="0" max="100">
                </td>
                <td>
                    <input type="text" class="form-control amount-input" value="0.00" readonly>
                </td>
                <td>
                    <a href="javascript:void(0);" class="text-danger remove-item">
                        <i class="isax isax-close-circle"></i>
                    </a>
                </td>
            </tr>
        `;
        
        document.getElementById('invoice-items').insertAdjacentHTML('beforeend', newRow);
    });
    
    // Remove item row
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item')) {
            const row = e.target.closest('tr');
            const rowCount = document.querySelectorAll('#invoice-items tr').length;
            
            if (rowCount > 1) {
                row.remove();
                calculateTotals();
            } else {
                alert('At least one item is required');
            }
        }
    });
    
    // Initialize calculations
    calculateTotals();
});
</script>
@endpush