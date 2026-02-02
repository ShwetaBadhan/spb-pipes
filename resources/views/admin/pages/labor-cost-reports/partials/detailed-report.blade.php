
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
                                    <h6 class="fs-16 fw-semibold">₹{{ number_format($data['summary']['total_cost'], 2) }}</h6>
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
                                    <h6 class="fs-16 fw-semibold">{{ $data['summary']['total_assignments'] }}</h6>
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
                                    <p class="mb-1">Total Quantity</p>
                                    <h6 class="fs-16 fw-semibold">{{ number_format($data['summary']['total_quantity'], 2) }}</h6>
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
                                    <p class="mb-1">Avg. Cost/Assignment</p>
                                    <h6 class="fs-16 fw-semibold">₹{{ number_format($data['summary']['total_cost'] / max(1, $data['summary']['total_assignments']), 2) }}</h6>
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
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h6 class="card-title">Detailed Labor Cost Report</h6>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Labor Type</th>
                        <th>Category</th>
                        <th>Product</th>
                        <th>Batch Number</th>
                        <th>Quantity</th>
                        <th>Rate Amount</th>
                        <th>Total Cost</th>
                        <th>Supervisor</th>
                        <th>Workers</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['records'] as $record)
                        <tr>
                            <td>{{ $record->date->format('d M Y') }}</td>
                            <td>{{ $record->laborType->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $record->laborType->category == 'production' ? 'success' : 'primary' }}">
                                    {{ ucfirst($record->laborType->category) }}
                                </span>
                            </td>
                            <td>{{ $record->product->name ?? 'N/A' }}</td>
                            <td>{{ $record->batch_number ?? '-' }}</td>
                            <td>{{ number_format($record->quantity, 2) }}</td>
                            <td>₹{{ number_format($record->rate_amount, 2) }}</td>
                            <td><strong>₹{{ number_format($record->total_cost, 2) }}</strong></td>
                            <td>{{ $record->supervisor->name ?? '-' }}</td>
                            <td>{{ $record->workers_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
