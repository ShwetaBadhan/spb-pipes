  <!-- Summary Cards -->
  <div class="row mb-4">
      <div class="col-md-3">
          <div class="card position-relative">
              <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                      <div>
                          <p class="mb-1">Total Cost</p>
                          <h6 class="fs-16 fw-semibold">₹{{ number_format($data['total_cost'], 2) }}</h6>
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
                          <h6 class="fs-16 fw-semibold">{{ $data['total_assignments'] }}</h6>
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
                          <h6 class="fs-16 fw-semibold">₹{{ number_format($data['production_cost'], 2) }}</h6>
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
                          <h6 class="fs-16 fw-semibold">₹{{ number_format($data['logistics_cost'], 2) }}</h6>
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

  <!-- Top Labor Types -->
  <div class="card mb-3">
      <div class="card-body">
          <h6 class="card-title">Top 5 Labor Types by Cost</h6>
          <div class="table-responsive">
              <table class="table table-hover">
                  <thead>
                      <tr>
                          <th>Labor Type</th>
                          <th>Category</th>
                          <th>Total Cost</th>
                          <th>% of Total</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($data['top_labor_types'] as $item)
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
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  </div>

  <!-- Top Products -->
  <div class="card">
      <div class="card-body">
          <h6 class="card-title">Top 5 Products by Labor Cost</h6>
          <div class="table-responsive">
              <table class="table table-hover">
                  <thead>
                      <tr>
                          <th>Product</th>
                          <th>Total Cost</th>
                          <th>% of Total</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($data['top_products'] as $item)
                          <tr>
                              <td>{{ $item->product->name ?? 'N/A' }}</td>
                              <td><strong>₹{{ number_format($item->total_cost, 2) }}</strong></td>
                              <td>{{ $data['total_cost'] > 0 ? number_format(($item->total_cost / $data['total_cost']) * 100, 2) : 0 }}%
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  </div>
