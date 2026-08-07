<div class="table-responsive mb-3">
    <table class="table table-nowrap datatable">
        <thead class="thead-light">
            <tr>
                <th class="no-sort">
                    <div class="form-check form-check-md">
                        <input class="form-check-input" type="checkbox" id="select-all">
                    </div>
                </th>
                <th class="no-sort">ID</th>
                <th>Customer</th>
                <th>Created On</th>
                <th>Amount</th>
                <th>Paid Amount</th>
                <th>Pending Amount</th>
                <th class="no-sort">Status</th>
                <th>Due Date</th>
                <th class="no-sort">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
            <tr>
                <td>
                    <div class="form-check form-check-md">
                        <input class="form-check-input" type="checkbox">
                    </div>
                </td>
                <td>
                    <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="link-default">
                        {{ $invoice->invoice_number }}
                    </a>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        @if($invoice->customer && $invoice->customer->avatar)
                        <a href="javascript:void(0);" class="avatar avatar-sm rounded-circle me-2 flex-shrink-0">
                            <img src="{{ asset('storage/' . $invoice->customer->avatar) }}" class="rounded-circle" alt="{{ $invoice->customer->name }}">
                        </a>
                        @else
                        <span class="avatar avatar-sm bg-primary text-white rounded-circle me-2 flex-shrink-0">
                            {{ substr($invoice->customer->name ?? 'N/A', 0, 1) }}
                        </span>
                        @endif
                        <div>
                            <h6 class="fs-14 fw-medium mb-0">
                                <a href="javascript:void(0);">
                                    {{ $invoice->customer->name ?? 'N/A' }}
                                </a>
                            </h6>
                        </div>
                    </div>
                </td>
                <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</td>
                <td class="text-dark">₹{{ number_format($invoice->grand_total, 0) }}</td>
                
                {{-- ✅ PAID AMOUNT COLUMN --}}
                <td>
                    @php
                        $paidAmount = $invoice->total_paid ?? 0;
                    @endphp
                    @if($paidAmount > 0)
                        <span class="text-success fw-semibold">
                            ₹{{ number_format($paidAmount, 0) }}
                        </span>
                    @else
                        <span class="text-muted">₹0</span>
                    @endif
                </td>
                
                {{-- ✅ PENDING AMOUNT COLUMN --}}
                <td>
                    @php
                        $pendingAmount = $invoice->pending_amount ?? ($invoice->grand_total - ($invoice->total_paid ?? 0));
                        $isOverdue = $invoice->due_date && 
                                     \Carbon\Carbon::parse($invoice->due_date)->isPast() && 
                                     in_array($invoice->status, ['unpaid', 'partially_paid']);
                    @endphp
                    
                    @if($pendingAmount > 0)
                        <span class="text-danger fw-semibold">
                            ₹{{ number_format($pendingAmount, 0) }}
                        </span>
                        @if($isOverdue)
                            <span class="text-danger ms-1" title="Overdue">
                                <i class="isax isax-danger"></i>
                            </span>
                        @endif
                    @else
                        <span class="text-success fw-semibold">
                            ₹0
                        </span>
                    @endif
                </td>
                
                <td>
                    @php
                        $statusClass = [
                            'paid' => 'success',
                            'unpaid' => 'warning',
                            'draft' => 'info',
                            'overdue' => 'danger',
                            'cancelled' => 'danger',
                            'partially_paid' => 'info',
                            'refunded' => 'success'
                        ][$invoice->status] ?? 'secondary';
                        
                        $statusIcon = [
                            'paid' => 'isax-tick-circle',
                            'unpaid' => 'isax-slash',
                            'draft' => 'isax-note',
                            'overdue' => 'isax-danger',
                            'cancelled' => 'isax-close-circle',
                            'partially_paid' => 'isax-timer',
                            'refunded' => 'isax-money-3'
                        ][$invoice->status] ?? 'isax-information';
                    @endphp
                    <span class="badge badge-soft-{{ $statusClass }} d-inline-flex align-items-center">
                        {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
                        <i class="{{ $statusIcon }} ms-1"></i>
                    </span>
                </td>
                
                <td>
                    @if($invoice->due_date)
                        {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}
                        @if($isOverdue)
                            <span class="text-danger ms-1" title="Overdue">
                                <i class="isax isax-danger"></i>
                            </span>
                        @endif
                    @else
                        N/A
                    @endif
                </td>
                 
                <td class="action-item">
                    <a href="javascript:void(0);" data-bs-toggle="dropdown">
                        <i class="isax isax-more"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-eye me-2"></i>View
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-edit me-2"></i>Edit
                            </a>
                        </li>
                        @if(in_array($invoice->status, ['unpaid', 'partially_paid']))
                        <li>
                            <a href="{{ route('admin.invoices.add-payment', $invoice->id) }}" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-money-3 me-2"></i>Record Payment
                            </a>
                        </li>
                        @endif
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal{{ $invoice->id }}">
                                <i class="isax isax-trash me-2"></i>Delete
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center download-pdf" data-id="{{ $invoice->id }}">
                                <i class="isax isax-document-download me-2"></i>Download PDF
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
            
            <!-- Delete Modal -->
            <div class="modal fade" id="delete_modal{{ $invoice->id }}">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <div class="mb-3">
                                <img src="{{ url ('assets/img/icons/delete.svg')}}" alt="img">
                            </div>
                            <form action="{{ route('admin.invoices.destroy', $invoice->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <h6 class="mb-1">Delete Invoice</h6>
                                <p class="mb-3">Are you sure, you want to delete Invoice?</p>
                                <div class="d-flex justify-content-center">
                                    <a href="javascript:void(0);" class="btn btn-outline-white me-3" data-bs-dismiss="modal">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Yes, Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>