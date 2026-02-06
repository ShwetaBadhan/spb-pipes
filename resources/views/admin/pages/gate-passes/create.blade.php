@extends('admin.layout.master')
@section('title', 'Create Gate Pass')
@section('content')

    <!-- ========================
       Start Page Content
      ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">
  <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Gate Pass</h3>
                    
                </div>
                <form action="{{ route('admin.gate-passes.store') }}" method="POST">
                    @csrf
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

                        <!-- Vehicle Details -->
                        
<!-- Type Selection -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="form-group">
            <label>Type <span class="text-danger">*</span></label><br>
            <select name="type" class="select">
            <option value="" disabled>Select Type</option>
            <option value="inward">Inward</option>
            <option value="outward">Outward</option>
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
                   value="{{ old('batch_number') }}" placeholder="e.g., VH-101">
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
                   value="{{ old('date', date('Y-m-d')) }}">
            @error('date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<hr>
                        <!-- Products Table -->
                        <div class="form-group">
                            <label>Products & Labor Details <span class="text-danger">*</span></label>
                            <div id="products-container">
                                <!-- Product rows will be added here dynamically -->
                            </div>
                            <button type="button" class="btn btn-success mt-2" onclick="addProductRow()">
                                <i class="fas fa-plus"></i> Add Product
                            </button>
                        </div>

                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea name="remarks" id="remarks" class="form-control" 
                                      rows="3" placeholder="Any additional notes...">{{ old('remarks') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Gate Pass
                        </button>
                        <a href="{{ route('admin.gate-passes.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
        </div>

    </div>
    <!-- End Content -->





@endsection
@push('scripts')
<script>
let productCounter = 0;

function addProductRow() {
    const container = document.getElementById('products-container');
    const newRow = document.createElement('div');
    newRow.className = 'product-row card mb-3';
    newRow.id = 'product-row-' + productCounter;
    newRow.innerHTML = `
        <div class="card-header bg-light">
            <h6 class="mb-0">Product #${productCounter + 1}</h6>
            ${productCounter > 0 ? '<button type="button" class="btn btn-danger btn-sm float-right" onclick="removeProductRow(' + productCounter + ')"><i class="fas fa-trash"></i></button>' : ''}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Product <span class="text-danger">*</span></label>
                        <select name="products[${productCounter}][product_id]" class="form-control product-select" required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="products[${productCounter}][quantity]" class="form-control" 
                               min="1" value="1" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Labor Type <span class="text-danger">*</span></label>
                        <select name="products[${productCounter}][labor_type_id]" class="form-control labor-type-select" required>
                            <option value="">Select Labor Type</option>
                            @foreach($laborTypes as $labor)
                                <option value="{{ $labor->id }}">{{ $labor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Workers <span class="text-danger">*</span></label>
                        <input type="number" name="products[${productCounter}][workers_count]" class="form-control workers-count" 
                               min="1" value="1" required>
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
    `;
    container.appendChild(newRow);
    productCounter++;

    initializeRowEvents(newRow, productCounter - 1);
}

function removeProductRow(index) {
    document.getElementById('product-row-' + index).remove();
}

function initializeRowEvents(row, index) {
    const laborSelect = row.querySelector('.labor-type-select');
    const workersInput = row.querySelector('.workers-count');
    const rateDisplay = row.querySelector('.rate-amount');
    const totalDisplay = row.querySelector('.total-cost');

    laborSelect.addEventListener('change', function() {
        const laborId = this.value;
        if (laborId) {
            // SIMPLE AJAX CALL - Direct URL
            fetch("/gate-passes/labor-rate/" + laborId)
                .then(response => response.json())
                .then(data => {
                    rateDisplay.value = parseFloat(data.rate_amount).toFixed(2);
                    calculateTotal(index);
                })
                .catch(error => {
                    console.error('Error:', error);
                    rateDisplay.value = '0.00';
                    totalDisplay.value = '0.00';
                });
        } else {
            rateDisplay.value = '0.00';
            totalDisplay.value = '0.00';
        }
    });

    workersInput.addEventListener('input', function() {
        calculateTotal(index);
    });
}

function calculateTotal(index) {
    const row = document.getElementById('product-row-' + index);
    const rate = parseFloat(row.querySelector('.rate-amount').value) || 0;
    const workers = parseInt(row.querySelector('.workers-count').value) || 0;
    const total = rate * workers;
    row.querySelector('.total-cost').value = total.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    addProductRow();
});
</script>
@endpush