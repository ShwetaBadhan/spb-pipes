@extends('central.layout')

@section('title', 'Plans')

@section('content')
    <div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div>
            <h6 class="mb-1">Plans</h6>
            <p class="text-muted fs-14 mb-0">Create and manage subscription plans with per-feature usage limits.</p>
        </div>
        <div class="d-flex align-items-center flex-wrap gap-2">
            <a href="{{ route('central.plans.create') }}" class="btn btn-primary d-inline-flex align-items-center">
                <i class="isax isax-add-square me-1"></i> Add Plan
            </a>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 fs-14">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger py-2 fs-14">{{ $errors->first() }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Price</th>
                            <th>Period</th>
                            <th>Limits</th>
                            <th>Status</th>
                            <th>Default</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($plans as $plan)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $plan->name }}</div>
                                    <code class="text-muted fs-12">{{ $plan->slug }}</code>
                                </td>
                                <td>
                                    @if ($plan->isFree())
                                        <span class="text-success fw-semibold">Free</span>
                                    @else
                                        {{ $plan->currency }} {{ number_format($plan->price) }}
                                    @endif
                                </td>
                                <td class="text-capitalize">{{ $plan->billing_period }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1" style="max-width: 320px;">
                                        @foreach ($plan->limits ?? [] as $key => $limit)
                                            @if ($limit >= 0)
                                                <span class="badge bg-secondary-subtle text-secondary">{{ $key }}: {{ $limit }}</span>
                                            @endif
                                        @endforeach
                                        @if (collect($plan->limits ?? [])->contains(fn ($v) => $v < 0))
                                            <span class="badge bg-success-subtle text-success">unlimited</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if ($plan->is_active)
                                        <span class="badge bg-success-subtle text-success">Active</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($plan->is_default)
                                        <span class="badge bg-primary-subtle text-primary">Default</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('central.plans.edit', $plan) }}" class="btn btn-sm btn-soft-primary">Edit</a>
                                    <form action="{{ route('central.plans.toggle', $plan) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-soft-{{ $plan->is_active ? 'danger' : 'success' }}">
                                            {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('central.plans.destroy', $plan) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this plan? Only possible if no tenant is subscribed to it.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No plans yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
