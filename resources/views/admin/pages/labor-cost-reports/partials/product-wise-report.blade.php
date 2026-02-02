<div class="card">
    <div class="card-body">
        <h6 class="card-title">Labor Cost by Product</h6>
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Top Products by Labor Cost</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Total Cost</th>
                                        <th>Percentage</th>
                                        <th>Avg. Cost/Assignment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['products'] as $product)
                                        <tr>
                                            <td>{{ $product->product->name ?? 'N/A' }}</td>
                                            <td><strong>₹{{ number_format($product->total_cost, 2) }}</strong></td>
                                            <td>{{ $data['total_cost'] > 0 ? number_format(($product->total_cost / $data['total_cost']) * 100, 2) : 0 }}%
                                            </td>
                                            <td>₹{{ number_format($product->total_cost / max(1, $product->assignments_count), 2) }}
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
                        <h5 class="card-title">Product Cost Distribution</h5>
                        <div class="chart-container">
                            <canvas id="productChart" height="100"></canvas>
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
                                        <span class="avatar bg-success rounded-circle">
                                            <i class="isax isax-tick-circle"></i>
                                        </span>
                                    </div>
                                </div>
                                <p class="fs-13 mb-0"><span class="text-success"><i
                                            class="isax isax-send text-success me-1"></i>11.4%</span> from last month
                                </p>
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
                                        <p class="mb-1">Total Products</p>
                                        <h6 class="fs-16 fw-semibold">{{ $data['products']->count() }}</h6>
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
                                        <p class="mb-1">Top Product</p>
                                        <h6 class="fs-16 fw-semibold">
                                            {{ $data['products']->first()->product->name ?? 'N/A' }}</h6>
                                    </div>
                                    <div>
                                        <span class="avatar bg-danger rounded-circle">
                                            <i class="isax isax-information"></i>
                                        </span>
                                    </div>
                                </div>
                                <p class="fs-13 mb-0"><span class="text-danger"><i
                                            class="isax isax-received text-danger me-1"></i>7.45%</span> from last month
                                </p>
                                <span class="position-absolute end-0 bottom-0">
                                    <img src="{{ url('assets/img/bg/card-overlay-04.svg') }}" alt="User Img">
                                </span>
                            </div><!-- end card body -->
                        </div><!-- end card -->


                    </div>
                    <div class="col-md-3">
                        <div class="card position-relative">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                                    <div>
                                        <p class="mb-1">Top Product Cost</p>
                                        <h6 class="fs-16 fw-semibold">
                                            ₹{{ number_format($data['products']->first()->total_cost, 2) }}</h6>
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('productChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach ($data['products'] as $product)
                            "{{ $product->product->name ?? 'N/A' }}",
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Labor Cost (₹)',
                        data: [
                            @foreach ($data['products'] as $product)
                                {{ $product->total_cost }},
                            @endforeach
                        ],
                        backgroundColor: 'rgba(52, 152, 219, 0.8)',
                        borderColor: 'rgba(52, 152, 219, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Cost₹)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endpush
