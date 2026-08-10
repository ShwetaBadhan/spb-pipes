@extends('admin.layout.master')

@section('page-title', 'Bank Accounts')

@section('content')
    <div class="page-wrapper">
        <div class="content">


            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="row settings-wrapper d-flex">
                        <div class="col-xl-3 col-lg-4">
                            @include('admin.components.settings-sidebar')
                        </div>

                        <div class="col-xl-9 col-lg-8">
                            <div class="mb-3">
                                <div class="pb-3 border-bottom mb-3">
                                    <h6 class="mb-0">Bank Accounts</h6>
                                </div>

                                {{-- Search & Add Button --}}
                                <form method="GET" action="{{ route('bank-accounts') }}" class="mb-3">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <div class="input-icon-start position-relative">
                                                <span class="input-icon-addon">
                                                    <i class="isax isax-search-normal"></i>
                                                </span>
                                                <input type="text" name="search"
                                                    class="form-control form-control-sm bg-white" placeholder="Search"
                                                    value="{{ request('search') }}">
                                            </div>
                                            @if (request('search'))
                                                <a href="{{ route('bank-accounts') }}"
                                                    class="btn btn-sm btn-outline-secondary">Clear</a>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <button type="button" class="btn btn-primary d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#add_bank_settings">
                                                <i class="isax isax-add-circle5 me-2"></i>New Bank Account
                                            </button>
                                        </div>
                                    </div>
                                </form>

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

                                {{-- Table --}}
                                <div class="table-responsive table-nowrap">
                                    <table class="table border">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Bank</th>
                                                <th>Branch</th>
                                                <th>Account Number</th>
                                                <th>ABA Number</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($bankAccounts as $account)
                                                <tr>
                                                    <td>
                                                        <a href="javascript:void(0);"
                                                            class="text-dark">{{ $account->account_holder_name }}</a>
                                                    </td>
                                                    <td>{{ $account->bank_name }}</td>
                                                    <td>{{ $account->branch_name }}</td>
                                                    <td>**** {{ substr($account->account_number, -4) }}</td>
                                                    <td>{{ $account->aba_number ?? '-' }}</td>
                                                    <td>
                                                        <form action="{{ route('bank-accounts.toggle', $account->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch"
                                                                    {{ $account->is_active ? 'checked' : '' }}
                                                                    onchange="this.form.submit()">
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
                                                                    <a href="javascript:void(0);"
                                                                        class="dropdown-item d-flex align-items-center"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#edit_bank_{{ $account->id }}">
                                                                        <i class="isax isax-edit me-2"></i>Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);"
                                                                        class="dropdown-item d-flex align-items-center text-danger"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#delete_bank_{{ $account->id }}">
                                                                        <i class="isax isax-trash me-2"></i>Delete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- Edit Modal (Per Record) --}}
                                                <div id="edit_bank_{{ $account->id }}" class="modal fade">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Bank Account</h4>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <form
                                                                action="{{ route('bank-accounts.update', $account->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Account Holder Name <span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="text" name="account_holder_name"
                                                                            class="form-control"
                                                                            value="{{ old('account_holder_name', $account->account_holder_name) }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Bank Name <span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="text" name="bank_name"
                                                                            class="form-control"
                                                                            value="{{ old('bank_name', $account->bank_name) }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Branch Name <span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="text" name="branch_name"
                                                                            class="form-control"
                                                                            value="{{ old('branch_name', $account->branch_name) }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Account Number <span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="text" name="account_number"
                                                                            class="form-control"
                                                                            value="{{ old('account_number', $account->account_number) }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">ABA Number</label>
                                                                        <input type="text" name="aba_number"
                                                                            class="form-control"
                                                                            value="{{ old('aba_number', $account->aba_number) }}">
                                                                    </div>
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-between">
                                                                        <label class="form-label mb-0">Status</label>
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" role="switch"
                                                                                name="is_active" value="1"
                                                                                {{ old('is_active', $account->is_active) ? 'checked' : '' }}>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        Changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Delete Modal (Per Record) --}}
                                                <div id="delete_bank_{{ $account->id }}" class="modal fade">
                                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center p-4">
                                                                <div
                                                                    class="avatar avatar-lg bg-soft-danger rounded-circle mb-3 mx-auto">
                                                                    <i class="isax isax-trash fs-24 text-danger"></i>
                                                                </div>
                                                                <h5 class="mb-2">Delete Bank Account</h5>
                                                                <p class="text-muted mb-4">
                                                                    Are you sure you want to delete
                                                                    <strong>{{ $account->account_holder_name }}</strong>?
                                                                </p>
                                                                <form
                                                                    action="{{ route('bank-accounts.destroy', $account->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
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
                                                    <td colspan="7" class="text-center py-5 text-muted">
                                                        No bank accounts found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Pagination --}}
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $bankAccounts->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <div id="add_bank_settings" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Bank Account</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('bank-accounts.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Account Holder Name <span class="text-danger">*</span></label>
                            <input type="text" name="account_holder_name" class="form-control"
                                value="{{ old('account_holder_name') }}" required>
                            @error('account_holder_name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bank Name <span class="text-danger">*</span></label>
                            <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name') }}"
                                required>
                            @error('bank_name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Branch Name <span class="text-danger">*</span></label>
                            <input type="text" name="branch_name" class="form-control"
                                value="{{ old('branch_name') }}" required>
                            @error('branch_name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Account Number <span class="text-danger">*</span></label>
                            <input type="text" name="account_number" class="form-control"
                                value="{{ old('account_number') }}" required>
                            @error('account_number')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label">ABA Number</label>
                            <input type="text" name="aba_number" class="form-control"
                                value="{{ old('aba_number') }}">
                            @error('aba_number')
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
