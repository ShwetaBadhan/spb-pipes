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
        <h6 class="fw-bold mb-0">Integrations</h6>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Integrations Grid -->
    <div class="row">
        @foreach($integrationData as $integration)
       <div class="col-md-6 mb-4">
    <div class="card shadow-none">
        <div class="card-body">
            <div class="d-flex align-items-center border-0 mb-3 pb-0">
                <div class="d-flex align-items-center">
                    <span class="avatar avatar-lg p-2 bg-light rounded flex-shrink-0 me-2">
                        <img src="{{ asset($integration['icon']) }}" alt="{{ $integration['name'] }}">
                    </span>
                    <p class="fw-medium text-gray-9 mb-0">{{ $integration['name'] }}</p>
                </div>
                @if($integration['is_connected'])
                    <span class="badge badge-soft-success ms-auto">Connected</span>
                @endif
            </div>
            <p class="mb-0">{{ $integration['description'] }}</p>
            
            @if($integration['connected_at'])
                <small class="text-muted d-block mt-2">
                    Connected: {{ $integration['connected_at']->format('M d, Y') }}
                </small>
            @endif
        </div>
        
        <div class="card-footer bg-light d-flex align-items-center justify-content-between">
            @if($integration['is_connected'])
                <form action="{{ route('integrations-settings.remove', $integration['key']) }}" 
                      method="POST" 
                      class="d-inline"
                      onsubmit="return confirm('Remove {{ $integration['name'] }} integration?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-dark rounded-2 p-1" title="Remove">
                        <i class="isax isax-trash"></i>
                    </button>
                </form>
            @else
                <a href="{{ route('integrations-settings.connect', $integration['key']) }}" 
                   class="btn btn-sm btn-outline-dark rounded-2 p-1" 
                   title="Connect">
                    <i class="isax isax-link"></i>
                </a>
            @endif
            
            <!-- Toggle Switch -->
            <div class="form-check form-switch mb-0">
                <input type="hidden" name="enabled" value="0">
                <form action="{{ route('integrations-settings.toggle', $integration['key']) }}" 
                      method="POST" 
                      class="d-inline m-0">
                    @csrf
                    <input class="form-check-input m-0" 
                           type="checkbox" 
                           role="switch"
                           id="toggle-{{ $integration['key'] }}"
                           {{ $integration['is_enabled'] ? 'checked' : '' }}
                           {{ !$integration['is_connected'] ? 'disabled title="Connect integration first"' : '' }}
                           onchange="this.form.submit()">
                </form>
            </div>
        </div>
    </div>
</div>
        @endforeach
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script>
// Minimal JS: Only handle disabled state visual feedback
document.addEventListener('DOMContentLoaded', function() {
    // If integration is not connected, show tooltip on toggle
    document.querySelectorAll('.form-switch input[type="checkbox"]:disabled').forEach(function(checkbox) {
        checkbox.closest('.card').querySelector('.card-footer').title = 'Connect integration first to enable';
    });
});
</script>
@endpush