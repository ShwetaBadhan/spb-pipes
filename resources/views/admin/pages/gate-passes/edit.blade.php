@extends('admin.layout.master')
@section("title","Edit Gate Pass")
@section("content")
<div class="page-wrapper">
  <div class="content content-two">
    <!-- Page Header -->
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
      <div>
        <h6>Edit Gate Pass Details</h6>
      </div>
      <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
        <div>
          <a href="{{ route('admin.gate-passes.index') }}" class="btn btn-primary d-flex align-items-center">
            <i class="isax isax-arrow-left me-1"></i>Back
          </a>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-12">
        <div class="card">
          <form action="{{ route('admin.gate-passes.update', $gatePass->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
              @if($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <!-- Customer & Invoice -->
              <!-- Customer & Invoice -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="form-group">
            <label>Customer <span class="text-danger">*</span></label>
            <select name="customer_id" id="customer-select" class="form-select" required>
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" 
                            {{ old('customer_id', $gatePass->customer_id) == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                        
                    </option>
                @endforeach
            </select>
            @error('customer_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Linked Invoice</label>
            <select name="invoice_id" id="invoice-select" class="form-select">
                <option value="">Select Invoice</option>
                @foreach($customerInvoices as $invoice)
                    <option value="{{ $invoice->id }}" 
                            {{ old('invoice_id', $gatePass->invoice_id) == $invoice->id ? 'selected' : '' }}>
                        {{ $invoice->invoice_number }} - ₹{{ $invoice->grand_total }} ({{ $invoice->status }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

              <!-- Type & Batch -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="form-group">
            <label>Type <span class="text-danger">*</span></label><br>
            <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                <option value="" disabled>Select Type</option>
                <option value="inward" {{ old('type', $gatePass->type) == 'inward' ? 'selected' : '' }}>Inward</option>
                <option value="outward" {{ old('type', $gatePass->type) == 'outward' ? 'selected' : '' }}>Outward</option>
            </select>
            @error('type')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="batch_number">Batch Number (Vehicle ID) <span class="text-danger">*</span></label>
            <input type="text" name="batch_number" id="batch_number" 
                   class="form-control @error('batch_number') is-invalid @enderror"
                   value="{{ old('batch_number', $gatePass->batch_number) }}" required>
            @error('batch_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="form-group">
            <label for="date">Date <span class="text-danger">*</span></label>
            <input type="date" name="date" id="date" 
                   class="form-control @error('date') is-invalid @enderror"
                   value="{{ old('date', $gatePass->date->format('Y-m-d')) }}" required>
            @error('date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
              <!-- Products Table -->
              <div class="form-group">
                <label>Products & Labor Details <span class="text-danger">*</span></label>
                <div id="products-container">
                  <!-- Will be filled dynamically -->
                </div>
                <button type="button" class="btn btn-success mt-2" id="add-product-btn">
                  <i class="fas fa-plus"></i> Add Product
                </button>
              </div>

              <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea name="remarks" id="remarks" class="form-control" 
                          rows="3">{{ old('remarks', $gatePass->remarks) }}</textarea>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Gate Pass
              </button>
              <a href="{{ route('admin.gate-passes.show', $gatePass->batch_number) }}" class="btn btn-secondary">
                Cancel
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
// ✅ ALL DATA PRELOADED FROM CONTROLLER - NO AJAX!
const products = @json($products);
const laborTypes = @json($laborTypes);
const customerInvoicesData = @json($customerInvoicesData);
const gatePass = @json($gatePass);
let productCounter = 0;

// Add product row
function addProductRow(productData = null) {
  const container = document.getElementById('products-container');
  const index = productCounter++;

  const productSelect = products.map(p => 
    `<option value="${p.id}" ${productData?.product_id == p.id ? 'selected' : ''}>${p.name}</option>`
  ).join('');

  const laborSelect = laborTypes.map(l => 
    `<option value="${l.id}" ${productData?.labor_type_id == l.id ? 'selected' : ''}>${l.name}</option>`
  ).join('');

  const html = `
    <div class="product-row card mb-3" id="product-row-${index}">
      <div class="card-header bg-light">
        <h6 class="mb-0">Product #${index + 1}</h6>
        ${index > 0 ? '<button type="button" class="btn btn-danger btn-sm float-right remove-btn" data-index="' + index + '"><i class="fas fa-trash"></i></button>' : ''}
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>Product <span class="text-danger">*</span></label>
              <select name="products[${index}][product_id]" class="form-control product-select" required>
                <option value="">Select Product</option>
                ${productSelect}
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Quantity <span class="text-danger">*</span></label>
              <input type="number" name="products[${index}][quantity]" class="form-control" 
                     min="0.01" step="0.01" value="${productData?.quantity || 1}" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Labor Type <span class="text-danger">*</span></label>
              <select name="products[${index}][labor_type_id]" class="form-control labor-type-select" required>
                <option value="">Select Labor Type</option>
                ${laborSelect}
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Load / Unload Quantity <span class="text-danger">*</span></label>
              <input type="number" name="products[${index}][workers_count]" class="form-control workers-count" 
                     min="1" value="${productData?.workers_count || 1}" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Rate per Worker</label>
              <input type="text" class="form-control rate-amount" readonly value="0.00">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Total Cost</label>
              <input type="text" class="form-control total-cost" readonly value="0.00">
            </div>
          </div>
        </div>
      </div>
    </div>
  `;

  container.insertAdjacentHTML('beforeend', html);
  attachEvents(index, productData);
}

// Attach events to row
function attachEvents(index, productData = null) {
  const row = document.getElementById(`product-row-${index}`);
  
  // Set labor type if provided
  if (productData?.labor_type_id) {
    const laborSelect = row.querySelector('.labor-type-select');
    laborSelect.value = productData.labor_type_id;
    
    // Get labor rate from preloaded data
    const labor = laborTypes.find(l => l.id == productData.labor_type_id);
    if (labor) {
      row.querySelector('.rate-amount').value = parseFloat(labor.rate_amount || 0).toFixed(2);
      calculateTotal(index);
    }
  }
  
  row.querySelector('.labor-type-select').addEventListener('change', function() {
    const laborId = this.value;
    if (!laborId) return;

    // ✅ NO AJAX - Get rate from preloaded data
    const labor = laborTypes.find(l => l.id == laborId);
    if (labor) {
      row.querySelector('.rate-amount').value = parseFloat(labor.rate_amount || 0).toFixed(2);
      calculateTotal(index);
    } else {
      row.querySelector('.rate-amount').value = '0.00';
      row.querySelector('.total-cost').value = '0.00';
    }
  });

  row.querySelector('.workers-count').addEventListener('input', () => calculateTotal(index));
}

// Calculate total cost
function calculateTotal(index) {
  const row = document.getElementById(`product-row-${index}`);
  const rate = parseFloat(row.querySelector('.rate-amount').value) || 0;
  const workers = parseInt(row.querySelector('.workers-count').value) || 0;
  row.querySelector('.total-cost').value = (rate * workers).toFixed(2);
}

// Remove product row
document.addEventListener('click', function(e) {
  if (e.target.closest('.remove-btn')) {
    const index = e.target.closest('.remove-btn').dataset.index;
    document.getElementById(`product-row-${index}`).remove();
  }
});

// Load invoices when customer changes (NO AJAX!)
function loadInvoicesForCustomer(customerId) {
  const invoiceSelect = document.getElementById('invoice-select');
  invoiceSelect.innerHTML = '<option value="">Select Invoice</option>';
  invoiceSelect.disabled = !customerId;

  if (customerId && customerInvoicesData[customerId]) {
    Object.entries(customerInvoicesData[customerId]).forEach(([invoiceId, invoice]) => {
      const opt = document.createElement('option');
      opt.value = invoiceId;
      opt.textContent = `${invoice.invoice_number} - ₹${invoice.grand_total} (${invoice.status})`;
      invoiceSelect.appendChild(opt);
    });
  }
}

document.getElementById('customer-select').addEventListener('change', function() {
  const customerId = this.value;
  loadInvoicesForCustomer(customerId);
  
  // Clear products when customer changes
  document.getElementById('products-container').innerHTML = '';
  productCounter = 0;
  addProductRow();
});

// Auto-fill products from invoice (NO AJAX!)
document.getElementById('invoice-select').addEventListener('change', function() {
  const invoiceId = this.value;
  const customerId = document.getElementById('customer-select').value;
  const container = document.getElementById('products-container');
  container.innerHTML = '';
  productCounter = 0;

  if (invoiceId && customerId && customerInvoicesData[customerId]?.[invoiceId]) {
    const invoice = customerInvoicesData[customerId][invoiceId];
    if (invoice.items && invoice.items.length > 0) {
      invoice.items.forEach(item => addProductRow(item));
    } else {
      addProductRow();
    }
  } else {
    addProductRow();
  }
});

// Add product button
document.getElementById('add-product-btn').addEventListener('click', () => addProductRow());

// Initialize with existing gate pass data
document.addEventListener('DOMContentLoaded', function() {
  // Add product row with gate pass data
  addProductRow({
    product_id: gatePass.product_id,
    quantity: gatePass.quantity,
    labor_type_id: gatePass.labor_type_id,
    workers_count: gatePass.workers_count
  });
});
</script>
@endpush