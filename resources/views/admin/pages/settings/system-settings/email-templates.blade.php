@extends('admin.layout.master')

@section('page-title', 'Email Templates')

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
                                <h6 class="mb-0">Email Templates</h6>
                            </div>

                            {{-- Search & Add Button --}}
                            <form method="GET" action="{{ route('email-templates') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="input-icon-start position-relative mb-3">
                                            <span class="input-icon-addon"><i class="isax isax-search-normal"></i></span>
                                            <input type="text" name="search" class="form-control form-control-sm bg-white" 
                                                   placeholder="Search templates" value="{{ request('search') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="">All Categories</option>
                                                @foreach($categories ?? [] as $cat)
                                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                                        {{ ucfirst($cat) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex justify-content-end align-items-center mb-3">
                                            @if(request('search') || request('category'))
                                                <a href="{{ route('email-templates') }}" class="btn btn-sm btn-outline-secondary me-2">Clear</a>
                                            @endif
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_modal">
                                                <i class="isax isax-add-circle5 me-1"></i>New Template
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            {{-- Table --}}
                            <div class="table-responsive table-nowrap overflow-visible">
                                <table class="table border mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Template Name</th>
                                            <th>Category</th>
                                            <th>Created On</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($templates as $template)
                                        <tr>
                                            <td>
                                                <h6 class="fw-medium fs-14">
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_template_{{ $template->id }}">
                                                        {{ $template->name }}
                                                    </a>
                                                </h6>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $template->category == 'marketing' ? 'info' : ($template->category == 'system' ? 'secondary' : 'success') }}-soft">
                                                    {{ ucfirst($template->category ?? 'transactional') }}
                                                </span>
                                            </td>
                                            <td>
                                                <p class="text-dark mb-0">{{ $template->created_at->format('d M Y') }}</p>
                                            </td>
                                            <td>
                                                <form action="{{ route('email-templates.toggle', $template->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('PATCH')
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" 
                                                               name="is_active" value="1" {{ $template->is_active ? 'checked' : '' }}
                                                               onchange="this.form.submit()">
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="action-item">
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                            <i class="isax isax-more"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="{{ route('email-templates.preview', $template->id) }}" target="_blank" class="dropdown-item d-flex align-items-center">
                                                                    <i class="isax isax-eye me-2"></i>Preview
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" 
                                                                   data-bs-toggle="modal" data-bs-target="#edit_template_{{ $template->id }}">
                                                                    <i class="isax isax-edit me-2"></i>Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center text-danger"
                                                                   data-bs-toggle="modal" data-bs-target="#delete_template_{{ $template->id }}">
                                                                    <i class="isax isax-trash me-2"></i>Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- View/Preview Modal (Per Template) --}}
                                        <div id="view_template_{{ $template->id }}" class="modal fade">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="mb-0">Preview: {{ $template->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="border br-10 p-3 mb-3 bg-light">
                                                            <strong>Subject:</strong> {{ $template->subject }}
                                                        </div>
                                                        
                                                        {{-- Render HTML email body (admin-trusted content) --}}
                                                        <div class="border rounded-3 p-3 mb-3 email-preview-container" style="min-height: 200px;">
                                                            {!! $template->body !!}
                                                        </div>
                                                        
                                                        @if($template->variables && count($template->variables) > 0)
                                                        <div class="border rounded-3 p-3">
                                                            <label class="form-label fw-medium mb-2">Available Variables</label>
                                                            <p class="text-muted small mb-2">Use these placeholders in subject/body. They will be replaced dynamically when sending:</p>
                                                            <ul class="d-flex flex-wrap gap-2">
                                                                @foreach($template->variables as $var)
                                                                    <li><span class="badge bg-info-subtle text-info">{{ '{' . $var . '}' }}</span></li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                                        <a href="{{ route('email-templates.preview', $template->id) }}" target="_blank" class="btn btn-primary">
                                                            Open Full Preview
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Edit Modal (Per Template) --}}
                                        <div id="edit_template_{{ $template->id }}" class="modal fade">
                                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="mb-0">Edit Template</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('email-templates.update', $template->id) }}" method="POST">
                                                        @csrf @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Template Name <span class="text-danger">*</span></label>
                                                                        <input type="text" name="name" class="form-control" 
                                                                               value="{{ old('name', $template->name) }}" required>
                                                                        @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Slug (unique) <span class="text-danger">*</span></label>
                                                                        <input type="text" name="slug" class="form-control" 
                                                                               value="{{ old('slug', $template->slug) }}" required>
                                                                        <small class="text-muted">Used for programmatic access</small>
                                                                        @error('slug')<div class="text-danger small">{{ $message }}</div>@enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Category</label>
                                                                        <select name="category" class="form-select">
                                                                            <option value="transactional" {{ old('category', $template->category) == 'transactional' ? 'selected' : '' }}>Transactional</option>
                                                                            <option value="marketing" {{ old('category', $template->category) == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                                                            <option value="system" {{ old('category', $template->category) == 'system' ? 'selected' : '' }}>System</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Subject <span class="text-danger">*</span></label>
                                                                        <input type="text" name="subject" class="form-control" 
                                                                               value="{{ old('subject', $template->subject) }}" required>
                                                                        @error('subject')<div class="text-danger small">{{ $message }}</div>@enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Email Body (HTML supported) <span class="text-danger">*</span></label>
                                                                        <textarea name="body" class="form-control" rows="10" required>{{ old('body', $template->body) }}</textarea>
                                                                        @error('body')<div class="text-danger small">{{ $message }}</div>@enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Variables (comma separated)</label>
                                                                        <input type="text" name="variables" class="form-control" 
                                                                               value="{{ old('variables', $template->variables ? implode(', ', $template->variables) : '') }}"
                                                                               placeholder="Customer Name, Company Name, Booking Number">
                                                                        <small class="text-muted">Use {Variable Name} in subject/body</small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="d-flex align-items-center justify-content-between">
                                                                        <label class="form-label mb-0">Status</label>
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" role="switch" 
                                                                                   name="is_active" value="1" {{ old('is_active', $template->is_active) ? 'checked' : '' }}>
                                                                        </div>
                                                                    </div>
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

                                        {{-- Delete Modal (Per Template) --}}
                                        <div id="delete_template_{{ $template->id }}" class="modal fade">
                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center p-4">
                                                        <div class="avatar avatar-lg bg-soft-danger rounded-circle mb-3 mx-auto">
                                                            <i class="isax isax-trash fs-24 text-danger"></i>
                                                        </div>
                                                        <h5 class="mb-2">Delete Template</h5>
                                                        <p class="text-muted mb-4">Are you sure you want to delete <strong>{{ $template->name }}</strong>?</p>
                                                        <form action="{{ route('email-templates.destroy', $template->id) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <div class="d-flex justify-content-center gap-2">
                                                                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger px-4">Yes, Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                No email templates found. <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_modal" class="text-primary fw-medium">Add your first template!</a>
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

{{-- ADD TEMPLATE MODAL --}}
<div id="add_modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="mb-0">Add Email Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('email-templates.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Template Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Slug (unique)</label>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="auto-generated if empty">
                                <small class="text-muted">Used for programmatic access</small>
                                @error('slug')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    <option value="transactional" {{ old('category') == 'transactional' ? 'selected' : '' }}>Transactional</option>
                                    <option value="marketing" {{ old('category') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                    <option value="system" {{ old('category') == 'system' ? 'selected' : '' }}>System</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Subject <span class="text-danger">*</span></label>
                                <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required>
                                @error('subject')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Email Body (HTML supported) <span class="text-danger">*</span></label>
                                <textarea name="body" class="form-control" rows="10" required>{{ old('body') }}</textarea>
                                <small class="text-muted">Use <code>{Variable Name}</code> for dynamic content</small>
                                @error('body')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Variables (comma separated)</label>
                                <input type="text" name="variables" class="form-control" 
                                       value="{{ old('variables') }}"
                                       placeholder="Customer Name, Company Name, Booking Number">
                                <small class="text-muted">Enter variable names, e.g., <code>Customer Name, Order ID</code></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Template</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

