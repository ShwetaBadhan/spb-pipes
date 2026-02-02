<div class="card">
    <div class="card-body">
        <h6 class="card-title">Labor Cost by Labor Type</h6>
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Top Labor Types by Cost</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Labor Type</th>
                                        <th>Category</th>
                                        <th>Total Cost</th>
                                        <th>Percentage</th>
                                        <th>Avg. Cost/Assignment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['labor_types'] as $item)
                                        <tr>
                                            <td>{{ $item->laborType->name ?? 'N/A' }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $item->laborType->category == 'production' ? 'success' : 'primary' }}">
                                                    {{ ucfirst($item->laborType->category) }}
                                                </span>
                                            </td>
                                            <td><strong>₹{{ number_format($item->total_cost, 2) }}</strong></td>
                                            <td>{{ $data['total_cost'] > 0 ? number_format(($item->total_cost / $data['total_cost']) * 100, 2) : 0 }}%
                                            </td>
                                            <td>₹{{ number_format($item->total_cost / max(1, $item->assignments_count), 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Labor Type Cost Distribution</h5>
                        <div class="chart-container">
                            <canvas id="laborTypeChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="card mt-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card position-relative">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                                    <div>
                                        <p class="mb-1">Total Cost</p>
                                        <h6 class="fs-16 fw-semibold">₹{{ number_format($data['total_cost'], 2) }}</h6>
                                    </div>
                                    <div>
                                        <span class="avatar bg-warning rounded-circle">
                                            <i class="isax isax-timer"></i>
                                        </span>
                                    </div>
                                </div>
                                <p class="fs-13 mb-0"><span class="text-success"><i
                                            class="isax isax-send text-success me-1"></i>8.52%</span> from last month
                                </p>
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
                                        <p class="mb-1">Total Labor Types</p>
                                        <h6 class="fs-16 fw-semibold">{{ $data['labor_types']->count() }}</h6>
                                    </div>
                                    <div>
                                        <span class="avatar bg-warning rounded-circle">
                                            <i class="isax isax-timer"></i>
                                        </span>
                                    </div>
                                </div>
                                <p class="fs-13 mb-0"><span class="text-success"><i
                                            class="isax isax-send text-success me-1"></i>8.52%</span> from last month
                                </p>
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
                                        <p class="mb-1">Top Labor Type</p>
                                        <h6 class="fs-16 fw-semibold">
                                            {{ $data['labor_types']->first()->laborType->name ?? 'N/A' }}</h6>
                                    </div>
                                    <div>
                                        <span class="avatar bg-warning rounded-circle">
                                            <i class="isax isax-timer"></i>
                                        </span>
                                    </div>
                                </div>
                                <p class="fs-13 mb-0"><span class="text-success"><i
                                            class="isax isax-send text-success me-1"></i>8.52%</span> from last month
                                </p>
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
                                        <p class="mb-1">Top Labor Type Cost</p>
                                        <h6 class="fs-16 fw-semibold">
                                            ₹{{ number_format($data['labor_types']->first()->total_cost, 2) }}</h6>
                                    </div>
                                    <div>
                                        <span class="avatar bg-warning rounded-circle">
                                            <i class="isax isax-timer"></i>
                                        </span>
                                    </div>
                                </div>
                                <p class="fs-13 mb-0"><span class="text-success"><i
                                            class="isax isax-send text-success me-1"></i>8.52%</span> from last month
                                </p>
                                <span class="position-absolute end-0 bottom-0">
                                    <img src="{{ url('assets/img/bg/card-overlay-03.svg') }}" alt="User Img">
                                </span>
                            </div><!-- end card body -->
                        </div><!-- end card -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('laborTypeChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [
                        @foreach ($data['labor_types'] as $item)
                            "{{ $item->laborType->name ?? 'N/A' }}",
                        @endforeach
                    ],
                    datasets: [{
                        data: [
                            @foreach ($data['labor_types'] as $item)
                                {{ $item->total_cost }},
                            @endforeach
                        ],
                        backgroundColor: [
                            @foreach ($data['labor_types'] as $item)
                                @if ($item->laborType->category == 'production')
                                    'rgba(40, 167, 69, 0.8)',
                                @else
                                    'rgba(0, 123, 255, 0.8)',
                                @endif
                            @endforeach
                        ],
                        borderColor: [
                            @foreach ($data['labor_types'] as $item)
                                @if ($item->laborType->category == 'production')
                                    'rgba(40, 167, 69, 1)',
                                @else
                                    'rgba(0, 123, 255, 1)',
                                @endif
                            @endforeach
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@endsection
