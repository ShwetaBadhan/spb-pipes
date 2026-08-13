<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\Tenant;
use App\Services\BillingGateway;
use App\Services\PlanService;
use App\Services\SubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Razorpay\Api\Api;
use Stripe\StripeClient;

class BillingController extends Controller
{
    public function __construct(
        private readonly BillingGateway $gateway,
        private readonly SubscriptionService $subscriptions,
    ) {}

    public function index(): View
    {
        $planService = PlanService::for();
        $plan = $planService->plan();
        $usages = $planService->usages();

        $availablePlans = Plan::query()
            ->active()
            ->when($plan, fn ($query) => $query->whereKeyNot($plan->id))
            ->ordered()
            ->get();

        $payments = SubscriptionPayment::query()
            ->forTenant(tenant()->getTenantKey())
            ->latest()
            ->get();

        $gateways = [
            'stripe' => $this->gateway->isConfigured('stripe'),
            'razorpay' => $this->gateway->isConfigured('razorpay'),
        ];

        return view('admin.pages.settings.general-settings.plans-billings', compact(
            'planService',
            'plan',
            'usages',
            'availablePlans',
            'payments',
            'gateways',
        ));
    }

    public function checkout(Request $request): RedirectResponse|View
    {
        $data = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
            'gateway' => ['required', 'in:stripe,razorpay'],
        ]);

        $plan = Plan::query()->active()->findOrFail($data['plan_id']);
        $tenantId = tenant()->getTenantKey();

        $settings = $this->gateway->settings($data['gateway']);

        if (empty($settings['key']) || empty($settings['secret'])) {
            return back()->with('billing_error', "The {$data['gateway']} gateway is not configured yet. Please contact support.");
        }

        $payment = SubscriptionPayment::create([
            'tenant_id' => $tenantId,
            'gateway' => $data['gateway'],
            'amount' => $plan->price,
            'currency' => $plan->currency,
            'status' => SubscriptionPayment::STATUS_PENDING,
            'meta' => ['plan_id' => $plan->id, 'plan_name' => $plan->name, 'billing_period' => $plan->billing_period],
        ]);

        if ($data['gateway'] === 'stripe') {
            $stripe = new StripeClient($settings['secret']);

            $session = $stripe->checkout->sessions->create([
                'mode' => 'payment',
                'line_items' => [[
                    'price_data' => [
                        'currency' => strtolower($plan->currency),
                        'unit_amount' => (int) round($plan->price * 100),
                        'product_data' => [
                            'name' => "{$plan->name} plan ({$plan->billing_period})",
                            'description' => "One-time payment for the {$plan->billing_period} {$plan->name} plan.",
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'customer_email' => auth()->user()->email,
                'metadata' => [
                    'tenant_id' => (string) $tenantId,
                    'plan_id' => (string) $plan->id,
                    'payment_id' => (string) $payment->id,
                ],
                'success_url' => route('billing.return', ['gateway' => 'stripe', 'status' => 'success', 'payment' => $payment->id]),
                'cancel_url' => route('billing.return', ['gateway' => 'stripe', 'status' => 'cancel', 'payment' => $payment->id]),
            ]);

            $payment->update(['gateway_payment_id' => $session->id]);

            return redirect()->away($session->url);
        }

        $api = new Api($settings['key'], $settings['secret']);

        $order = $api->order->create([
            'amount' => (int) round($plan->price * 100),
            'currency' => $plan->currency,
            'receipt' => "plan_{$plan->id}_{$tenantId}",
            'notes' => [
                'tenant_id' => (string) $tenantId,
                'plan_id' => (string) $plan->id,
                'payment_id' => (string) $payment->id,
            ],
        ]);

        $payment->update(['gateway_payment_id' => $order['id']]);

        return view('admin.pages.settings.general-settings.razorpay-checkout', [
            'plan' => $plan,
            'payment' => $payment,
            'orderId' => $order['id'],
            'razorpayKey' => $settings['key'],
        ]);
    }

    public function return(Request $request): RedirectResponse
    {
        $payment = SubscriptionPayment::query()
            ->forTenant(tenant()->getTenantKey())
            ->where('id', (int) $request->query('payment'))
            ->first();

        if ($request->query('status') !== 'success' || ! $payment) {
            return redirect()->route('billing.plans-billings')->with('billing_error', 'Payment was not completed.');
        }

        $plan = Plan::query()->find($payment->meta['plan_id'] ?? null);

        if (! $plan) {
            return redirect()->route('billing.plans-billings')->with('billing_error', 'Plan not found.');
        }

        $settings = $this->gateway->settings('stripe');

        try {
            $stripe = new StripeClient($settings['secret']);
            $session = $stripe->checkout->sessions->retrieve($payment->gateway_payment_id);

            if ($session->payment_status !== 'paid') {
                return redirect()->route('billing.plans-billings')->with('billing_error', 'Payment was not completed.');
            }

            $this->subscriptions->activate(tenant()->getTenantKey(), $plan, 'stripe', $payment);

            return redirect()->route('billing.plans-billings')->with('billing_success', "You are now on the {$plan->name} plan.");
        } catch (\Throwable $e) {
            return redirect()->route('billing.plans-billings')->with('billing_error', 'Could not confirm payment. If you were charged, it will be applied shortly.');
        }
    }

    public function verifyRazorpay(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'razorpay_payment_id' => ['required', 'string'],
            'razorpay_order_id' => ['required', 'string'],
            'razorpay_signature' => ['required', 'string'],
        ]);

        $payment = SubscriptionPayment::query()
            ->forTenant(tenant()->getTenantKey())
            ->where('gateway', 'razorpay')
            ->where('gateway_payment_id', $data['razorpay_order_id'])
            ->where('status', SubscriptionPayment::STATUS_PENDING)
            ->first();

        if (! $payment) {
            return redirect()->route('billing.plans-billings')->with('billing_error', 'Payment record not found.');
        }

        $plan = Plan::query()->find($payment->meta['plan_id'] ?? null);

        if (! $plan) {
            return redirect()->route('billing.plans-billings')->with('billing_error', 'Plan not found.');
        }

        $settings = $this->gateway->settings('razorpay');

        try {
            $api = new Api($settings['key'], $settings['secret']);
            $api->utility->verifyPaymentSignature([
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'razorpay_order_id' => $data['razorpay_order_id'],
                'razorpay_signature' => $data['razorpay_signature'],
            ]);
        } catch (\Throwable $e) {
            return redirect()->route('billing.plans-billings')->with('billing_error', 'Payment signature verification failed.');
        }

        $this->subscriptions->activate(tenant()->getTenantKey(), $plan, 'razorpay', $payment);

        return redirect()->route('billing.plans-billings')->with('billing_success', "You are now on the {$plan->name} plan.");
    }
}
