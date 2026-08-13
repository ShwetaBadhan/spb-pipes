<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\SubscriptionPayment;
use App\Services\BillingGateway;
use App\Services\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Stripe\Webhook;

class WebhookController extends Controller
{
    public function __construct(
        private readonly BillingGateway $gateway,
        private readonly SubscriptionService $subscriptions,
    ) {}

    public function stripe(Request $request): JsonResponse
    {
        $settings = $this->gateway->settings('stripe');

        if (empty($settings['webhook_secret'])) {
            return response()->json(['error' => 'Webhook secret not configured.'], 503);
        }

        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($payload, $signature, $settings['webhook_secret']);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Invalid signature.'], 400);
        }

        if ($event->type !== 'checkout.session.completed') {
            return response()->json(['received' => true]);
        }

        $session = $event->data->object;

        $payment = SubscriptionPayment::query()
            ->where('gateway', 'stripe')
            ->where('gateway_payment_id', $session->id)
            ->where('status', SubscriptionPayment::STATUS_PENDING)
            ->first();

        if ($session->payment_status !== 'paid' || ! $payment) {
            return response()->json(['received' => true]);
        }

        $plan = Plan::query()->find($payment->meta['plan_id'] ?? null);

        if ($plan) {
            $this->subscriptions->activate($payment->tenant_id, $plan, 'stripe', $payment);
        }

        return response()->json(['received' => true]);
    }

    public function razorpay(Request $request): JsonResponse
    {
        $settings = $this->gateway->settings('razorpay');

        if (empty($settings['secret']) || empty($settings['webhook_secret'])) {
            return response()->json(['error' => 'Webhook secret not configured.'], 503);
        }

        $payload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');

        try {
            $expected = hash_hmac('sha256', $payload, $settings['webhook_secret']);
            if (! hash_equals($expected, $signature ?? '')) {
                throw new \Exception('Invalid signature');
            }
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Invalid signature.'], 400);
        }

        $body = json_decode($payload, true);

        if (($body['event'] ?? null) !== 'payment.captured') {
            return response()->json(['received' => true]);
        }

        $orderId = $body['payload']['payment']['entity']['order_id'] ?? null;

        $payment = SubscriptionPayment::query()
            ->where('gateway', 'razorpay')
            ->where('gateway_payment_id', $orderId)
            ->where('status', SubscriptionPayment::STATUS_PENDING)
            ->first();

        if (! $payment) {
            return response()->json(['received' => true]);
        }

        $plan = Plan::query()->find($payment->meta['plan_id'] ?? null);

        if ($plan) {
            $this->subscriptions->activate($payment->tenant_id, $plan, 'razorpay', $payment);
        }

        return response()->json(['received' => true]);
    }
}
