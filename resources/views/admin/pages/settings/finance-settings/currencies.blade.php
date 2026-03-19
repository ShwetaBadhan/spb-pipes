@extends('admin.layout.master')

@section('page-title', 'Currencies')

@section('content')
<div class="page-wrapper">
    <div class="content">
        {{-- Messages --}}
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
                        <div>
                            <div class="pb-3 border-bottom mb-3">
                                <h6 class="mb-0">Currencies</h6>
                            </div>

                            {{-- Search & Add Button --}}
                            <form method="GET" action="{{ route('currencies') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-icon-start position-relative mb-3">
                                            <span class="input-icon-addon"><i class="isax isax-search-normal"></i></span>
                                            <input type="text" name="search" class="form-control form-control-sm bg-white" 
                                                   placeholder="Search currencies" value="{{ request('search') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex justify-content-end align-items-center flex-wrap gap-2 mb-3">
                                            @if(request('search'))
                                                <a href="{{ route('currencies') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                                            @endif
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_modal">
                                                <i class="isax isax-add-circle5 me-1"></i>New Currency
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            {{-- Table --}}
                            <div class="table-responsive border border-bottom-0 rounded">
                                <table class="table mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Currency</th>
                                            <th>Code</th>
                                            <th>Symbol</th>
                                            <th>Exchange Rate</th>
                                            <th>Default</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($currencies as $currency)
                                        <tr>
                                            <td>
                                                <h6 class="fs-14 fw-medium mb-0">{{ $currency->name }}</h6>
                                            </td>
                                            <td>{{ $currency->code }}</td>
                                            <td>{{ $currency->symbol }}</td>
                                            <td>{{ number_format($currency->exchange_rate, 4) }}</td>
                                            <td class="default-star">
                                                @if($currency->is_default)
                                                    <span class="badge bg-success">Default</span>
                                                @else
                                                    <form action="{{ route('currencies.default', $currency->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Set as default">
                                                            <i class="isax isax-star"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('currencies.toggle', $currency->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="is_active" value="0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" 
                                                               name="is_active" value="1" {{ $currency->is_active ? 'checked' : '' }}
                                                               onchange="this.form.submit()" {{ $currency->is_default ? 'disabled' : '' }}>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="action-item">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                        <i class="isax isax-more"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" 
                                                               data-bs-toggle="modal" data-bs-target="#edit_currency_{{ $currency->id }}">
                                                                <i class="isax isax-edit me-2"></i>Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center text-danger"
                                                               data-bs-toggle="modal" data-bs-target="#delete_currency_{{ $currency->id }}">
                                                                <i class="isax isax-trash me-2"></i>Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Edit Modal (Per Currency) --}}
                                        <div id="edit_currency_{{ $currency->id }}" class="modal fade">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Currency</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('currencies.update', $currency->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Currency Name <span class="text-danger">*</span></label>
                                                                        <input type="text" name="name" class="form-control" 
                                                                               value="{{ old('name', $currency->name) }}" required>
                                                                        @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Exchange Rate <span class="text-danger">*</span></label>
                                                                        <input type="number" name="exchange_rate" class="form-control" step="0.0001" min="0"
                                                                               value="{{ old('exchange_rate', $currency->exchange_rate) }}" required>
                                                                        @error('exchange_rate')<div class="text-danger small">{{ $message }}</div>@enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Code <span class="text-danger">*</span></label>
                                                                        <input type="text" name="code" class="form-control" maxlength="3" 
                                                                               value="{{ old('code', $currency->code) }}" required style="text-transform:uppercase">
                                                                        @error('code')<div class="text-danger small">{{ $message }}</div>@enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Symbol <span class="text-danger">*</span></label>
                                                                        <input type="text" name="symbol" class="form-control" 
                                                                               value="{{ old('symbol', $currency->symbol) }}" required>
                                                                        @error('symbol')<div class="text-danger small">{{ $message }}</div>@enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                                                        <label class="form-label mb-0">Make Default</label>
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input m-0" type="checkbox" name="is_default" value="1"
                                                                                   {{ old('is_default', $currency->is_default) ? 'checked' : '' }}>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="d-flex align-items-center justify-content-between">
                                                                        <label class="form-label mb-0">Status</label>
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" role="switch" 
                                                                                   name="is_active" value="1" {{ old('is_active', $currency->is_active) ? 'checked' : '' }}
                                                                                   {{ $currency->is_default ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </div>
                                                                    @if($currency->is_default)
                                                                        <small class="text-muted">Default currency cannot be deactivated</small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Delete Modal (Per Currency) --}}
                                        <div id="delete_currency_{{ $currency->id }}" class="modal fade">
                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center p-4">
                                                        <div class="avatar avatar-lg bg-soft-danger rounded-circle mb-3 mx-auto">
                                                            <i class="isax isax-trash fs-24 text-danger"></i>
                                                        </div>
                                                        <h5 class="mb-2">Delete Currency</h5>
                                                        @if($currency->is_default)
                                                            <p class="text-danger mb-4">Cannot delete the default currency!</p>
                                                            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Close</button>
                                                        @else
                                                            <p class="text-muted mb-4">Are you sure you want to delete <strong>{{ $currency->name }}</strong>?</p>
                                                            <form action="{{ route('currencies.destroy', $currency->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="d-flex justify-content-center gap-2">
                                                                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-danger px-4">Yes, Delete</button>
                                                                </div>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                No currencies found. Add your first currency!
                                            </td>
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

{{-- ADD CURRENCY MODAL --}}
<div id="add_modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Currency</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('currencies.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Currency Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Exchange Rate <span class="text-danger">*</span></label>
                                <input type="number" name="exchange_rate" class="form-control" step="0.0001" min="0" value="{{ old('exchange_rate') }}" required>
                                @error('exchange_rate')<div class="text-danger small">{{ $message }}</div>@enderror
                                <small class="text-muted">Rate against your base currency</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Code <span class="text-danger">*</span></label>
                                <input type="text" name="code" class="form-control" maxlength="3" value="{{ old('code') }}" required style="text-transform:uppercase">
                                @error('code')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Symbol <span class="text-danger">*</span></label>
                                <input type="text" name="symbol" class="form-control" value="{{ old('symbol') }}" required>
                                @error('symbol')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="form-label mb-0">Make Default</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input m-0" type="checkbox" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
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