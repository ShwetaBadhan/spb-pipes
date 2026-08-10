@extends('admin.layout.master')

@section('page-title', 'Tax Rates')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <!-- end row -->
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


            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="row settings-wrapper d-flex">
                        <div class="col-xl-3 col-lg-4">
                            @include('admin.components.settings-sidebar')
                        </div>

                        <div class="col-xl-9 col-lg-8">
                            <div class="mb-3">
                                <div class="pb-3 border-bottom mb-3">
                                    <h6 class="mb-0">Tax Rates</h6>
                                </div>

                                {{-- TAX RATES SECTION --}}
                                <div class="mb-4">
                                    <form method="GET" action="{{ route('tax-rates') }}" class="mb-3">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="input-icon-start position-relative">
                                                    <span class="input-icon-addon"><i
                                                            class="isax isax-search-normal"></i></span>
                                                    <input type="text" name="search_rates"
                                                        class="form-control form-control-sm bg-white"
                                                        placeholder="Search tax rates"
                                                        value="{{ request('search_rates') }}">
                                                </div>
                                                @if (request('search_rates'))
                                                    <a href="{{ route('tax-rates') }}"
                                                        class="btn btn-sm btn-outline-secondary">Clear</a>
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#add_tax_rates">
                                                <i class="isax isax-add-circle5 me-2"></i>New Tax Rate
                                            </button>
                                        </div>
                                    </form>

                                    <div class="table-responsive table-nowrap overflow-visible">
                                        <table class="table border mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Tax Rate</th>
                                                    <th>Created On</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($taxRates as $rate)
                                                    <tr>
                                                        <td><a href="javascript:void(0);"
                                                                class="text-dark">{{ $rate->name }}</a></td>
                                                        <td>{{ number_format($rate->rate, 2) }}%</td>
                                                        <td>{{ $rate->created_at->format('d M Y') }}</td>
                                                        <td>
                                                            <form action="{{ route('tax-rates.update', $rate->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf @method('PUT')
                                                                <input type="hidden" name="name"
                                                                    value="{{ $rate->name }}">
                                                                <input type="hidden" name="rate"
                                                                    value="{{ $rate->rate }}">
                                                                <input type="hidden" name="is_active" value="0">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="is_active" value="1"
                                                                        {{ $rate->is_active ? 'checked' : '' }}
                                                                        onchange="this.form.submit()">
                                                                </div>
                                                            </form>
                                                        </td>
                                                        <td class="action-item">
                                                            <div class="dropdown">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown"><i
                                                                        class="isax isax-more"></i></a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="javascript:void(0);"
                                                                            class="dropdown-item d-flex align-items-center"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#edit_tax_{{ $rate->id }}">
                                                                            <i class="isax isax-edit me-2"></i>Edit
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);"
                                                                            class="dropdown-item d-flex align-items-center text-danger"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#delete_tax_{{ $rate->id }}">
                                                                            <i class="isax isax-trash me-2"></i>Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    {{-- Edit Modal (Per Rate) --}}
                                                    <div id="edit_tax_{{ $rate->id }}" class="modal fade">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit Tax Rate</h4>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <form action="{{ route('tax-rates.update', $rate->id) }}"
                                                                    method="POST">
                                                                    @csrf @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Tax Name <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="name"
                                                                                class="form-control"
                                                                                value="{{ old('name', $rate->name) }}"
                                                                                required>
                                                                            @error('name')
                                                                                <div class="text-danger small">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Tax Rate (%) <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="number" name="rate"
                                                                                class="form-control" step="0.01"
                                                                                min="0" max="100"
                                                                                value="{{ old('rate', $rate->rate) }}"
                                                                                required>
                                                                            @error('rate')
                                                                                <div class="text-danger small">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" role="switch"
                                                                                name="is_active" value="1"
                                                                                {{ old('is_active', $rate->is_active) ? 'checked' : '' }}>
                                                                            <label class="form-check-label">Active</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save Changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Delete Modal (Per Rate) --}}
                                                    <div id="delete_tax_{{ $rate->id }}" class="modal fade">
                                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center p-4">
                                                                    <div
                                                                        class="avatar avatar-lg bg-soft-danger rounded-circle mb-3 mx-auto">
                                                                        <i class="isax isax-trash fs-24 text-danger"></i>
                                                                    </div>
                                                                    <h5 class="mb-2">Delete Tax Rate</h5>
                                                                    <p class="text-muted mb-4">Are you sure you want to
                                                                        delete <strong>{{ $rate->name }}</strong>?</p>
                                                                    <form
                                                                        action="{{ route('tax-rates.destroy', $rate->id) }}"
                                                                        method="POST">
                                                                        @csrf @method('DELETE')
                                                                        <div class="d-flex justify-content-center gap-2">
                                                                            <button type="button"
                                                                                class="btn btn-outline-secondary px-4"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit"
                                                                                class="btn btn-danger px-4">Yes,
                                                                                Delete</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-4 text-muted">No tax
                                                            rates found.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- TAX GROUPS SECTION --}}
                                <div class="mb-0">
                                    <div class="pb-3 border-bottom mb-3">
                                        <h6 class="mb-0">Tax Groups</h6>
                                    </div>

                                    <form method="GET" action="{{ route('tax-rates') }}" class="mb-3">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="input-icon-start position-relative">
                                                    <span class="input-icon-addon"><i
                                                            class="isax isax-search-normal"></i></span>
                                                    <input type="text" name="search_groups"
                                                        class="form-control form-control-sm bg-white"
                                                        placeholder="Search tax groups"
                                                        value="{{ request('search_groups') }}">
                                                </div>
                                                @if (request('search_groups'))
                                                    <a href="{{ route('tax-rates') }}"
                                                        class="btn btn-sm btn-outline-secondary">Clear</a>
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#add_tax_group">
                                                <i class="isax isax-add-circle5 me-2"></i>New Tax Group
                                            </button>
                                        </div>
                                    </form>

                                    <div class="table-responsive table-nowrap overflow-visible">
                                        <table class="table border mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Tax Rates</th>
                                                    <th>Created On</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($taxGroups as $group)
                                                    <tr>
                                                        <td><a href="javascript:void(0);"
                                                                class="text-dark">{{ $group->name }}</a></td>
                                                        <td>
                                                            @foreach ($group->tax_rates as $tr)
                                                                <span
                                                                    class="badge bg-light text-dark me-1">{{ $tr->name }}</span>
                                                            @endforeach
                                                        </td>
                                                        <td>{{ $group->created_at->format('d M Y') }}</td>
                                                        <td>
                                                            <form action="{{ route('tax-groups.update', $group->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf @method('PUT')
                                                                <input type="hidden" name="name"
                                                                    value="{{ $group->name }}">
                                                                <input type="hidden" name="sub_taxes"
                                                                    value='@json($group->sub_taxes)'>
                                                                <input type="hidden" name="is_active" value="0">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="is_active" value="1"
                                                                        {{ $group->is_active ? 'checked' : '' }}
                                                                        onchange="this.form.submit()">
                                                                </div>
                                                            </form>
                                                        </td>
                                                        <td class="action-item">
                                                            <div class="dropdown">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown"><i
                                                                        class="isax isax-more"></i></a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="javascript:void(0);"
                                                                            class="dropdown-item d-flex align-items-center"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#edit_group_{{ $group->id }}">
                                                                            <i class="isax isax-edit me-2"></i>Edit
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);"
                                                                            class="dropdown-item d-flex align-items-center text-danger"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#delete_group_{{ $group->id }}">
                                                                            <i class="isax isax-trash me-2"></i>Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    {{-- Edit Group Modal --}}
                                                    <div id="edit_group_{{ $group->id }}" class="modal fade">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit Tax Group</h4>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('tax-groups.update', $group->id) }}"
                                                                    method="POST">
                                                                    @csrf @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Group Name <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="name"
                                                                                class="form-control"
                                                                                value="{{ old('name', $group->name) }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Sub Taxes <span
                                                                                    class="text-danger">*</span></label>
                                                                            <div
                                                                                class="border rounded p-2 max-vh-20 overflow-auto">
                                                                                @foreach ($allTaxRates as $tr)
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                            type="checkbox"
                                                                                            name="sub_taxes[]"
                                                                                            value="{{ $tr->id }}"
                                                                                            id="group_{{ $group->id }}_tax_{{ $tr->id }}"
                                                                                            {{ in_array($tr->id, $group->sub_taxes ?? []) ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                            for="group_{{ $group->id }}_tax_{{ $tr->id }}">
                                                                                            {{ $tr->name }}
                                                                                            ({{ $tr->rate }}%)
                                                                                        </label>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                            <small class="text-muted">Select tax rates to
                                                                                include in this group</small>
                                                                        </div>
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" role="switch"
                                                                                name="is_active" value="1"
                                                                                {{ old('is_active', $group->is_active) ? 'checked' : '' }}>
                                                                            <label class="form-check-label">Active</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save Changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Delete Group Modal --}}
                                                    <div id="delete_group_{{ $group->id }}" class="modal fade">
                                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center p-4">
                                                                    <div
                                                                        class="avatar avatar-lg bg-soft-danger rounded-circle mb-3 mx-auto">
                                                                        <i class="isax isax-trash fs-24 text-danger"></i>
                                                                    </div>
                                                                    <h5 class="mb-2">Delete Tax Group</h5>
                                                                    <p class="text-muted mb-4">Are you sure you want to
                                                                        delete <strong>{{ $group->name }}</strong>?</p>
                                                                    <form
                                                                        action="{{ route('tax-groups.destroy', $group->id) }}"
                                                                        method="POST">
                                                                        @csrf @method('DELETE')
                                                                        <div class="d-flex justify-content-center gap-2">
                                                                            <button type="button"
                                                                                class="btn btn-outline-secondary px-4"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit"
                                                                                class="btn btn-danger px-4">Yes,
                                                                                Delete</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-4 text-muted">No tax
                                                            groups found.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ADD TAX RATE MODAL --}}
    <div id="add_tax_rates" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Tax Rate</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('tax-rates.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tax Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Tax Rate (%) <span class="text-danger">*</span></label>
                            <input type="number" name="rate" class="form-control" step="0.01" min="0"
                                max="100" value="{{ old('rate') }}" required>
                            @error('rate')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add New</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ADD TAX GROUP MODAL --}}
    <div id="add_tax_group" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Tax Group</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('tax-groups.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Group Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Sub Taxes <span class="text-danger">*</span></label>
                            <div class="border rounded p-2 max-vh-20 overflow-auto">
                                @foreach ($allTaxRates as $tr)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sub_taxes[]"
                                            value="{{ $tr->id }}" id="add_tax_{{ $tr->id }}"
                                            {{ in_array($tr->id, old('sub_taxes', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="add_tax_{{ $tr->id }}">
                                            {{ $tr->name }} ({{ $tr->rate }}%)
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-muted">Select tax rates to include</small>
                            @error('sub_taxes')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add New</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
