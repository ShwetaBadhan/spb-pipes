@extends("admin.layout.master")
@section("title", "Invoice Details - " . $invoice->invoice_number)
@section('content')

<!-- start row -->
<div class="page-wrapper">
<div class="row">
    <div class="col-md-10 mx-auto">
        <div>
            <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 mb-3">
                {{-- <h6>
                    <a href="{{ route('admin.invoices') }}">
                        <i class="isax isax-arrow-left me-2"></i>Back to Invoices
                    </a>
                </h6> --}}
                <div class="d-flex align-items-center flex-wrap row-gap-3">
                    {{-- <a href="{{ route('admin.invoices.pdf', $invoice->id) }}" class="btn btn-outline-white d-inline-flex align-items-center me-3">
                        <i class="isax isax-document-like me-1"></i>Download PDF
                    </a>
                    <a href="mailto:{{ $invoice->customer->email ?? '#' }}" class="btn btn-outline-white d-inline-flex align-items-center me-3">
                        <i class="isax isax-message-notif me-1"></i>Send Email
                    </a> --}}
                    <button onclick="window.print()" class="btn btn-outline-white d-inline-flex align-items-center me-3">
                        <i class="isax isax-printer me-1"></i>Print
                    </button>
                    <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="btn btn-primary d-inline-flex align-items-center">
                        <i class="isax isax-edit me-1"></i>Edit Invoice
                    </a>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="bg-light p-4 rounded position-relative mb-3">
                        <div class="position-absolute top-0 end-0 z-0">
                            <img src="{{ url('assets/img/bg/card-bg.png') }}" alt="img">
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between border-bottom flex-wrap mb-3 pb-2 position-relative z-1">
                            <div class="mb-3">
                                <h4 class="mb-1">INVOICE</h4>
                                <div class="d-flex align-items-center flex-wrap row-gap-3">
                                    <div class="me-4">
                                        <h6 class="fs-14 fw-semibold mb-1">Dreams Technologies Pvt Ltd.,</h6>
                                        <p>15 Hodges Mews, High Wycombe HP12 3JL, United Kingdom</p>
                                    </div>
                                    <span>
                                        @if($invoice->status == 'paid')
                                            <img src="{{ url('assets/img/icons/paid.png') }}" alt="Paid" width="48" height="48">
                                        @else
                                            <img src="{{ url('assets/img/icons/not-paid.png') }}" alt="Unpaid" width="48" height="48">
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <img src="{{ url('assets/img/invoice-logo.svg') }}" class="invoice-logo-dark" alt="Logo">
                                <img src="{{ url('assets/img/invoice-logo-white-2.svg') }}" class="invoice-logo-white" alt="Logo">
                            </div>
                        </div>

                        <!-- start row -->
                        <div class="row gy-3 position-relative z-1">
                            <div class="col-lg-4">
                                <div>
                                    <h6 class="mb-2 fs-16 fw-semibold">Invoice Details</h6>
                                    <div>
                                        <p class="mb-1">Invoice Number : <span class="text-dark">{{ $invoice->invoice_number }}</span></p>
                                        <p class="mb-1">Issued On : <span class="text-dark">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</span></p>
                                        <p class="mb-1">Due Date :  
                                            <span class="text-dark">
                                                {{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') : 'N/A' }}
                                            </span>
                                        </p>
                                        @if($invoice->reference_number)
                                            <p class="mb-1">Reference Number : <span class="text-dark">{{ $invoice->reference_number }}</span></p>
                                        @endif
                                        @php
                                            $daysLeft = $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->diffInDays(now(), false) : null;
                                        @endphp
                                        @if($daysLeft !== null)
                                            @if($daysLeft > 0)
                                                <span class="badge bg-success badge-sm">Due in {{ $daysLeft }} days</span>
                                            @elseif($daysLeft == 0)
                                                <span class="badge bg-warning badge-sm">Due today</span>
                                            @else
                                                <span class="badge bg-danger badge-sm">Overdue by {{ abs($daysLeft) }} days</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div><!-- end col -->
                            
                            <div class="col-lg-4">
                                <div>
                                    <h6 class="mb-2 fs-16 fw-semibold">Billing From</h6>
                                    <div>
                                        <h6 class="fs-14 fw-semibold mb-1">K.B. Spun Pipes</h6>
                                        <p class="mb-1">15 Hodges Mews, HP12 3JL, United Kingdom</p>
                                        <p class="mb-1">Phone : +1 54664 75945</p>
                                        <p class="mb-1">Email : <a href="mailto:info@kanakku.com">info@kanakku.com</a></p>
                                        <p class="mb-0">GST : 243E45767889</p>
                                    </div>
                                </div>
                            </div><!-- end col -->
                            
                            <div class="col-lg-4">
                                <div>
                                    <h6 class="mb-2 fs-16 fw-semibold">Billing To</h6>
                                    <div class="bg-white rounded p-3">
                                        <div class="d-flex align-items-center mb-1">
                                            @if($invoice->customer && $invoice->customer->avatar)
                                                <img src="{{ asset('storage/' . $invoice->customer->avatar) }}" alt="{{ $invoice->customer->name }}" class="avatar avatar-lg me-2 rounded-circle">
                                            @else
                                                <span class="avatar avatar-lg bg-primary text-white rounded-circle me-2 flex-shrink-0">
                                                    {{ substr($invoice->customer->name ?? 'N/A', 0, 1) }}
                                                </span>
                                            @endif
                                            <div>
                                                <h6 class="fs-14 fw-semibold">{{ $invoice->customer->name ?? 'N/A' }}</h6>
                                            </div>
                                        </div>
                                        <p class="mb-1">{{ $invoice->customer->address ?? 'Address not available' }}</p>
                                        @if($invoice->customer->phone)
                                            <p class="mb-1">Phone : {{ $invoice->customer->phone }}</p>
                                        @endif
                                        @if($invoice->customer->email)
                                            <p class="mb-1">Email : <a href="mailto:{{ $invoice->customer->email }}">{{ $invoice->customer->email }}</a></p>
                                        @endif
                                        @if($invoice->customer->gst_number)
                                            <p class="mb-0">GST : {{ $invoice->customer->gst_number }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="mb-3">Product / Service Items</h6>
                        <div class="table-responsive rounded border-bottom-0 border table-nowrap">
                            <table class="table m-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-white">#</th>
                                        <th class="text-white">Product/Service</th>
                                        <th class="text-white">Quantity</th>
                                        <th class="text-white">Unit</th>
                                        <th class="text-white">Rate</th>
                                        <th class="text-white">Discount (%)</th>
                                        <th class="text-white">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $itemCount = 1; @endphp
                                    @foreach($invoice->items as $item)
                                    <tr>
                                        <td>{{ $itemCount++ }}</td>
                                        <td class="text-dark">{{ $item->item_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->unit ?? 'Pcs' }}</td>
                                        <td>₹{{ number_format($item->rate, 2) }}</td>
                                        <td>{{ number_format($item->discount_percent ?? 0, 2) }}%</td>
                                        <td>₹{{ number_format($item->amount, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="border-bottom mb-3">
                        <!-- start row -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center p-4 mb-3">
                                    <div class="me-3">
                                        <p class="mb-2">Scan to the pay</p>
                                        <span><img src="{{ url('assets/img/icons/qr.png') }}" alt="QR" width="100"></span>
                                    </div>
                                    <div>
                                        <h6 class="mb-2">Bank Details</h6>
                                        <div>
                                            <p class="mb-1">Bank Name : <span class="text-dark">ABC Bank</span></p>
                                            <p class="mb-1">Account Number : <span class="text-dark">782459739212</span></p>
                                            <p class="mb-1">IFSC Code : <span class="text-dark">ABC0001345</span></p>
                                            <p class="mb-0">Payment Reference : <span class="text-dark">{{ $invoice->invoice_number }}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->
                            
                            <div class="col-lg-6">
                                <div class="mb-3 p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h6 class="fs-14 fw-semibold">Subtotal</h6>
                                        <h6 class="fs-14 fw-semibold">₹{{ number_format($invoice->subtotal, 2) }}</h6>
                                    </div>
                                    
                                    @foreach($invoice->taxes as $tax)
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h6 class="fs-14 fw-semibold">{{ $tax->tax_name }}</h6>
                                        <h6 class="fs-14 fw-semibold">₹{{ number_format($tax->tax_amount, 2) }}</h6>
                                    </div>
                                    @endforeach
                                    
                                    @if($invoice->shipping_cost > 0)
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h6 class="fs-14 fw-semibold">Shipping Cost</h6>
                                        <h6 class="fs-14 fw-semibold">₹{{ number_format($invoice->shipping_cost, 2) }}</h6>
                                    </div>
                                    @endif
                                    
                                    @if($invoice->discount_amount > 0)
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h6 class="fs-14 fw-semibold">Discount</h6>
                                        <h6 class="fs-14 fw-semibold text-danger">-₹{{ number_format($invoice->discount_amount, 2) }}</h6>
                                    </div>
                                    @endif
                                    
                                    @if($invoice->round_off && abs($invoice->round_off_amount) > 0.01)
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h6 class="fs-14 fw-semibold">Round Off</h6>
                                        <h6 class="fs-14 fw-semibold text-{{ $invoice->round_off_amount > 0 ? 'success' : 'danger' }}">
                                            {{ $invoice->round_off_amount > 0 ? '+' : '' }}₹{{ number_format($invoice->round_off_amount, 2) }}
                                        </h6>
                                    </div>
                                    @endif
                                    
                                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                        <h6 class="fs-14 fw-semibold">Total Tax</h6>
                                        <h6 class="fs-14 fw-semibold">₹{{ number_format($invoice->total_tax, 2) }}</h6>
                                    </div>
                                    
                                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                        <h6>Total (INR)</h6>
                                        <h6>₹{{ number_format($invoice->grand_total, 2) }}</h6>
                                    </div>
                                    
                                    <div>
                                        <h6 class="fs-14 fw-semibold mb-1">Total In Words</h6>
                                        <p>{{ convertNumberToWords($invoice->grand_total) }} Rupees Only</p>
                                    </div>
                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>

                    <!-- start row -->
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="mb-3">
                                @if($invoice->notes)
                                <div class="mb-3">
                                    <h6 class="fs-14 fw-semibold mb-1">Notes</h6>
                                    <p>{{ $invoice->notes }}</p>
                                </div>
                                @endif
                                
                                <div>
                                    <h6 class="fs-14 fw-semibold mb-1">Terms and Conditions</h6>
                                    <ul class="mb-0 ps-3">
                                        <li>All charges are final and include applicable taxes, fees, and additional costs.</li>
                                        <li>Payment is due within {{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->diffInDays($invoice->invoice_date) : '30' }} days of invoice date.</li>
                                        <li>Late payments may incur additional charges.</li>
                                        <li>Please reference invoice number when making payment.</li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- end col -->
                        
                        <div class="col-lg-5">
                            <div class="text-lg-end mb-3">
                                <span><img src="{{ url('assets/img/icons/sign.png') }}" class="sign-dark" alt="Signature" width="150"></span>
                                <h6 class="fs-14 fw-semibold mb-1">{{ $invoice->createdBy->name ?? 'Admin' }}</h6>
                                <p>{{ ucfirst($invoice->status ?? 'draft') }} on {{ \Carbon\Carbon::parse($invoice->created_at)->format('d M Y') }}</p>
                            </div>
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="bg-light d-flex align-items-center justify-content-between p-4 rounded card-bg">
                        <div>
                            <h6 class="fs-14 fw-semibold mb-1">Dreams Technologies Pvt Ltd.,</h6>
                            <p class="mb-1">15 Hodges Mews, High Wycombe HP12 3JL, United Kingdom</p>
                            <p class="mb-0">Phone: +1 54664 75945 | Email: info@kanakku.com</p>
                        </div>
                        <div>
                            <img src="{{ url('assets/img/invoice-logo.svg') }}" class="invoice-logo-dark" alt="Logo">
                            <img src="{{ url('assets/img/invoice-logo-white-2.svg') }}" class="invoice-logo-white" alt="Logo">
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>
    </div><!-- end col -->
</div>
<!-- end row -->
</div>


@endsection

@push('scripts')
<script>
// Print functionality
function printInvoice() {
    window.print();
}
</script>
@endpush

@php
// Helper function to convert number to words
function convertNumberToWords($number) {
    $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
    $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
    
    if ($number < 20) {
        return $ones[$number];
    }
    
    if ($number < 100) {
        return $tens[floor($number / 10)] . ' ' . $ones[$number % 10];
    }
    
    if ($number < 1000) {
        return $ones[floor($number / 100)] . ' Hundred ' . convertNumberToWords($number % 100);
    }
    
    if ($number < 100000) {
        return convertNumberToWords(floor($number / 1000)) . ' Thousand ' . convertNumberToWords($number % 1000);
    }
    
    if ($number < 10000000) {
        return convertNumberToWords(floor($number / 100000)) . ' Lakh ' . convertNumberToWords($number % 100000);
    }
    
    return convertNumberToWords(floor($number / 10000000)) . ' Crore ' . convertNumberToWords($number % 10000000);
}
@endphp