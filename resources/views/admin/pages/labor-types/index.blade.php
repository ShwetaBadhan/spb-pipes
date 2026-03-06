@extends('admin.layout.master')
@section('title', 'Labor Master')
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
                    <h6>Labor Details</h6>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="input-group mb-3" style="max-width: 300px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="isax isax-search-normal fs-12"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0 ps-0 bg-white"
                            placeholder="Search labor types..." value="{{ request('search') }}">
                    </div>
                    <div>
                        <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#add_modal">
                            <i class="isax isax-add-circle5 me-1"></i>Add Labor
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

            <div class="table-responsive border border-bottom-0 rounded">
                <table class="table table-nowrap m-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Category</th>
                            <th>Rate Type</th>
                            <th>Rate Amount</th>
                            <th>Unit</th>
                            <th>Work Type</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laborTypes as $index => $laborType)
                            <tr>
                                <td>{{ $laborTypes->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="fs-14 fw-medium mb-0">{{ $laborType->name }}</h6>

                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($laborType->code)
                                        <span class="badge bg-info">{{ $laborType->code }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $laborType->category == 'production' ? 'success' : 'primary' }}">
                                        {{ ucfirst($laborType->category) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $laborType->rateType->name ?? 'N/A' }}
                                </td>
                                <td>
                                    ₹{{ number_format($laborType->rate_amount, 2) }}
                                </td>
                                <td>
                                    {{ $laborType->unit->name ?? '-' }}
                                </td>
                                <td>
                                    {{ $laborType->workType->name ?? '-' }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $laborType->status == 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($laborType->status) }}
                                    </span>
                                </td>
                                <td class="action-item">

                                    <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <i class="isax isax-more"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#edit_modal" onclick="editLaborType({{ $laborType->id }})">
                                            <i class="isax isax-edit me-2"></i>Edit
                                        </a>

                                        <a class="dropdown-item text-danger" href="#"
                                            onclick="deleteLaborType({{ $laborType->id }})">
                                            <i class="isax isax-trash me-2"></i>Delete
                                        </a>

            </div>
            </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" class="text-center py-5">
                    <div class="text-muted">
                        <i class="isax isax-empty-wallet display-4 d-block mb-3"></i>
                        <p class="mb-0">No labor types found</p>
                        <small class="d-block mt-2">Click "Add Labor" to create your first labor type</small>
                    </div>
                </td>
            </tr>
            @endforelse
            </tbody>
            </table>
        </div>



    </div>
    <!-- End Content -->

    </div>

    <!-- ========================
           End Page Content
          ========================= -->

    <!-- Start Add Modal -->
    <div id="add_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Labor Type</h4>
                    <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-solid fa-x"></i>
                    </button>
                </div>

                <form id="laborTypeForm" action="{{ route('labor-types.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" name="name" placeholder="E.g. Mechanic" class="form-control"
                                        id="labor_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Code <span class="text-danger ms-1">*</span></label>
                                    <div class="position-relative">
                                        <input type="text" name="code" id="labor_code" class="form-control"
                                            value="{{ old('code') }}" readonly required>
                                        <a href="javascript:void(0);"
                                            class="btn btn-sm btn-dark position-absolute end-0 top-0 bottom-0 mx-2 my-1 d-inline-flex align-items-center"
                                            onclick="generateLaborCode()">
                                            Generate
                                        </a>
                                        @error('code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Code format: First 4 letters + 5100 series (e.g.,
                                        LOAD5100)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Category *</label>
                                    <select name="category" id="category" class="form-select" required>
                                        <option value="">-- Select Category --</option>
                                        <option value="production">Production</option>
                                        <option value="logistics">Logistics</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Rate Type *</label>
                                    <select name="rate_type_id" id="rate_type" class="form-select" disabled required>
                                        <option value="">-- Select Rate Type --</option>
                                        @foreach ($rateTypes as $rateType)
                                            <option value="{{ $rateType->id }}">{{ $rateType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="work_type_container" style="display:none;">
                                <div class="mb-3">
                                    <label class="form-label">Work Type *</label>
                                    <select name="work_type_id" id="work_type" class="form-select" disabled>
                                        <option value="">-- Select Work Type --</option>
                                        @foreach ($workTypes as $workType)
                                            <option value="{{ $workType->id }}">{{ $workType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="unit_container" style="display:none;">
                                <div class="mb-3">
                                    <label class="form-label">Unit *</label>
                                    <select name="unit_id" id="unit" class="form-select" disabled>
                                        <option value="">-- Select Unit --</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Rate Amount *</label>
                                    <input type="number" name="rate_amount" placeholder="E.g. 250/2.5" step="0.01"
                                        class="form-control" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status *</label>
                                    <select name="status" class="form-select" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" placeholder="Explain the role of the labor" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Labor Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Add Modal -->

    <!-- Start Edit Modal -->
    <div id="edit_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Labor Type</h4>
                    <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-solid fa-x"></i>
                    </button>
                </div>

                <form id="editLaborTypeForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" name="name" id="edit_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" name="code" id="edit_code" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Category *</label>
                                    <select name="category" id="edit_category" class="form-select" required>
                                        <option value="">-- Select Category --</option>
                                        <option value="production">Production</option>
                                        <option value="logistics">Logistics</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Rate Type *</label>
                                    <select name="rate_type_id" id="edit_rate_type" class="form-select" disabled
                                        required>
                                        <option value="">-- Select Rate Type --</option>
                                        @foreach ($rateTypes as $rateType)
                                            <option value="{{ $rateType->id }}">{{ $rateType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="edit_work_type_container" style="display:none;">
                                <div class="mb-3">
                                    <label class="form-label">Work Type *</label>
                                    <select name="work_type_id" id="edit_work_type" class="form-select" disabled>
                                        <option value="">-- Select Work Type --</option>
                                        @foreach ($workTypes as $workType)
                                            <option value="{{ $workType->id }}">{{ $workType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="edit_unit_container" style="display:none;">
                                <div class="mb-3">
                                    <label class="form-label">Unit *</label>
                                    <select name="unit_id" id="edit_unit" class="form-select" disabled>
                                        <option value="">-- Select Unit --</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Rate Amount *</label>
                                    <input type="number" name="rate_amount" id="edit_rate_amount" step="0.01"
                                        class="form-control" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status *</label>
                                    <select name="status" id="edit_status" class="form-select" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Labor Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Edit Modal -->

@endsection
@push('scripts')
    <script>
        // Generate labor type code
        function generateLaborCode() {
            const nameInput = document.getElementById('labor_name');
            const codeInput = document.getElementById('labor_code');

            if (!nameInput.value.trim()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: 'Please enter labor type name first',
                    timer: 3000,
                    showConfirmButton: false
                });
                return;
            }

            fetch('{{ route('labor-types.generate-code') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        name: nameInput.value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        codeInput.value = data.code;
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Code generated: ' + data.code,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        throw new Error('Failed to generate code');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to generate code',
                        timer: 3000,
                        showConfirmButton: false
                    });
                });
        }

        // Auto-generate code on name blur (optional)
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('labor_name');
            const codeInput = document.getElementById('labor_code');

            if (nameInput && codeInput) {
                nameInput.addEventListener('blur', function() {
                    if (this.value.trim() && !codeInput.value) {
                        generateLaborCode();
                    }
                });
            }
        }); // Add Modal - Category change handler
        document.addEventListener('DOMContentLoaded', function() {
            setupCategoryHandlers('category', 'rate_type', 'work_type_container', 'work_type', 'unit_container',
                'unit');
            setupCategoryHandlers('edit_category', 'edit_rate_type', 'edit_work_type_container', 'edit_work_type',
                'edit_unit_container', 'edit_unit');
        });

        function setupCategoryHandlers(categoryId, rateTypeId, workTypeContainerId, workTypeId, unitContainerId, unitId) {
            const category = document.getElementById(categoryId);
            const rateType = document.getElementById(rateTypeId);
            const workTypeContainer = document.getElementById(workTypeContainerId);
            const workType = document.getElementById(workTypeId);
            const unitContainer = document.getElementById(unitContainerId);
            const unit = document.getElementById(unitId);

            if (!category) return;

            category.addEventListener('change', function() {
                rateType.disabled = !this.value;

                if (this.value === 'logistics') {
                    workTypeContainer.style.display = 'block';
                    workType.disabled = false;
                    unitContainer.style.display = 'none';
                    unit.disabled = true;
                } else if (this.value === 'production') {
                    workTypeContainer.style.display = 'none';
                    workType.disabled = true;
                    unitContainer.style.display = 'block';
                    unit.disabled = false;
                } else {
                    workTypeContainer.style.display = 'none';
                    unitContainer.style.display = 'none';
                    workType.disabled = true;
                    unit.disabled = true;
                }
            });
        }

        // Edit Labor Type
        function editLaborType(id) {
            fetch(`/labor-types/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const labor = data.data;

                        // Set form action
                        document.getElementById('editLaborTypeForm').action = `/labor-types/${id}`;

                        // Fill form fields
                        document.getElementById('edit_name').value = labor.name;
                        document.getElementById('edit_code').value = labor.code || '';
                        document.getElementById('edit_category').value = labor.category;
                        document.getElementById('edit_rate_type').value = labor.rate_type_id;
                        document.getElementById('edit_rate_amount').value = labor.rate_amount;
                        document.getElementById('edit_status').value = labor.status;
                        document.getElementById('edit_description').value = labor.description || '';

                        // Set work_type and unit based on category
                        if (labor.category === 'logistics') {
                            document.getElementById('edit_work_type_container').style.display = 'block';
                            document.getElementById('edit_work_type').disabled = false;
                            document.getElementById('edit_work_type').value = labor.work_type_id || '';
                            document.getElementById('edit_unit_container').style.display = 'none';
                            document.getElementById('edit_unit').disabled = true;
                        } else if (labor.category === 'production') {
                            document.getElementById('edit_work_type_container').style.display = 'none';
                            document.getElementById('edit_work_type').disabled = true;
                            document.getElementById('edit_unit_container').style.display = 'block';
                            document.getElementById('edit_unit').disabled = false;
                            document.getElementById('edit_unit').value = labor.unit_id || '';
                        }

                        // Trigger category change to enable rate_type
                        document.getElementById('edit_rate_type').disabled = false;
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to load labor type details',
                        timer: 3000
                    });
                });
        }

        // Delete Labor Type
        function deleteLaborType(id) {
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
                    fetch(`/labor-types/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
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
                                    text: data.message || 'Failed to delete labor type'
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

        // Activate Labor Type
        function activateLaborType(id) {
            Swal.fire({
                title: 'Activate Labor Type?',
                text: "This labor type will be activated and available for use.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, activate it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/labor-types/${id}/activate`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Activated!',
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
                                    text: data.message || 'Failed to activate labor type'
                                });
                            }
                        });
                }
            });
        }

        // Deactivate Labor Type
        function deactivateLaborType(id) {
            Swal.fire({
                title: 'Deactivate Labor Type?',
                text: "This labor type will be deactivated and won't be available for use.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, deactivate it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/labor-types/${id}/deactivate`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deactivated!',
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
                                    text: data.message || 'Failed to deactivate labor type'
                                });
                            }
                        });
                }
            });
        }

        // Reset modals when closed
        document.getElementById('add_modal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('laborTypeForm').reset();
            resetFormFields('category', 'rate_type', 'work_type_container', 'work_type', 'unit_container', 'unit');
        });

        document.getElementById('edit_modal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('editLaborTypeForm').reset();
            resetFormFields('edit_category', 'edit_rate_type', 'edit_work_type_container', 'edit_work_type',
                'edit_unit_container', 'edit_unit');
        });

        function resetFormFields(categoryId, rateTypeId, workTypeContainerId, workTypeId, unitContainerId, unitId) {
            const category = document.getElementById(categoryId);
            const rateType = document.getElementById(rateTypeId);
            const workTypeContainer = document.getElementById(workTypeContainerId);
            const workType = document.getElementById(workTypeId);
            const unitContainer = document.getElementById(unitContainerId);
            const unit = document.getElementById(unitId);

            rateType.disabled = true;
            workType.disabled = true;
            unit.disabled = true;
            workTypeContainer.style.display = 'none';
            unitContainer.style.display = 'none';
        }
    </script>
@endpush
