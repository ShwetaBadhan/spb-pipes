@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
<div class="content">
<div class="row justify-content-center">
<div class="col-xl-12">
<div class="row settings-wrapper d-flex">

<!-- Sidebar -->
<div class="col-xl-3 col-lg-4">
    @include('admin.components.settings-sidebar')
</div>

<!-- Main Content -->
<div class="col-xl-9 col-lg-8">
    <div class="mb-3 pb-3 border-bottom">
        <h6 class="fw-bold mb-0">Notifications</h6>
    </div>

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

    <form action="{{ route('notifications-settings.update') }}" method="POST">
        @csrf
        
        @foreach($notificationData as $categoryKey => $category)
        <div class="border-bottom mb-3 pb-2">
            <div class="card-title-head d-flex align-items-center justify-content-between">
                <h6 class="fs-16 fw-semibold mb-3 d-flex align-items-center">
                    <span class="fs-16 me-2 p-1 rounded bg-dark text-white d-inline-flex align-items-center justify-content-center">
                        <i class="isax {{ $category['icon'] }}"></i>
                    </span> 
                    {{ $category['label'] }}
                </h6>
                <div class="form-check form-switch">
                    <!-- Hidden input ensures value is sent when unchecked -->
                    <input type="hidden" name="category_{{ $categoryKey }}_enabled" value="0">
                    <input class="form-check-input category-toggle" 
                           type="checkbox" 
                           name="category_{{ $categoryKey }}_enabled" 
                           value="1"
                           {{ $category['is_category_enabled'] ? 'checked' : '' }}
                           data-category="{{ $categoryKey }}"
                           onchange="this.form.submit()">
                </div>
            </div>
            
            <div class="mb-0">
                <div class="table-responsive table-nowrap notification-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="fs-14">Modules</th>
                                <th class="fs-14 text-center">Email</th>
                                <th class="fs-14 text-center">SMS</th>
                                <th class="fs-14 text-center">In App</th>
                                <th class="fs-14 text-center">Whatsapp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category['items'] as $item)
                            <tr class="{{ !$category['is_category_enabled'] ? 'opacity-50' : '' }}">
                                <td>
                                    <h6 class="fs-13 fw-medium mb-1">{{ $item['label'] }}</h6>
                                    <p class="fs-12 text-muted">{{ $item['desc'] }}</p>
                                </td>
                                <td class="text-center">
                                    <input type="hidden" name="{{ $categoryKey }}_{{ $item['key'] }}_email" value="0">
                                    <input class="form-check-input notification-channel" 
                                           type="checkbox" 
                                           name="{{ $categoryKey }}_{{ $item['key'] }}_email"
                                           value="1"
                                           {{ $item['channel_email'] ? 'checked' : '' }}
                                           {{ !$category['is_category_enabled'] ? 'disabled' : '' }}>
                                </td>
                                <td class="text-center">
                                    <input type="hidden" name="{{ $categoryKey }}_{{ $item['key'] }}_sms" value="0">
                                    <input class="form-check-input notification-channel" 
                                           type="checkbox" 
                                           name="{{ $categoryKey }}_{{ $item['key'] }}_sms"
                                           value="1"
                                           {{ $item['channel_sms'] ? 'checked' : '' }}
                                           {{ !$category['is_category_enabled'] ? 'disabled' : '' }}>
                                </td>
                                <td class="text-center">
                                    <input type="hidden" name="{{ $categoryKey }}_{{ $item['key'] }}_inapp" value="0">
                                    <input class="form-check-input notification-channel" 
                                           type="checkbox" 
                                           name="{{ $categoryKey }}_{{ $item['key'] }}_inapp"
                                           value="1"
                                           {{ $item['channel_inapp'] ? 'checked' : '' }}
                                           {{ !$category['is_category_enabled'] ? 'disabled' : '' }}>
                                </td>
                                <td class="text-center">
                                    <input type="hidden" name="{{ $categoryKey }}_{{ $item['key'] }}_whatsapp" value="0">
                                    <input class="form-check-input notification-channel" 
                                           type="checkbox" 
                                           name="{{ $categoryKey }}_{{ $item['key'] }}_whatsapp"
                                           value="1"
                                           {{ $item['channel_whatsapp'] ? 'checked' : '' }}
                                           {{ !$category['is_category_enabled'] ? 'disabled' : '' }}>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach

        <div class="d-flex align-items-center justify-content-between settings-bottom-btn mt-0">
            <a href="{{ url()->previous() }}" class="btn btn-outline-white me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script>
// Minimal JS: Only handle category toggle visual feedback
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.category-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const category = this.dataset.category;
            const section = this.closest('.border-bottom');
            const channels = section.querySelectorAll('.notification-channel');
            
            channels.forEach(function(channel) {
                channel.disabled = !this.checked;
                // Optional: uncheck channels when category is disabled
                if (!this.checked) channel.checked = false;
            }, this);
        });
    });
});
</script>
@endpush