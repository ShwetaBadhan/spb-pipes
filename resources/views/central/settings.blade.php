@extends('central.layout')

@section('title', 'Central Settings')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Platform Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('central.settings.update') }}" method="POST">
                        @csrf
                        @foreach ($fields as $key => $type)
                            <div class="mb-3">
                                <label for="{{ $key }}" class="form-label">{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                                <input type="{{ $type }}" name="{{ $key }}" id="{{ $key }}"
                                    class="form-control" value="{{ old($key, $settings[$key] ?? '') }}">
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
