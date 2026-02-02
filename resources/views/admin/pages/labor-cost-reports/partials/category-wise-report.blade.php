<!-- resources/views/admin/pages/labor-cost-reports/partials/category-wise-report.blade.php -->

<div class="card">
    <div class="card-body">
        <h6 class="card-title">Labor Cost by Category</h6>
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Cost Distribution</h5>
                        <div class="chart-container">
                             <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Category Summary</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Total Cost</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['categories'] as $category)
                                        <tr>
                                            <td>
                                                <span class="badge bg-{{ $category->category == 'production' ? 'success' : 'primary' }}">
                                                    {{ ucfirst($category->category) }}
                                                </span>
                                            </td>
                                            <td><strong>₹{{ number_format($category->total_cost, 2) }}</strong></td>
                                            <td>
                                                @if(isset($data['total_cost']) && $data['total_cost'] > 0)
                                                    {{ number_format(($category->total_cost / $data['total_cost']) * 100, 2) }}%
                                                @else
                                                    0.00%
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Production vs Logistics Comparison -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Production vs Logistics Comparison</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h3 class="mb-0">
                                    ₹{{ number_format($data['production_cost'] ?? 0, 2) }}
                                </h3>
                                <p class="text-muted mb-0">Production Labor Cost</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h3 class="mb-0">
                                    ₹{{ number_format($data['logistics_cost'] ?? 0, 2) }}
                                </h3>
                                <p class="text-muted mb-0">Logistics Labor Cost</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Production', 'Logistics'],
            datasets: [{
                data: [
                    {{ $data['production_cost'] ?? 0 }},
                    {{ $data['logistics_cost'] ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(0, 123, 255, 0.8)'
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(0, 123, 255, 1)'
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