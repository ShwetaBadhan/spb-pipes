@extends("admin.layout.master")
@section("title","Labor Cost Assignment")
@section("content")

<div class="page-wrapper">
    <div class="content content-two">
        <!-- Page Header -->
        <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
            <div>
                <h6>Labor Cost Assignments</h6>
                <p class="text-muted mb-0">Track labor costs for production and logistics</p>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <div class="input-group mb-3" style="max-width: 300px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="isax isax-search-normal fs-12"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0 ps-0 bg-white" 
                           placeholder="Search..." value="{{ request('search') }}">
                </div>
                <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#add_modal">
                    <i class="isax isax-add-circle5 me-1"></i>Assign Labor Cost
                </a>
            </div>
        </div>

     

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 3000,
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
                    timer: 5000,
                    timerProgressBar: true,
                    showConfirmButton: true
                });
            </script>
        @endif

        <!-- Table -->
        <div class="table-responsive border border-bottom-0 rounded">
            <table class="table table-nowrap m-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Labor Type</th>
                        <th>Product</th>
                        <th>Batch</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Total Cost</th>
                        <th>Supervisor</th>
                        <th>Workers</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignments as $assignment)
                        <tr>
                            <td>{{ $assignment->date->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $assignment->laborType->category == 'production' ? 'success' : 'primary' }}">
                                    {{ ucfirst($assignment->laborType->category) }}
                                </span>
                                <br>{{ $assignment->laborType->name }}
                            </td>
                            <td>{{ $assignment->product->name ?? 'N/A' }}</td>
                            <td>
                                @if($assignment->batch_number)
                                    <span class="badge bg-info">{{ $assignment->batch_number }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ number_format($assignment->quantity, 2) }}</td>
                            <td>₹{{ number_format($assignment->rate_amount, 2) }}</td>
                            <td><strong>₹{{ number_format($assignment->total_cost, 2) }}</strong></td>
                            <td>{{ $assignment->supervisor->name ?? '-' }}</td>
                            <td>{{ $assignment->workers_count }}</td>
                            <td class="action-item">
                               
                                   <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <i class="isax isax-more"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <a class="dropdown-item" href="#" 
                                           data-bs-toggle="modal" 
                                           data-bs-target="#edit_modal"
                                           onclick="editAssignment({{ $assignment->id }})">
                                            <i class="isax isax-edit me-2"></i>Edit
                                        </a>
                                        <a class="dropdown-item text-danger" href="#" 
                                           onclick="deleteAssignment({{ $assignment->id }})">
                                            <i class="isax isax-trash me-2"></i>Delete
                                        </a>
                                    </ul>
                                
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="isax isax-empty-wallet display-4 d-block mb-3"></i>
                                    <p class="mb-0">No labor cost assignments found</p>
                                    <small class="d-block mt-2">Click "Assign Labor Cost" to create your first assignment</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Showing {{ $assignments->firstItem() }} to {{ $assignments->lastItem() }} of {{ $assignments->total() }} entries
            </div>
            <div>
                {{ $assignments->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div id="add_modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Assign Labor Cost</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('labor-cost-assignments.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Date *</label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Labor Type *</label>
                                <select name="labor_type_id" id="add_labor_type_id" class="form-select" required>
                                    <option value="">-- Select Labor Type --</option>
                                    @foreach($laborTypes as $type)
                                        <option value="{{ $type->id }}"
                                                data-rate="{{ $type->rate_amount }}">
                                            {{ $type->name }} (₹{{ $type->rate_amount }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Product *</label>
                                <select name="product_id" class="form-select" required>
                                    <option value="">-- Select Product --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                       <div class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Batch Number</label>
        <select name="batch_number" id="batch_number" class="form-select">
            <option value="">-- Select Product First --</option>
            <!-- Options will be populated by JS -->
        </select>
        <small class="text-muted" id="batch-help">Select a product to see available batches</small>
    </div>
</div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Quantity *</label>
                                <input type="number" name="quantity" id="add_quantity" class="form-control" 
                                       step="0.01" min="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rate Amount *</label>
                                <input type="number" name="rate_amount" id="add_rate_amount" class="form-control" 
                                       step="0.01" readonly required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Total Cost</label>
                                <input type="number" id="add_total_cost" class="form-control" step="0.01" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Supervisor</label>
                                <select name="supervisor_id" class="form-select">
                                    <option value="">-- Select Supervisor --</option>
                                    @foreach($supervisors as $supervisor)
                                        <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Workers Count</label>
                                <input type="number" name="workers_count" class="form-control" value="1" min="1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Shift</label>
                                <select name="shift" class="form-select">
                                    <option value="">-- Select Shift --</option>
                                    <option value="morning">Morning</option>
                                    <option value="evening">Evening</option>
                                    <option value="night">Night</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Assign Labor Cost</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="edit_modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Labor Cost Assignment</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Date *</label>
                                <input type="date" name="date" id="edit_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Labor Type *</label>
                                <select name="labor_type_id" id="edit_labor_type_id" class="form-select" required>
                                    <option value="">-- Select Labor Type --</option>
                                    @foreach($laborTypes as $type)
                                        <option value="{{ $type->id }}"
                                                data-rate="{{ $type->rate_amount }}">
                                            {{ $type->name }} (₹{{ $type->rate_amount }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Product *</label>
                                <select name="product_id" id="edit_product_id" class="form-select" required>
                                    <option value="">-- Select Product --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Batch Number</label>
                                <input type="text" name="batch_number" id="edit_batch_number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Quantity *</label>
                                <input type="number" name="quantity" id="edit_quantity" class="form-control" 
                                       step="0.01" min="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rate Amount *</label>
                                <input type="number" name="rate_amount" id="edit_rate_amount" class="form-control" 
                                       step="0.01" readonly required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Total Cost</label>
                                <input type="number" id="edit_total_cost" class="form-control" step="0.01" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Supervisor</label>
                                <select name="supervisor_id" id="edit_supervisor_id" class="form-select">
                                    <option value="">-- Select Supervisor --</option>
                                    @foreach($supervisors as $supervisor)
                                        <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Workers Count</label>
                                <input type="number" name="workers_count" id="edit_workers_count" class="form-control" min="1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Shift</label>
                                <select name="shift" id="edit_shift" class="form-select">
                                    <option value="">-- Select Shift --</option>
                                    <option value="morning">Morning</option>
                                    <option value="evening">Evening</option>
                                    <option value="night">Night</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" id="edit_notes" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Assignment</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Auto-calculate total cost
function setupAutoCalculation(laborTypeId, quantityId, rateAmountId, totalCostId) {
    const laborTypeSelect = document.getElementById(laborTypeId);
    const quantityInput = document.getElementById(quantityId);
    const rateAmountInput = document.getElementById(rateAmountId);
    const totalCostInput = document.getElementById(totalCostId);

    if (!laborTypeSelect || !quantityInput || !rateAmountInput || !totalCostInput) return;

    laborTypeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const rate = selectedOption.getAttribute('data-rate');
        rateAmountInput.value = rate || 0;
        calculateTotalCost();
    });

    quantityInput.addEventListener('input', calculateTotalCost);
    rateAmountInput.addEventListener('input', calculateTotalCost);

    function calculateTotalCost() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const rate = parseFloat(rateAmountInput.value) || 0;
        const total = quantity * rate;
        totalCostInput.value = total.toFixed(2);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Setup for add modal
    setupAutoCalculation('add_labor_type_id', 'add_quantity', 'add_rate_amount', 'add_total_cost');
    
    // Setup for edit modal
    setupAutoCalculation('edit_labor_type_id', 'edit_quantity', 'edit_rate_amount', 'edit_total_cost');
});

// Edit assignment
function editAssignment(id) {
    fetch(`/labor-cost-assignments/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const assignment = data.data;
                
                // Set form action
                document.getElementById('editForm').action = `/labor-cost-assignments/${id}`;
                
                // Fill form fields
                document.getElementById('edit_date').value = assignment.date;
                document.getElementById('edit_labor_type_id').value = assignment.labor_type_id;
                document.getElementById('edit_product_id').value = assignment.product_id;
                document.getElementById('edit_batch_number').value = assignment.batch_number || '';
                document.getElementById('edit_quantity').value = assignment.quantity;
                document.getElementById('edit_rate_amount').value = assignment.rate_amount;
                document.getElementById('edit_total_cost').value = assignment.total_cost;
                document.getElementById('edit_supervisor_id').value = assignment.supervisor_id || '';
                document.getElementById('edit_workers_count').value = assignment.workers_count;
                document.getElementById('edit_shift').value = assignment.shift || '';
                document.getElementById('edit_notes').value = assignment.notes || '';
                
                // Trigger calculation
                document.getElementById('edit_quantity').dispatchEvent(new Event('input'));
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to load assignment details',
                timer: 3000
            });
        });
}

// Delete assignment
function deleteAssignment(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/labor-cost-assignments/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to delete assignment'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while deleting'
                });
            });
        }
    });
}

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
        window.location.href = '?search=' + encodeURIComponent(this.value);
    }
});
document.addEventListener('DOMContentLoaded', function() {
    
    // ✅ Pass batches from Blade to JS
    const allBatches = @json($batches);
    
    const productSelect = document.querySelector('select[name="product_id"]');
    const batchSelect = document.getElementById('batch_number');
    const batchHelp = document.getElementById('batch-help');

    // ✅ Filter batches when product changes
    productSelect.addEventListener('change', function() {
        const productId = this.value;
        
        // Clear existing options
        batchSelect.innerHTML = '<option value="">-- Select Batch --</option>';
        
        if (!productId) {
            batchHelp.textContent = 'Select a product to see available batches';
            batchSelect.disabled = true;
            return;
        }

        // Filter batches for selected product
        const productBatches = allBatches.filter(batch => batch.product_id == productId);
        
        if (productBatches.length === 0) {
            batchSelect.innerHTML = '<option value="">No batches found</option>';
            batchHelp.textContent = 'No production batches exist for this product';
            batchSelect.disabled = true;
            return;
        }

        // Populate dropdown
        productBatches.forEach(batch => {
            const option = document.createElement('option');
            option.value = batch.id; // or batch.batch_number if you have that field
            option.textContent = `Batch #${batch.id} - ${batch.production_date} (${batch.actual_output} units)`;
            option.dataset.output = batch.actual_output; // optional: for display
            batchSelect.appendChild(option);
        });

        batchHelp.textContent = `${productBatches.length} batch(es) available`;
        batchSelect.disabled = false;
    });

    // ✅ Trigger change on page load if product is pre-selected (edit mode)
    if (productSelect.value) {
        productSelect.dispatchEvent(new Event('change'));
    }
});
</script>
<script>
    console.log('Batches in view:', @json($batches ?? []));
</script>
@endpush