@extends('super-admin.layouts.master')

@section('title', 'Reports')

@section('content')
<div class="row g-3">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Total Tenants</div>
            <div class="value">{{ $totals['tenants'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Active</div>
            <div class="value text-success">{{ $totals['active'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Trial</div>
            <div class="value text-primary">{{ $totals['trial'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Suspended</div>
            <div class="value text-danger">{{ $totals['suspended'] }}</div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header"><h6 class="mb-0">Revenue & Growth — Last 6 Months</h6></div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr><th>Month</th><th>MRR</th><th>Revenue</th><th>New Tenants</th><th>Churned</th></tr>
            </thead>
            <tbody>
                @foreach($sixMonths as $month)
                    <tr>
                        <td><strong>{{ $month['label'] }}</strong></td>
                        <td>${{ number_format($month['mrr'], 2) }}</td>
                        <td>${{ number_format($month['revenue'], 2) }}</td>
                        <td>{{ $month['new_tenants'] }}</td>
                        <td>{{ $month['churned'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('super-admin.tenants.index') }}" class="btn btn-outline-primary btn-sm">View Tenants</a>
    <a href="{{ route('super-admin.billing.index') }}" class="btn btn-outline-primary btn-sm">View Billing</a>
</div>
@endsection
