@extends('admin.layout.master')
@section('content')
    <!-- ========================
           Start Page Content
          ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            @endif

            @if (session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '{{ session('error') }}',
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            @endif
            <!-- start row -->
            <div class="row justify-content-center">

                <div class="col-xl-12">

                    <!-- start row -->
                    <div class="row settings-wrapper d-flex">

                        <!-- Start settings sidebar -->
                        <div class="col-xl-3 col-lg-4">
                            @include('admin.components.settings-sidebar')
                        </div><!-- end col -->
                        <!-- End settings sidebar -->

                        <div class="col-xl-9 col-lg-8">
                            <div class="mb-3 pb-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <h6 class="fw-bold mb-0">Language</h6>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);" class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add_language">
                                        <i class="isax isax-add-circle5 me-1"></i>Add New Language
                                    </a>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                                    <div class="input-icon-start position-relative me-2">
                                        <span class="input-icon-addon">
                                            <i class="isax isax-search-normal"></i>
                                        </span>
                                        <input type="text" id="searchLanguage" class="form-control form-control-sm bg-white" placeholder="Search">                                      
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Data Table -->
                            <div class="custom-datatable-filter table-nowrap table-responsive border rounded mb-3">
                                <table class="table mb-0" id="languageTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Language</th>
                                            <th>Code</th>
                                            <th>RTL</th>
                                            <th>Default</th>
                                            <th>Status</th>
                                            <th>Platforms</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($languages as $language)
                                        <tr data-language-id="{{ $language->id }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $language->flag_url }}" alt="{{ $language->name }}" class="avatar avatar-xs rounded-circle me-2">
                                                    <span>{{ $language->name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $language->code }}</td>
                                            <td>
                                                <div class="form-check form-check-sm form-switch">
                                                    <input class="form-check-input toggle-rtl" type="checkbox" role="switch" 
                                                        data-id="{{ $language->id }}" {{ $language->is_rtl ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-check-sm form-switch">
                                                    <input class="form-check-input toggle-default" type="checkbox" role="switch" 
                                                        data-id="{{ $language->id }}" {{ $language->is_default ? 'checked' : '' }} 
                                                        {{ $language->is_default ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-check-sm form-switch">
                                                    <input class="form-check-input toggle-status" type="checkbox" role="switch" 
                                                        data-id="{{ $language->id }}" {{ $language->is_active ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-outline-white platform-toggle {{ $language->web_enabled ? 'active' : '' }}" 
                                                        data-id="{{ $language->id }}" data-platform="web">Web</button>
                                                    <button class="btn btn-sm btn-outline-white platform-toggle {{ $language->app_enabled ? 'active' : '' }}" 
                                                        data-id="{{ $language->id }}" data-platform="app">App</button>
                                                    <button class="btn btn-sm btn-outline-white platform-toggle {{ $language->admin_enabled ? 'active' : '' }}" 
                                                        data-id="{{ $language->id }}" data-platform="admin">Admin</button>
                                                </div>
                                            </td>
                                            <td class="action-item">
                                               
                                                    <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex rounded-circle p-1 align-items-center justify-content-center btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="isax isax-more"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item rounded-1 edit-language" href="javascript:void(0);" 
                                                                data-bs-toggle="modal" data-bs-target="#edit_language{{ $language->id }}">
                                                                <i class="isax isax-edit me-2"></i>Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item rounded-1 delete-language" href="javascript:void(0);" 
                                                                data-bs-toggle="modal" data-bs-target="#delete_modal{{ $language->id }}">
                                                                <i class="isax isax-trash me-2"></i>Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                               
                                            </td>
                                        </tr>
                                         <!-- Start Edit language Modal  -->
    <!-- Start Edit language Modal  -->
<div id="edit_language{{ $language->id }}" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Language</h4>
                <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div>
            <!-- Updated Action to use Route Helper with ID -->
            <form action="{{ route('language-settings.update', $language->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Added Value to Hidden ID -->
                    <input type="hidden" name="id" value="{{ $language->id }}">
                    
                    <div class="mb-3">
                        <label class="form-label">Language Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $language->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Language Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $language->code) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Flag Icon</label>
                        <!-- Show current flag if exists -->
                        @if($language->flag)
                            <div class="mb-2">
                                <img src="{{ tenant_storage_url($language->flag) }}" alt="Current Flag" style="height: 40px; width: auto;">
                            </div>
                        @endif
                        <input type="file" name="flag" class="form-control" accept="image/*">
                        <small class="text-muted">Leave empty to keep current flag.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Direction</label>
                        <div class="form-check form-switch">
                            <!-- Added Checked Logic -->
                            <input class="form-check-input" type="checkbox" name="is_rtl" value="1" {{ $language->is_rtl ? 'checked' : '' }}>
                            <label class="form-check-label" for="edit_is_rtl">Right-to-Left (RTL)</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Default Language</label>
                        <div class="form-check form-switch">
                            <!-- Added Checked Logic -->
                            <input class="form-check-input" type="checkbox" name="is_default" value="1" {{ $language->is_default ? 'checked' : '' }}>
                            <label class="form-check-label" for="edit_is_default">Set as Default</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <!-- Added Checked Logic -->
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $language->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="edit_is_active">Active</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Enable On Platforms</label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="web_enabled" value="1" {{ $language->web_enabled ? 'checked' : '' }}>
                                <label class="form-check-label" for="edit_web_enabled">Web</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="app_enabled" value="1" {{ $language->app_enabled ? 'checked' : '' }}>
                                <label class="form-check-label" for="edit_app_enabled">App</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="admin_enabled" value="1" {{ $language->admin_enabled ? 'checked' : '' }}>
                                <label class="form-check-label" for="edit_admin_enabled">Admin</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Language</button>
                </div>
            </form>
            <!-- REMOVED: The Edit Link below was incorrectly placed inside the modal -->
        </div>
    </div>
</div>
<!-- End Edit language Modal  -->
    <!-- End Edit language Modal  -->

    <!-- Delete Modal Start -->
    <div class="modal fade" id="delete_modal{{ $language->id }}">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="mb-3">
                                                <img src="assets/img/icons/delete.svg" alt="img">
                                            </div>
                    <h6 class="mb-1">Delete Language</h6>
                    <p class="mb-3">Are you sure you want to delete <span id="delete_language_name" class="fw-bold"></span>?</p>
                    <form action="{{ route('language-settings.destroy', $language->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Yes, Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">No languages found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- Custom Data Table -->
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->

                </div><!-- end col -->
            </div>
            <!-- end row -->

        </div>
        <!-- End Content -->

    </div>

    <!-- ========================
           End Page Content
          ========================= -->

    <!-- Start Add language Modal  -->
    <div id="add_language" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Language</h4>
                    <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-x"></i>
                    </button>
                </div>
                <form action="{{ route('language-settings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Language Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., English" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Language Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control" placeholder="e.g., en" required>
                            <small class="text-muted">ISO 639-1 code (2 letters)</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Flag Icon</label>
                            <input type="file" name="flag" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Direction</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_rtl" id="add_is_rtl" value="1">
                                <label class="form-check-label" for="add_is_rtl">Right-to-Left (RTL)</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Default Language</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_default" id="add_is_default" value="1">
                                <label class="form-check-label" for="add_is_default">Set as Default</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="add_is_active" value="1" checked>
                                <label class="form-check-label" for="add_is_active">Active</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Enable On Platforms</label>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="web_enabled" id="add_web_enabled" value="1" checked>
                                    <label class="form-check-label" for="add_web_enabled">Web</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="app_enabled" id="add_app_enabled" value="1" checked>
                                    <label class="form-check-label" for="add_app_enabled">App</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="admin_enabled" id="add_admin_enabled" value="1" checked>
                                    <label class="form-check-label" for="add_admin_enabled">Admin</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Language</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Add language Modal  -->

   

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ========== Search Functionality ==========
    const searchInput = document.getElementById('searchLanguage');
    const table = document.getElementById('languageTable');
    
    if (searchInput && table) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    

    // ========== Toggle Status (AJAX) ==========
    document.querySelectorAll('.toggle-status').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const id = this.dataset.id;
            const isChecked = this.checked;
            
            fetch(`/admin/language-settings/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: `Language ${isChecked ? 'activated' : 'deactivated'}`,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    this.checked = !isChecked;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update status'
                    });
                }
            })
            .catch(error => {
                this.checked = !isChecked;
                console.error('Error:', error);
            });
        });
    });

    // ========== Toggle RTL (AJAX) ==========
    document.querySelectorAll('.toggle-rtl').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const id = this.dataset.id;
            const isChecked = this.checked;
            
            fetch(`/admin/language-settings/${id}/toggle-rtl`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: `RTL ${isChecked ? 'enabled' : 'disabled'}`,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    this.checked = !isChecked;
                }
            })
            .catch(error => {
                this.checked = !isChecked;
                console.error('Error:', error);
            });
        });
    });

    // ========== Toggle Default (AJAX) ==========
    document.querySelectorAll('.toggle-default').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const id = this.dataset.id;
            const isChecked = this.checked;
            
            if (!isChecked) {
                this.checked = true;
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: 'Cannot unset default language. Set another language as default first.'
                });
                return;
            }
            
            fetch(`/admin/language-settings/${id}/set-default`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update all other checkboxes
                    document.querySelectorAll('.toggle-default').forEach(cb => {
                        if (cb.dataset.id != id) {
                            cb.checked = false;
                            cb.disabled = false;
                        } else {
                            cb.disabled = true;
                        }
                    });
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Default language updated',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    this.checked = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to update default language'
                    });
                }
            })
            .catch(error => {
                this.checked = false;
                console.error('Error:', error);
            });
        });
    });

    // ========== Toggle Platform (AJAX) ==========
    document.querySelectorAll('.platform-toggle').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const platform = this.dataset.platform;
            const isActive = this.classList.contains('active');
            
            fetch(`/admin/language-settings/${id}/toggle-platform/${platform}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.classList.toggle('active');
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: `${platform.toUpperCase()} ${data.enabled ? 'enabled' : 'disabled'}`,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to update'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>
@endsection