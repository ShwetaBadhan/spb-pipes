@extends('admin.layout.master')
@section('title', 'Production Batch')
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
                    <h6>Batch #{{ $batch->id }} – Consumption Details</h6>
                </div>
                <div class="my-xl-auto d-flex align-items-center gap-2">
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <i class="isax isax-export-1 me-1"></i>Export
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);">Download as PDF</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);">Download as Excel</a>
                            </li>
                        </ul>
                    </div>

                    {{-- <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#add_recipe"><i class="isax isax-add-circle5 me-1"></i>Add </a> --}}
                </div>
            </div>
            <!-- End Page Header -->



            <!-- End Table Search -->
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
            <!-- Start Table List -->
            <div class="table-responsive">
                <table class="table table-nowrap datatable">
                    <thead>
                        <tr>
                            <th class="no-sort">
                                <div class="form-check form-check-md">
                                    <input class="form-check-input" type="checkbox" id="select-all">
                                </div>
                            </th>

                            <th>Raw Material</th>
                            <th>Expected Qty Usage(Raw Material)</th>
                            <th>Actual Qty Usage(Raw Material)</th>
                            <th>Variance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consumptions as $c)
                            <tr>
                                <td></td>
                                <td>{{ $c->rawMaterial->material_name }}</td>
                                <td>{{ number_format($c->expected_qty) }}</td>
                                <td>{{ number_format($c->actual_qty) }}</td>
                                <td>
                                    {{ number_format($c->actual_qty - $c->expected_qty) }}
                                </td>
                                <td class="action-item">
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <i class="isax isax-more"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#edit_batch{{ $batch->id }}">
                                                <i class="isax isax-edit me-2"></i>Edit
                                            </a>
                                        </li>
                                    </ul>

                                </td>
                            </tr>
                            <!-- Edit Modal - Fixed Version -->
                            <!-- Edit Production Consumption Modal -->
                            <div class="modal fade" id="edit_batch{{ $batch->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h4 class="modal-title">
                                                Edit Production Consumption – Batch #{{ $batch->id }}
                                            </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('production-consumptions.update', $batch->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">

                                                @foreach ($consumptions as $c)
                                                    <div class="border rounded p-3 mb-3">

                                                        <h6 class="mb-3">
                                                            {{ $c->rawMaterial->material_name }}
                                                            ({{ $c->rawMaterial->unit->name ?? '' }})
                                                        </h6>

                                                        <div class="row">

                                                            <!-- Expected Qty -->
                                                            <div class="col-md-4">
                                                                <label class="form-label">Expected Qty</label>
                                                                <input type="number" class="form-control"
                                                                    value="{{ number_format($c->expected_qty, 2) }}"
                                                                    readonly>
                                                            </div>

                                                            <!-- Actual Qty -->
                                                            <div class="col-md-4">
                                                                <label class="form-label">Actual Qty</label>
                                                                <input type="number" step="0.01"
                                                                    name="actual_qty[{{ $c->id }}]"
                                                                    class="form-control" value="{{ $c->actual_qty }}"
                                                                    required>
                                                            </div>

                                                            <!-- Variance -->
                                                            <div class="col-md-4">
                                                                <label class="form-label">Variance</label>
                                                                <input type="number" class="form-control"
                                                                    value="{{ number_format($c->actual_qty - $c->expected_qty, 2) }}"
                                                                    readonly>
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <button type="submit" class="btn btn-primary">
                                                    Save Actual Consumption
                                                </button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>

                            <!-- Start Modal  -->
                        @endforeach
                    </tbody>


                </table>
            </div>
            <!-- end Table List -->

        </div>
        <!-- End Content -->



    </div>

    <!-- ========================
                               End Page Content
                              ========================= -->





    <!-- Start Add Consumption Modal -->
    {{-- <div id="add_recipe" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Raw Material Consumption</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

        <form action="{{ route('production-consumptions.store') }}" method="POST">
    @csrf

    <div class="modal-body">
        <div class="row">

          <!-- Batch Selection -->
<div class="mb-3">
    <label class="form-label">Select Batch</label>
    <select name="batch_id" class="form-select" id="batchSelect" required>
        <option value="">Select Batch</option>
        @foreach ($batches as $batch)
            <option value="{{ $batch->id }}">{{ $batch->name }} ({{ $batch->product->name ?? 'N/A' }})</option>
        @endforeach
    </select>
</div>

<!-- Raw Material Selection (Single) -->
<div class="mb-3">
    <label class="form-label">Raw Material</label>
   <select name="raw_material_ids[]" class="select" id="rawMaterialSelect" multiple>
    <option value="">Select Raw Materials</option>
</select>

</div>

            <!-- Expected Quantity -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Expected Quantity</label>
                    <input type="number"
                           step="0.01"
                           name="expected_qty"
                           class="form-control"
                           placeholder="Auto / Manual"
                           required>
                </div>
            </div>

            <!-- Actual Quantity -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Actual Quantity</label>
                    <input type="number"
                           step="0.01"
                           name="actual_qty"
                           class="form-control"
                           required>
                </div>
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Consumption</button>
    </div>
</form>

        </div>
    </div>
</div> --}}


@endsection
{{-- @push('scripts')
<script>
const batchSelect = document.getElementById('batchSelect'); // batch dropdown
const rawMaterialSelect = document.getElementById('rawMaterialSelect');

batchSelect.addEventListener('change', function() {
    const batchId = this.value;

    // Clear previous options
    rawMaterialSelect.innerHTML = '';

    if (!batchId) return;

    fetch(`/bill-of-materials/by-batch/${batchId}`)
        .then(res => res.json())
        .then(data => {
            data.forEach(rm => {
                const option = document.createElement('option');
                option.value = rm.id;
                option.textContent = rm.material_name + (rm.unit?.short_name ? ` (${rm.unit.short_name})` : '');
                rawMaterialSelect.appendChild(option);
            });
        })
        .catch(err => console.error(err));
});

</script>
    
@endpush --}}
