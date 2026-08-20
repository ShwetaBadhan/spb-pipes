@extends('admin.layout.master')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card mt-5">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="isax isax-warning-2 text-warning" style="font-size: 4rem;"></i>
                        </div>

                        <h3 class="mb-3">Subscription Inactive</h3>

                        @if($status === 'expired')
                            <p class="text-muted mb-2">Your subscription has expired.</p>
                        @elseif($status === 'pending')
                            <p class="text-muted mb-2">Your payment is pending. Please complete payment to activate your subscription.</p>
                        @elseif($status === 'canceled')
                            <p class="text-muted mb-2">Your subscription has been canceled.</p>
                        @else
                            <p class="text-muted mb-2">You do not have an active subscription. Please choose a plan to continue.</p>
                        @endif

                        @if($plan)
                            <p class="text-muted mb-4">Current plan: <strong>{{ $plan->name }}</strong></p>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-warning">{{ session('error') }}</div>
                        @endif

                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('billing.plans-billings') }}" class="btn btn-primary">
                                <i class="isax isax-crown-1 me-1"></i> View Plans & Upgrade
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="isax isax-logout me-1"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
