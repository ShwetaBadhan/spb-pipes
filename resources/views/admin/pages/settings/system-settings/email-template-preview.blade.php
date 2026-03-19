@extends('admin.layout.master')

@section('page-title', 'Preview: ' . $template->name)

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                
                {{-- Back Button --}}
                <div class="mb-3">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        <i class="isax isax-arrow-left-2 me-1"></i> Back to Templates
                    </a>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Template Preview: {{ $template->name }}</h5>
                        <span class="badge bg-{{ $template->category == 'marketing' ? 'info' : ($template->category == 'system' ? 'secondary' : 'success') }}">
                            {{ ucfirst($template->category ?? 'transactional') }}
                        </span>
                    </div>
                    
                    <div class="card-body">
                        {{-- Template Info --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Slug:</strong> {{ $template->slug }}</p>
                                <p class="mb-1"><strong>Status:</strong> 
                                    <span class="badge bg-{{ $template->is_active ? 'success' : 'danger' }}">
                                        {{ $template->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Created:</strong> {{ $template->created_at->format('d M Y') }}</p>
                                <p class="mb-1"><strong>Updated:</strong> {{ $template->updated_at->format('d M Y') }}</p>
                            </div>
                        </div>

                        {{-- Subject Preview --}}
                        <div class="mb-4">
                            <label class="form-label fw-medium">Email Subject</label>
                            <div class="p-3 bg-light rounded border">
                                {{ $rendered['subject'] }}
                            </div>
                        </div>

                        {{-- Body Preview --}}
                        <div class="mb-4">
                            <label class="form-label fw-medium">Email Body</label>
                            <div class="p-4 bg-light rounded border" style="min-height: 300px;">
                                {!! $rendered['body'] !!}
                            </div>
                        </div>

                        {{-- Variables Used --}}
                        @if($template->variables && count($template->variables) > 0)
                        <div class="mb-4">
                            <label class="form-label fw-medium">Available Variables</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($template->variables as $var)
                                    <span class="badge bg-info-subtle text-info border">
                                        {{{ $var }}}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Sample Data Used --}}
                        <div class="alert alert-info">
                            <small>
                                <strong>Note:</strong> This preview uses sample data. 
                                Actual emails will replace variables with real customer/order data.
                            </small>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <a href="{{ route('email-templates') }}" class="btn btn-outline-secondary">
                            Back to List
                        </a>
                        <a href="javascript:void(0);" onclick="window.print()" class="btn btn-primary">
                            <i class="isax isax-printer me-1"></i> Print Preview
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection