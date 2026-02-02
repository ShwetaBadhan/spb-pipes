@extends('admin.layout.master')

@section('content')
  <!-- ========================
         Start Page Content
        ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content content-two">

            <!-- Page Header -->
            <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <h6>Labor Details</h6>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    
                    <div>
                        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                           >
                            <i class="isax isax-add-circle5 me-1"></i>Add Order
                        </a>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        timer: 5000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            @endif

            @if ($errors->any())
                <script>
                    let errorMessages = [];
                    @foreach ($errors->all() as $error)
                        errorMessages.push("{{ $error }}");
                    @endforeach

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: errorMessages.join('<br>'),
                        timer: 6000,
                        timerProgressBar: true,
                        showConfirmButton: true
                    });
                </script>
            @endif

            <div class="table-responsive border border-bottom-0 rounded">
                <table class="table table-nowrap m-0">
                    <thead class="table-light">
                          <tr>
                            <th>Order Number</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                   <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->customer_name }}</td>
                            <td>
                                <span class="badge bg-{{ getStatusBadgeClass($order->status) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>₹{{ number_format($order->total, 2) }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">
                                    <i data-feather="eye"></i>
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i data-feather="inbox" class="mb-2" style="width: 48px; height: 48px;"></i>
                                    <p>No orders found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
            </table>
        </div>



    </div>
    <!-- End Content -->

    </div>

    <!-- ========================
       End Page Content
      ========================= -->
@endsection

@push('scripts')
<script>
function getStatusBadgeClass(status) {
    const classes = {
        'pending': 'warning',
        'confirmed': 'info', 
        'processing': 'primary',
        'shipped': 'success',
        'delivered': 'success',
        'cancelled': 'danger'
    };
    return classes[status] || 'secondary';
}
</script>
@endpush