@php
    $filteredOrders = isset($statusFilter) ? $orders->where('status', $statusFilter) : $orders;
@endphp

@if($filteredOrders->count() > 0)
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
                @foreach($filteredOrders as $order)
                <tr>
                    <td><strong>{{ $order->order_number }}</strong></td>
                    <td>{{ $order->customer_name }}</td>
                    <td>
                        <span class="badge bg-{{
                            $order->status === 'pending' ? 'warning' : (
                            $order->status === 'confirmed' ? 'info' : (
                            $order->status === 'processing' ? 'primary' : (
                            in_array($order->status, ['shipped', 'delivered']) ? 'success' : (
                            $order->status === 'cancelled' ? 'danger' : 'secondary'
                        ))))
                        }}" id="status-badge-{{ $order->id }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>₹{{ number_format($order->total, 2) }}</td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="action-item">
                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                            <i class="isax isax-more"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center view-order-btn" 
                                   data-bs-toggle="modal" 
                                   data-bs-target="#orderDetailsModal" 
                                   data-order-id="{{ $order->id }}"
                                   data-order-number="{{ $order->order_number }}"
                                   data-customer-name="{{ $order->customer_name }}"
                                   data-customer-phone="{{ $order->customer_phone }}"
                                   data-customer-email="{{ $order->customer_email }}"
                                   data-customer-address="{{ $order->customer_address }}"
                                   data-subtotal="{{ $order->subtotal }}"
                                   data-tax="{{ $order->tax }}"
                                   data-shipping-cost="{{ $order->shipping_cost }}"
                                   data-total="{{ $order->total }}"
                                   data-status="{{ $order->status }}"
                                   data-notes="{{ $order->notes }}"
                                   data-created-at="{{ $order->created_at->format('M d, Y h:i A') }}">
                                    <i class="isax isax-eye me-2"></i>View
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center change-status-btn" 
                                   data-order-id="{{ $order->id }}"
                                   data-current-status="{{ $order->status }}">
                                    <i class="isax isax-edit me-2"></i>Change Status
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal{{ $order->id }}">
                                    <i class="isax isax-trash me-2"></i>Delete
                                </a>
                            </li>
                        </ul>
                    </td>
                      <!-- Start Modal  -->
                            <div class="modal fade" id="delete_modal{{ $order->id }}">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">
                                        
                                            <div class="mb-3">
                                                <img src="{{ url ('assets/img/icons/delete.svg')}}" alt="img">
                                            </div>
                                             <form action="{{ route('admin.orders.destroy', $order->id  )}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            <h6 class="mb-1">Delete Order</h6>
                                            <p class="mb-3">Are you sure, you want to delete Order?</p>
                                            <div class="d-flex justify-content-center">
                                                <a href="javascript:void(0);" class="btn btn-outline-white me-3" data-bs-dismiss="modal">Cancel</a>
                                                <button type="submit" class="btn btn-primary">Yes, Delete</button>
                                            </div>
                                            </form>
                                        </div> <!-- end modal-body -->
                                    </div> <!-- end modal-content -->
                                </div>
                            </div>
                            <!-- End Modal  -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="text-center py-5">
        <div class="text-muted">
            <i data-feather="inbox" class="mb-2" style="width: 64px; height: 64px;"></i>
            <h5 class="mt-3">No orders found</h5>
            <p class="text-muted">There are no orders with this status.</p>
        </div>
    </div>
@endif