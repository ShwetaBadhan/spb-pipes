@extends('admin.layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="card text-center">
                        <div class="card-body py-5">
                            <div class="mb-3">
                                <span class="avatar avatar-lg bg-primary-subtle text-primary"><i class="isax isax-card-tick fs-24"></i></span>
                            </div>
                            <h5 class="fw-bold mb-1">Processing payment for {{ $plan->name }}</h5>
                            <p class="text-muted fs-14 mb-0">
                                {{ $plan->currency }} {{ number_format($plan->price, 2) }} for the {{ $plan->billing_period }} plan.
                                If you are not redirected automatically, click the button below.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const options = {
                key: "{{ $razorpayKey }}",
                order_id: "{{ $orderId }}",
                name: "{{ config('app.name') }}",
                description: "{{ $plan->name }} plan ({{ $plan->billing_period }})",
                amount: {{ (int) round($plan->price * 100) }},
                currency: "{{ $plan->currency }}",
                prefill: {
                    email: "{{ auth()->user()->email }}",
                },
                handler: function (response) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('billing.razorpay.verify') }}";

                    const tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = '_token';
                    tokenInput.value = "{{ csrf_token() }}";
                    form.appendChild(tokenInput);

                    for (const [key, value] of Object.entries(response)) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = value;
                        form.appendChild(input);
                    }

                    document.body.appendChild(form);
                    form.submit();
                },
                modal: {
                    ondismiss: function () {
                        window.location.href = "{{ route('billing.plans-billings') }}";
                    }
                }
            };

            const rzp = new Razorpay(options);
            rzp.open();
        });
    </script>
@endsection
