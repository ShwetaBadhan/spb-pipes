@extends('admin.layout.master')
@section('content')
    <!-- ========================
       Start Page Content
      ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            @endif

            @if (session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '{{ session('error') }}',
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            @endif

            @if (request()->query('checkout') === 'success')
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Checkout Complete!',
                        text: 'Your subscription is being processed.',
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            @endif

            <!-- start row -->
            <div class="row justify-content-center">

                <div class="col-xl-12">

                    <!-- start row -->
                    <div class="row settings-wrapper d-flex">

                        <!-- Start settings sidebar -->
                        <div class="col-xl-3 col-lg-4">
                            @include('admin.components.settings-sidebar')
                        </div><!-- end col -->
                        <!-- End settings sidebar -->

                        <div class="col-xl-9 col-lg-8">
                            <div class="mb-3">
                                <div class="pb-3 border-bottom mb-3">
                                    <h6 class="mb-0">Plans & Billings</h6>
                                </div>

                                <!-- Current Plan -->
                                <div class="d-flex align-items-center mb-3">
                                    <span class="bg-dark avatar avatar-sm me-2 flex-shrink-0"><i class="isax isax-info-circle fs-14"></i></span>
                                    <h6 class="fs-16 fw-semibold mb-0">Current Plan Information</h6>
                                </div>

                                <div class="mb-3 border-bottom">
                                    <div class="card shadow-none bg-light">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                                <div>
                                                    <h6 class="fw-bold mb-2 fs-14">
                                                        {{ $tenant->plan?->name ?? ($tenant->plan_slug ? ucfirst($tenant->plan_slug) : 'No Plan') }}
                                                        @if ($tenant->plan)
                                                            <span class="text-muted fw-normal">— ${{ number_format($tenant->plan->price_monthly, 2) }}/mo</span>
                                                        @endif
                                                    </h6>
                                                    <span class="badge badge-soft-info d-inline-flex align-items-center mb-2">
                                                        {{ $tenant->status }}
                                                    </span>
                                                    @if ($tenant->status === 'trial' && $tenant->trial_ends_at)
                                                        <div class="fs-14 text-muted">
                                                            {{ $tenant->trial_ends_at->greaterThan(now()) ? 'Trial ends in ' . $tenant->trial_ends_at->diffForHumans() : 'Trial ended ' . $tenant->trial_ends_at->diffForHumans() }}
                                                        </div>
                                                    @elseif ($tenant->subscription?->ends_at)
                                                        <div class="fs-14 text-muted">
                                                            Subscription {{ $tenant->subscription->status }} — ends {{ $tenant->subscription->ends_at->format('M d, Y') }}
                                                        </div>
                                                    @elseif ($tenant->plan)
                                                        <div class="fs-14 text-muted">Active monthly subscription</div>
                                                    @endif
                                                </div>
                                                <div class="d-flex gap-2">
                                                    @if ($tenant->status === 'canceled')
                                                        <form method="POST" action="{{ route('tenant.billing.resume') }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-md d-inline-flex align-items-center">
                                                                <i class="isax isax-refresh me-1"></i>Resume
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form method="POST" action="{{ route('tenant.billing.cancel') }}"
                                                              onsubmit="return confirm('Cancel your subscription? You can resume anytime.');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-soft-danger btn-md">Cancel</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Usage vs limits -->
                                            <div class="row mt-3">
                                                @php
                                                    $rows = [
                                                        'Users' => ['used' => $usage['users'], 'max' => $limits['users']],
                                                        'Products' => ['used' => $usage['products'], 'max' => $limits['products']],
                                                        'Invoices' => ['used' => $usage['invoices'], 'max' => $limits['invoices']],
                                                    ];
                                                @endphp
                                                @foreach ($rows as $label => $row)
                                                    <div class="col-md-4 mb-2">
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <span class="fs-14 text-muted">{{ $label }}</span>
                                                            <span class="fs-14 fw-semibold">
                                                                {{ $row['used'] }}
                                                                @if ($row['max'] !== PHP_INT_MAX)
                                                                    / {{ $row['max'] }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <div class="progress" style="height:6px;">
                                                            @php
                                                                $pct = $row['max'] === PHP_INT_MAX ? 0 : min(100, round($row['used'] / max(1, $row['max']) * 100));
                                                            @endphp
                                                            <div class="progress-bar {{ $pct >= 100 ? 'bg-danger' : 'bg-primary' }}" style="width: {{ $pct }}%;"></div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div>

                                <!-- Available plans -->
                                <div class="row mb-4">
                                    @foreach ($plans as $plan)
                                        <div class="col-md-3 mb-3">
                                            <div class="card shadow-none h-100 {{ $tenant->plan_id === $plan->id ? 'border border-primary' : '' }}">
                                                <div class="card-body">
                                                    <h6 class="fw-bold fs-14 mb-1">
                                                        {{ $plan->name }}
                                                        @if ($tenant->plan_id === $plan->id)
                                                            <span class="badge bg-primary ms-1">Current</span>
                                                        @endif
                                                    </h6>
                                                    <div class="fs-20 fw-bold mb-2">
                                                        @if ($plan->price_monthly !== null)
                                                            ${{ number_format($plan->price_monthly, 0) }}<span class="fs-14 text-muted fw-normal">/mo</span>
                                                        @else
                                                            Custom
                                                        @endif
                                                    </div>
                                                    <ul class="fs-13 text-muted ps-3 mb-2">
                                                        <li>{{ $plan->max_users ?? 'Unlimited' }} users</li>
                                                        <li>{{ $plan->max_products ? number_format($plan->max_products) : 'Unlimited' }} products</li>
                                                        <li>{{ $plan->max_invoices_per_month ? number_format($plan->max_invoices_per_month) : 'Unlimited' }} invoices/mo</li>
                                                    </ul>
                                                    @if ($tenant->plan_id !== $plan->id)
                                                        <form method="POST" action="{{ route('tenant.billing.change') }}">
                                                            @csrf
                                                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                                            <button type="submit" class="btn btn-sm {{ $plan->price_monthly !== null && $plan->price_monthly > ($tenant->plan?->price_monthly ?? 0) ? 'btn-primary' : 'btn-outline-primary' }} w-100">
                                                                {{ $plan->price_monthly !== null && $plan->price_monthly > ($tenant->plan?->price_monthly ?? 0) ? 'Upgrade' : 'Switch' }}
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if (! $stripeConfigured)
                                    <div class="alert alert-info fs-13">
                                        <i class="isax isax-info-circle me-1"></i>
                                        Online payments aren't configured yet (no Stripe keys). Plan changes are applied
                                        directly in test mode. Add Stripe keys in <code>.env</code> to enable real card billing.
                                    </div>
                                @endif

                                <!-- Saved payment methods -->
                                <div class="mb-3 border-top pt-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="bg-dark avatar avatar-sm me-2 flex-shrink-0"><i class="isax isax-card fs-14"></i></span>
                                        <h6 class="fs-16 fw-semibold mb-0">Payment Methods</h6>
                                    </div>

                                    @if ($stripeConfigured && $tenant->hasPaymentMethod())
                                        <div class="row">
                                            @foreach ($tenant->paymentMethods() as $method)
                                                <div class="col-xl-6 mb-3">
                                                    <div class="card shadow-none">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <div>
                                                                    <p class="mb-1">{{ $method->billing_details->name ?? 'Card' }}</p>
                                                                    <h6 class="fs-14 fw-medium mb-1">{{ ucfirst($method->card?->brand ?? 'card') }} •••• {{ $method->card?->last4 }}</h6>
                                                                </div>
                                                                @if ($method->id === $tenant->defaultPaymentMethod()?->id)
                                                                    <span class="badge badge-soft-success ms-auto">Default</span>
                                                                @endif
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                @if ($method->id !== $tenant->defaultPaymentMethod()?->id)
                                                                    <form method="POST" action="{{ route('tenant.billing.payment-methods.default', $method->id) }}">
                                                                        @csrf @method('PATCH')
                                                                        <button class="btn btn-link text-primary text-decoration-underline p-0 fs-14">Set as Default</button>
                                                                    </form>
                                                                @else
                                                                    <span></span>
                                                                @endif
                                                                <form method="POST" action="{{ route('tenant.billing.payment-methods.destroy', $method->id) }}"
                                                                      onsubmit="return confirm('Remove this payment method?');">
                                                                    @csrf @method('DELETE')
                                                                    <button class="btn btn-soft-danger btn-sm"><i class="isax isax-trash"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="fs-14 text-muted">
                                            {{ $stripeConfigured ? 'No saved payment methods yet.' : 'Payment methods will appear here once online billing is configured.' }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Transactions -->
                                <div class="border-top pt-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="bg-dark avatar avatar-sm me-2 flex-shrink-0"><i class="isax isax-transaction-minus fs-14"></i></span>
                                        <h6 class="fs-16 fw-semibold mb-0">Transactions</h6>
                                    </div>
                                    <div class="table-responsive table-nowrap">
                                        <table class="table border mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Plan / Description</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($tenant->billingInvoices as $invoice)
                                                    <tr>
                                                        <td>
                                                            <p class="text-dark mb-0">{{ $invoice->stripe_invoice_id ?? 'Invoice #' . $invoice->id }}</p>
                                                        </td>
                                                        <td>${{ number_format($invoice->amount, 2) }}</td>
                                                        <td>{{ $invoice->invoice_date?->format('M d, Y') ?? '—' }}</td>
                                                        <td>
                                                            <span class="badge badge-soft-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'failed' ? 'danger' : 'warning') }}">
                                                                {{ $invoice->status }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted py-4">
                                                            No transactions yet.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->

                </div><!-- end col -->
            </div>
            <!-- end row -->

        </div>
        <!-- End Content -->

    </div>

    <!-- ========================
       End Page Content
      ========================= -->
@endsection
