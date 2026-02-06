@extends('admin.layout.master')
@section("title","Edit")
@section("content")
<div class="page-wrapper">
  <!-- Start Content -->
        <div class="content content-two">
         <!-- Page Header -->
            <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <h6>Edit Gate Pass Details</h6>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div>
                        <a href="{{ route('admin.gate-passes.index') }}" class="btn btn-primary d-flex align-items-center"><i
                                class="isax isax-arrow-left me-1"></i>Back</a>
                    </div>
                </div>
            </div>
            {{-- end page header --}}
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

                        <div class="row">
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
                                    <label for="batch_number">Batch Number <span class="text-danger">*</span></label>
                                    <input type="text" name="batch_number" id="batch_number" 
                                           class="form-control @error('batch_number') is-invalid @enderror"
                                           value="{{ old('batch_number', $gatePass->batch_number) }}" readonly>
                                    @error('batch_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" id="date" 
                                           class="form-control @error('date') is-invalid @enderror"
                                           value="{{ old('date', $gatePass->date->format('Y-m-d')) }}">
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_id">Product <span class="text-danger">*</span></label>
                                    <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ old('product_id', $gatePass->product_id) == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" id="quantity" 
                                           class="form-control @error('quantity') is-invalid @enderror"
                                           value="{{ old('quantity', $gatePass->quantity) }}" min="1" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="labor_type_id">Labor Type <span class="text-danger">*</span></label>
                                    <select name="labor_type_id" id="labor_type_id" class="form-control @error('labor_type_id') is-invalid @enderror" required>
                                        <option value="">Select Labor Type</option>
                                        @foreach($laborTypes as $labor)
                                            <option value="{{ $labor->id }}" 
                                                    {{ old('labor_type_id', $gatePass->labor_type_id) == $labor->id ? 'selected' : '' }}
                                                    data-rate="{{ $labor->rate_amount }}">
                                                {{ $labor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('labor_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="workers_count">Workers Count <span class="text-danger">*</span></label>
                                    <input type="number" name="workers_count" id="workers_count" 
                                           class="form-control @error('workers_count') is-invalid @enderror"
                                           value="{{ old('workers_count', $gatePass->workers_count) }}" min="1" required>
                                    @error('workers_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Rate per Worker (₹)</label>
                                    <input type="text" id="rate_display" class="form-control" 
                                           value="{{ number_format($gatePass->rate_amount, 2) }}" readonly>
                                    <input type="hidden" id="rate_amount" name="rate_amount" 
                                           value="{{ old('rate_amount', $gatePass->rate_amount) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Total Cost (₹)</label>
                                    <input type="text" id="total_cost_display" class="form-control" 
                                           value="{{ number_format($gatePass->total_cost, 2) }}" readonly>
                                    <input type="hidden" id="total_cost" name="total_cost" 
                                           value="{{ old('total_cost', $gatePass->total_cost) }}">
                                </div>
                            </div>
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
document.addEventListener('DOMContentLoaded', function() {
    const laborTypeSelect = document.getElementById('labor_type_id');
    const workersInput = document.getElementById('workers_count');
    const rateDisplay = document.getElementById('rate_display');
    const rateHidden = document.getElementById('rate_amount');
    const totalDisplay = document.getElementById('total_cost_display');
    const totalHidden = document.getElementById('total_cost');

    // Initialize with current values
    let currentRate = parseFloat('{{ $gatePass->rate_amount }}');
    let currentWorkers = parseInt('{{ $gatePass->workers_count }}');
    let currentTotal = currentRate * currentWorkers;

    // Update displays
    rateDisplay.value = currentRate.toFixed(2);
    rateHidden.value = currentRate.toFixed(2);
    totalDisplay.value = currentTotal.toFixed(2);
    totalHidden.value = currentTotal.toFixed(2);

    // When labor type changes
    laborTypeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const newRate = parseFloat(selectedOption.getAttribute('data-rate')) || 0;
        
        currentRate = newRate;
        rateDisplay.value = currentRate.toFixed(2);
        rateHidden.value = currentRate.toFixed(2);
        
        calculateTotal();
    });

    // When workers count changes
    workersInput.addEventListener('input', function() {
        currentWorkers = parseInt(this.value) || 0;
        calculateTotal();
    });

    // Calculate total cost
    function calculateTotal() {
        const total = currentRate * currentWorkers;
        totalDisplay.value = total.toFixed(2);
        totalHidden.value = total.toFixed(2);
    }
});
</script>
@endpush
