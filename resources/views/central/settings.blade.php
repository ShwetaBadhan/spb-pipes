@extends('central.layout')

@section('title', 'Central Settings')

@section('content')
    <!-- Page Header -->
    <div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div>
            <h6 class="mb-1">Central Settings</h6>
            <p class="text-muted fs-14 mb-0">Platform-wide settings applied across all tenants.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0"><i class="isax isax-setting-2 me-1"></i> Platform Settings</h6>
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success py-2 fs-14">{{ session('status') }}</div>
            @endif

            <form action="{{ route('central.settings.update') }}" method="POST">
                @csrf
                <div class="row g-3">
                    @foreach ($fields as $key => $type)
                        <div class="col-md-6">
                            <label for="{{ $key }}" class="form-label">
                                {{ str_replace('_', ' ', ucwords($key)) }}
                            </label>
                            <input type="{{ $type === 'email' ? 'email' : 'text' }}" name="{{ $key }}"
                                   id="{{ $key }}" class="form-control"
                                   value="{{ old($key, $settings[$key] ?? '') }}">
                            @error($key)
                                <span class="text-danger fs-14">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <hr class="my-4">

                @foreach ($gateways as $gateway)
                    <div class="mb-3">
                        <h6 class="fw-semibold text-capitalize mb-3">{{ $gateway }} Gateway</h6>
                        <div class="row g-3">
                            @php $gatewaySettings = $settings[$gateway] ?? []; @endphp
                            <div class="col-md-4">
                                <label for="{{ $gateway }}_key" class="form-label">Key / Publishable Key</label>
                                <input type="text" name="{{ $gateway }}[key]" id="{{ $gateway }}_key" class="form-control" value="{{ old($gateway . '.key', $gatewaySettings['key'] ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="{{ $gateway }}_secret" class="form-label">Secret Key</label>
                                <input type="password" name="{{ $gateway }}[secret]" id="{{ $gateway }}_secret" class="form-control" value="{{ old($gateway . '.secret', $gatewaySettings['secret'] ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="{{ $gateway }}_webhook_secret" class="form-label">Webhook Secret</label>
                                <input type="password" name="{{ $gateway }}[webhook_secret]" id="{{ $gateway }}_webhook_secret" class="form-control" value="{{ old($gateway . '.webhook_secret', $gatewaySettings['webhook_secret'] ?? '') }}">
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
@endsection
