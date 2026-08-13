@extends('central.layout')

@section('title', 'Add Plan')

@section('content')
    <div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div>
            <h6 class="mb-1">Add Plan</h6>
            <p class="text-muted fs-14 mb-0">Define a new subscription plan with usage limits.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger py-2 fs-14">{{ $errors->first() }}</div>
    @endif

    @include('central.plans._form', ['plan' => new \App\Models\Plan()])
@endsection
