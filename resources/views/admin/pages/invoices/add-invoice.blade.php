@extends('admin.layout.master')
@section('title', 'Add Invoice')
@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-md-11 mx-auto">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Validation Errors:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6><a href="{{ route('admin.invoices.index') }}"><i
                                        class="isax isax-arrow-left me-2"></i>Invoice</a></h6>
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
                                                            <input type="text" class="form-control"
                                                                placeholder="Auto-generated" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Reference Number</label>
                                                            <input type="text" name="reference_number"
                                                                class="form-control" placeholder="Optional">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="input-group position-relative mb-3">
                                                            <input type="date" name="invoice_date" class="form-control"
                                                                value="{{ now()->format('Y-m-d') }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="input-group position-relative mb-3">
                                                            <input type="date" name="due_date" class="form-control"
                                                                value="{{ now()->addDays(7)->format('Y-m-d') }}" required>
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
                                                                @foreach ($customers as $customer)
                                                                    <option value="{{ $customer->id }}">
                                                                        {{ $customer->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Status</label>
                                                            <select name="status" class="select" required>
                                                                <option value="draft">Draft</option>
                                                                <option value="sent">Sent</option>
                                                                <option value="unpaid" selected>Unpaid</option>
                                                                <option value="paid">Paid</option>
                                                                <option value="cancelled">Cancelled</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between border rounded p-2 mb-3">
                                                            <div class="form-check form-switch me-4">
                                                                <input type="hidden" name="enable_tax" value="0">
                                                                <input class="form-check-input" type="checkbox"
                                                                    role="switch" id="enable_tax" name="enable_tax"
                                                                    value="1" checked>
                                                                <label class="form-check-label" for="enable_tax">Enable
                                                                    Tax</label>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Tax Rate</label>
                                                            <select class="form-select" id="tax_type" name="tax_type"
                                                                required>
                                                                <option value="none" selected>None</option>
                                                                <option value="gst_5">GST 5%</option>
                                                                <option value="gst_12">GST 12%</option>
                                                                <option value="gst_18">GST 18%</option>
                                                                <option value="gst_28">GST 28%</option>
                                                                <option value="cgst_sgst">CGST 9% + SGST 9%</option>
                                                                <option value="igst">IGST 18%</option>
                                                            </select>
                                                            <!-- ✅ ADD THIS HIDDEN INPUT -->
                                                            <input type="hidden" id="tax_type_hidden" name="tax_type"
                                                                value="none">
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
                                                                    <select name="items[0][item_name]"
                                                                        class="form-select item-select" required>
                                                                        <option value="">Select Product</option>
                                                                        @foreach ($products as $product)
                                                                            <option value="{{ $product->name }}"
                                                                                data-price="{{ $product->variants->first()->selling_price ?? 0 }}">
                                                                                {{ $product->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="items[0][quantity]"
                                                                        class="form-control quantity-input" value="1"
                                                                        min="1" required>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="items[0][unit]"
                                                                        class="form-control" value="Pcs">
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="items[0][rate]"
                                                                        class="form-control rate-input" value="0.00"
                                                                        step="0.01" min="0" required>
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        name="items[0][discount_percent]"
                                                                        class="form-control discount-input" value="0"
                                                                        min="0" max="100">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        class="form-control amount-input" value="0.00"
                                                                        readonly>
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0);"
                                                                        class="text-danger remove-item">
                                                                        <i class="isax isax-close-circle"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <a href="#" class="d-inline-flex align-items-center add-item"
                                                    id="add-item-btn">
                                                    <i class="isax isax-add-circle5 text-primary me-1"></i>Add New Item
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
                                                        <h6 class="fs-14 fw-semibold">₹<span
                                                                id="subtotal-amount">0.00</span></h6>
                                                    </div>

                                                    <div id="tax-breakdown">
                                                        <!-- Tax rows will be added here -->
                                                    </div>

                                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                                        <h6 class="fs-14 fw-semibold">Total Tax</h6>
                                                        <h6 class="fs-14 fw-semibold">₹<span
                                                                id="total-tax-amount">0.00</span></h6>
                                                    </div>

                                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                                        <h6 class="fs-14 fw-semibold">Shipping Cost</h6>
                                                        <input type="number" name="shipping_cost" class="form-control"
                                                            value="0" step="0.01" min="0"
                                                            style="width: 120px;" id="shipping-input">
                                                    </div>

                                                    <!-- ✅ FIXED: Discount Section -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Discount</label>
                                                        <div class="d-flex gap-3 mb-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="discount_type" id="discount_percent"
                                                                    value="percent" checked>
                                                                <label class="form-check-label"
                                                                    for="discount_percent">Percentage (%)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="discount_type" id="discount_amount"
                                                                    value="amount">
                                                                <label class="form-check-label"
                                                                    for="discount_amount">Amount (₹)</label>
                                                            </div>
                                                        </div>

                                                        <div id="discount-percent-section">
                                                            <input type="number" name="discount_percent"
                                                                class="form-control" value="0" step="0.01"
                                                                min="0" max="100"
                                                                id="discount-percent-input">
                                                            <small class="text-muted">Enter discount percentage
                                                                (0-100%)</small>
                                                        </div>

                                                        <div id="discount-amount-section" style="display: none;">
                                                            <input type="number" name="discount_amount"
                                                                class="form-control" value="0" step="0.01"
                                                                min="0" id="discount-amount-input">
                                                            <small class="text-muted">Enter discount amount in
                                                                rupees</small>
                                                        </div>
                                                    </div>
                                                    <!-- ✅ END Discount Section -->

                                                    <div
                                                        class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                                        <div class="form-check form-switch me-4">
                                                            <input type="hidden" name="round_off" value="0">
                                                            <input class="form-check-input" type="checkbox"
                                                                role="switch" id="round_off" name="round_off"
                                                                value="1">
                                                            <label class="form-check-label" for="round_off">Round Off
                                                                Total</label>
                                                        </div>
                                                        <h6 class="fs-14 fw-semibold">₹<span id="grand-total">0.00</span>
                                                        </h6>
                                                    </div>

                                                    <div
                                                        class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                                        <h6>Grand Total (INR)</h6>
                                                        <h6><strong>₹<span id="final-total">0.00</span></strong></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <button type="button" class="btn btn-outline-white"
                                            onclick="window.location.href='{{ route('admin.invoices.index') }}'">Cancel</button>
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
            // Form submission handler
            document.querySelector('form').addEventListener('submit', function(e) {
                ['round_off', 'enable_tax'].forEach(field => {
                    const checkbox = document.getElementById(field);
                    let hiddenInput = this.querySelector(`input[name="${field}"][type="hidden"]`);
                    if (!hiddenInput) {
                        hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = field;
                        this.appendChild(hiddenInput);
                    }
                    hiddenInput.value = checkbox.checked ? '1' : '0';
                });
            });

            // Tax toggle
            document.getElementById('enable_tax').addEventListener('change', function() {
                const taxTypeSelect = document.getElementById('tax_type');
                const taxTypeHidden = document.getElementById('tax_type_hidden');

                if (!this.checked) {
                    taxTypeSelect.value = 'none';
                    taxTypeSelect.disabled = true;
                } else {
                    taxTypeSelect.disabled = false;
                    if (taxTypeSelect.value === 'none') taxTypeSelect.value = 'gst_18';
                }

                // ✅ Sync hidden input
                taxTypeHidden.value = taxTypeSelect.value;
                calculateTotals();
            });


            // ✅ CRITICAL FIX: Tax type change listener
            document.getElementById('tax_type').addEventListener('change', function() {
                document.getElementById('tax_type_hidden').value = this.value;
                calculateTotals();
            });
            // Auto-fill price when product selected
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

            // Input change handler
            document.addEventListener('input', function(e) {
                const row = e.target.closest('tr');
                if (row && ['quantity-input', 'rate-input', 'discount-input'].some(cls => e.target.classList
                        .contains(cls))) {
                    calculateRow(row);
                    calculateTotals();
                }
                // ✅ CRITICAL FIX #2: Include BOTH discount inputs
                if (['shipping-input', 'discount-percent-input', 'discount-amount-input'].includes(e.target
                        .id)) {
                    calculateTotals();
                }
            });

            // Calculate single row
            function calculateRow(row) {
                const qty = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const rate = parseFloat(row.querySelector('.rate-input').value) || 0;
                const discount = parseFloat(row.querySelector('.discount-input').value) || 0;
                let amount = qty * rate;
                if (discount > 0) amount -= (amount * discount / 100);
                row.querySelector('.amount-input').value = amount.toFixed(2);
            }

            // Calculate all totals
            function calculateTotals() {
                // Subtotal
                let subtotal = 0;
                document.querySelectorAll('.amount-input').forEach(input => {
                    subtotal += parseFloat(input.value) || 0;
                });
                document.getElementById('subtotal-amount').textContent = subtotal.toFixed(2);

                // Tax calculation
                const enableTax = document.getElementById('enable_tax').checked;
                const taxType = document.getElementById('tax_type').value;
                let totalTax = 0;
                const taxBreakdown = document.getElementById('tax-breakdown');
                taxBreakdown.innerHTML = '';

                if (enableTax && taxType !== 'none') {
                    switch (taxType) {
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

                // ✅ Discount calculation (FIXED)
                let discount = 0;
                const discountType = document.querySelector('input[name="discount_type"]:checked').value;

                if (discountType === 'percent') {
                    const discountPercent = parseFloat(document.getElementById('discount-percent-input').value) ||
                    0;
                    discount = (subtotal * discountPercent) / 100;
                } else {
                    discount = parseFloat(document.getElementById('discount-amount-input').value) || 0;
                }

                // Grand Total
                const shipping = parseFloat(document.getElementById('shipping-input').value) || 0;
                let grandTotal = subtotal + totalTax + shipping - discount;

                if (document.getElementById('round_off').checked) {
                    grandTotal = Math.round(grandTotal);
                }

                document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
                document.getElementById('final-total').textContent = grandTotal.toFixed(2);
            }

            // Add tax row
            function addTaxRow(name, amount) {
                const row = document.createElement('div');
                row.className = 'd-flex align-items-center justify-content-between mb-2';
                row.innerHTML = `<span>${name}</span><strong>₹${amount.toFixed(2)}</strong>`;
                document.getElementById('tax-breakdown').appendChild(row);
            }

            // ✅ CRITICAL FIX #3: Discount toggle handlers (WORKING VERSION)
            document.getElementById('discount_percent').addEventListener('click', function() {
                document.getElementById('discount-percent-section').style.display = 'block';
                document.getElementById('discount-amount-section').style.display = 'none';
                document.getElementById('discount-amount-input').value = '0'; // Reset other field
                calculateTotals();
            });

            document.getElementById('discount_amount').addEventListener('click', function() {
                document.getElementById('discount-percent-section').style.display = 'none';
                document.getElementById('discount-amount-section').style.display = 'block';
                document.getElementById('discount-percent-input').value = '0'; // Reset other field
                calculateTotals();
            });

            // Add item row
            document.getElementById('add-item-btn').addEventListener('click', function(e) {
                e.preventDefault();
                const itemCount = document.querySelectorAll('#invoice-items tr').length;
                const firstSelect = document.querySelector('.item-select');
                const productOptions = firstSelect.innerHTML;

                const newRow = `
        <tr>
            <td>
                <select name="items[${itemCount}][item_name]" class="form-select item-select" required>
                    ${productOptions}
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
        </tr>`;

                document.getElementById('invoice-items').insertAdjacentHTML('beforeend', newRow);
                calculateTotals();
            });

            // Remove item row
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-item')) {
                    const row = e.target.closest('tr');
                    if (document.querySelectorAll('#invoice-items tr').length > 1) {
                        row.remove();
                        calculateTotals();
                    } else {
                        alert('At least one item is required');
                    }
                }
            });

            // ✅ CRITICAL FIX #4: Initialize discount sections visibility
            if (document.getElementById('discount_percent').checked) {
                document.getElementById('discount-percent-section').style.display = 'block';
                document.getElementById('discount-amount-section').style.display = 'none';
            } else {
                document.getElementById('discount-percent-section').style.display = 'none';
                document.getElementById('discount-amount-section').style.display = 'block';
            }

            // Initialize calculations
            calculateTotals();
        });
    </script>
@endpush
