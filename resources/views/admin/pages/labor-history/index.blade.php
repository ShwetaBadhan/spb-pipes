@extends('admin.layout.master')
@section('title', 'Labor History')
@section('content')

    <div class="page-wrapper">
        <div class="content content-two">
            <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <h6>Labor History</h6>
                    <p class="text-muted mb-0">Track all labor cost assignments with detailed history</p>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <a href="{{ route('labor-history.export') . '?' . http_build_query(request()->all()) }}"
                        class="btn btn-success d-flex align-items-center">
                        <i class="isax isax-download me-1"></i>Export to Excel
                    </a>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card position-relative">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                                <div>
                                    <p class="mb-1">Total Cost</p>
                                    <h6 class="fs-16 fw-semibold">₹{{ number_format($summary['total_cost'], 2) }}</h6>
                                </div>
                                <div>
                                    <span class="avatar bg-primary rounded-circle">
                                        <i class="isax isax-receipt-item"></i>
                                    </span>
                                </div>
                            </div>
                            <p class="fs-13 mb-0"><span class="text-success"><i
                                        class="isax isax-send text-success me-1"></i>5.62%</span> from last month</p>
                            <span class="position-absolute end-0 bottom-0">
                                <img src="{{ url('assets/img/bg/card-overlay-01.svg') }}" alt="User Img">
                            </span>
                        </div>
                    </div>


                </div>
                <div class="col-md-3">
                    <div class="card position-relative">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                                <div>
                                    <p class="mb-1">Assignments</p>
                                    <h6 class="fs-16 fw-semibold">{{ $summary['total_assignments'] }}</h6>
                                </div>
                                <div>
                                    <span class="avatar bg-success rounded-circle">
                                        <i class="isax isax-tick-circle"></i>
                                    </span>
                                </div>
                            </div>
                            <p class="fs-13 mb-0"><span class="text-success"><i
                                        class="isax isax-send text-success me-1"></i>11.4%</span> from last month</p>
                            <span class="position-absolute end-0 bottom-0">
                                <img src="{{ url('assets/img/bg/card-overlay-02.svg') }}" alt="User Img">
                            </span>
                        </div><!-- end card body -->
                    </div><!-- end card -->

                </div>
                <div class="col-md-3">
                    <div class="card position-relative">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                                <div>
                                    <p class="mb-1">Production Cost</p>
                                    <h6 class="fs-16 fw-semibold">₹{{ number_format($summary['production_cost'], 2) }}</h6>
                                </div>
                                <div>
                                    <span class="avatar bg-warning rounded-circle">
                                        <i class="isax isax-timer"></i>
                                    </span>
                                </div>
                            </div>
                            <p class="fs-13 mb-0"><span class="text-success"><i
                                        class="isax isax-send text-success me-1"></i>8.52%</span> from last month</p>
                            <span class="position-absolute end-0 bottom-0">
                                <img src="{{ url('assets/img/bg/card-overlay-03.svg') }}" alt="User Img">
                            </span>
                        </div><!-- end card body -->
                    </div><!-- end card -->

                </div>
                <div class="col-md-3">
                    <div class="card position-relative">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                                <div>
                                    <p class="mb-1">Logistics Cost</p>
                                    <h6 class="fs-16 fw-semibold">₹{{ number_format($summary['logistics_cost'], 2) }}</h6>
                                </div>
                                <div>
                                    <span class="avatar bg-danger rounded-circle">
                                        <i class="isax isax-information"></i>
                                    </span>
                                </div>
                            </div>
                            <p class="fs-13 mb-0"><span class="text-danger"><i
                                        class="isax isax-received text-danger me-1"></i>7.45%</span> from last month</p>
                            <span class="position-absolute end-0 bottom-0">
                                <img src="{{ url('assets/img/bg/card-overlay-04.svg') }}" alt="User Img">
                            </span>
                        </div><!-- end card body -->
                    </div><!-- end card -->

                </div>
            </div>



            <!-- History Table -->
            <div class="table-responsive border border-bottom-0 rounded">
                <table class="table table-nowrap m-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Labor Type</th>
                            <th>Category</th>
                            <th>Product</th>
                            <th>Batch</th>
                            <th>Quantity</th>
                            <th>Total Cost</th>
                            <th>Supervisor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $record)
                            <tr>
                                <td>{{ $record->date->format('d M Y') }}</td>
                                <td>{{ $record->laborType->name ?? 'N/A' }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $record->laborType->category == 'production' ? 'success' : 'primary' }}">
                                        {{ ucfirst($record->laborType->category) }}
                                    </span>
                                </td>
                                <td>{{ $record->product->name ?? 'N/A' }}</td>
                                <td>{{ $record->batch_number ?? '-' }}</td>
                                <td>{{ number_format($record->quantity, 2) }}</td>
                                <td><strong>₹{{ number_format($record->total_cost, 2) }}</strong></td>
                                <td>{{ $record->supervisor->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="isax isax-empty-wallet display-4 d-block mb-3"></i>
                                        <p class="mb-0">No labor history found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Showing {{ $history->firstItem() }} to {{ $history->lastItem() }} of {{ $history->total() }} entries
                </div>
                <div>
                    {{ $history->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
