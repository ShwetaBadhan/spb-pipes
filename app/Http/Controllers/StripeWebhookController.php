<?php

namespace App\Http\Controllers;

use App\Models\BillingInvoice;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierWebhookController;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhookController extends CashierWebhookController
{
    /**
     * Handle customer subscription created.
     */
    protected function handleCustomerSubscriptionCreated(array $payload): Response
    {
        $response = parent::handleCustomerSubscriptionCreated($payload);

        $this->syncDomainSubscription($payload);

        return $response;
    }

    /**
     * Handle customer subscription updated.
     */
    protected function handleCustomerSubscriptionUpdated(array $payload): Response
    {
        $response = parent::handleCustomerSubscriptionUpdated($payload);

        $this->syncDomainSubscription($payload);

        return $response;
    }

    /**
     * Handle customer subscription deleted.
     */
    protected function handleCustomerSubscriptionDeleted(array $payload): Response
    {
        $response = parent::handleCustomerSubscriptionDeleted($payload);

        $tenant = $this->resolveTenant($payload);
        $subscription = $tenant?->subscriptions()->where('stripe_id', $payload['data']['object']['id'] ?? null)->first();

        if ($subscription) {
            $subscription->status = 'canceled';
            $subscription->stripe_status = 'canceled';
            $subscription->save();
        }

        if ($tenant) {
            $tenant->update([
                'status' => 'canceled',
                'canceled_at' => now(),
            ]);
        }

        return $response;
    }

    /**
     * Handle invoice payment succeeded.
     */
    protected function handleInvoicePaymentSucceeded(array $payload): Response
    {
        $data = $payload['data']['object'];

        if ($tenant = $this->resolveTenant($payload)) {
            $amount = ($data['amount_paid'] ?? $data['amount_total'] ?? 0) / 100;
            $status = $data['status'] === 'paid' ? 'paid' : 'open';
            $currency = $data['currency'] ?? config('cashier.currency', 'usd');

            $invoice = BillingInvoice::updateOrCreate(
                ['stripe_invoice_id' => $data['id']],
                [
                    'tenant_id' => $tenant->id,
                    'amount' => $amount,
                    'currency' => $currency,
                    'status' => $status,
                    'invoice_date' => Carbon::createFromTimestamp($data['created'] ?? now()->timestamp),
                    'due_date' => isset($data['due_date']) ? Carbon::createFromTimestamp($data['due_date']) : null,
                ]
            );

            $transactionId = $data['payment_intent'] ?? $data['charge'] ?? ('inv_'.$data['id']);
            $paymentId = is_array($transactionId) ? $transactionId['id'] : $transactionId;

            Payment::updateOrCreate(
                ['transaction_id' => $paymentId],
                [
                    'tenant_id' => $tenant->id,
                    'billing_invoice_id' => $invoice->id,
                    'provider' => 'stripe',
                    'amount' => $amount,
                    'currency' => $currency,
                    'status' => 'succeeded',
                    'paid_at' => Carbon::createFromTimestamp($data['created'] ?? now()->timestamp),
                ]
            );

            $tenant->update(['status' => 'active', 'canceled_at' => null]);

            if ($subscription = $tenant->subscriptions()->first()) {
                $subscription->status = 'active';
                $subscription->stripe_status = 'active';
                $subscription->save();
            }
        }

        return $this->successMethod();
    }

    /**
     * Handle invoice payment failed.
     */
    protected function handleInvoicePaymentFailed(array $payload): Response
    {
        $data = $payload['data']['object'];

        if ($tenant = $this->resolveTenant($payload)) {
            $invoice = BillingInvoice::updateOrCreate(
                ['stripe_invoice_id' => $data['id']],
                [
                    'tenant_id' => $tenant->id,
                    'amount' => ($data['amount_due'] ?? 0) / 100,
                    'currency' => $data['currency'] ?? config('cashier.currency', 'usd'),
                    'status' => 'past_due',
                    'invoice_date' => Carbon::createFromTimestamp($data['created'] ?? now()->timestamp),
                    'due_date' => isset($data['due_date']) ? Carbon::createFromTimestamp($data['due_date']) : null,
                ]
            );

            Payment::create([
                'tenant_id' => $tenant->id,
                'billing_invoice_id' => $invoice->id,
                'transaction_id' => 'failed_'.$data['id'],
                'provider' => 'stripe',
                'amount' => ($data['amount_due'] ?? 0) / 100,
                'currency' => $data['currency'] ?? config('cashier.currency', 'usd'),
                'status' => 'failed',
                'paid_at' => null,
            ]);

            if ($subscription = $tenant->subscriptions()->first()) {
                $subscription->status = 'past_due';
                $subscription->stripe_status = 'past_due';
                $subscription->save();
            }
        }

        return $this->successMethod();
    }

    /**
     * Sync our domain subscription (status + plan) with the Stripe payload.
     */
    protected function syncDomainSubscription(array $payload): void
    {
        $tenant = $this->resolveTenant($payload);
        $data = $payload['data']['object'];

        if (! $tenant) {
            return;
        }

        $subscription = $tenant->subscriptions()
            ->where('stripe_id', $data['id'])
            ->first();

        if (! $subscription) {
            return;
        }

        $subscription->status = $this->domainStatus($data['status'] ?? 'past_due');
        $subscription->stripe_status = $data['status'] ?? 'past_due';

        if ($plan = $this->resolvePlan($data)) {
            $subscription->plan_id = $plan->id;
        }

        $subscription->save();

        $tenant->update([
            'status' => $subscription->status,
            'plan_slug' => $subscription->plan?->slug ?? $tenant->plan_slug,
            'canceled_at' => in_array($subscription->status, ['active', 'trial'], true) ? null : $tenant->canceled_at,
        ]);
    }

    /**
     * Map a Stripe subscription status to our domain status.
     */
    protected function domainStatus(string $stripeStatus): string
    {
        return match ($stripeStatus) {
            'trialing' => 'trial',
            'active' => 'active',
            'canceled', 'incomplete_expired' => 'canceled',
            default => 'past_due',
        };
    }

    /**
     * Resolve the Plan from the subscription metadata or the Stripe price id.
     */
    protected function resolvePlan(array $data): ?Plan
    {
        $slug = $data['metadata']['plan_slug'] ?? null;

        if ($slug) {
            $plan = Plan::where('slug', $slug)->first();
            if ($plan) {
                return $plan;
            }
        }

        $price = $data['items']['data'][0]['price']['id'] ?? null;

        if (! $price) {
            return null;
        }

        $priceToSlug = array_flip(array_filter(config('saas.subscription.stripe_price_ids', [])));

        return Plan::where('slug', $priceToSlug[$price] ?? '')->first() ?: null;
    }

    /**
     * Find the Tenant owning the Stripe customer id.
     */
    protected function resolveTenant(array $payload): ?Tenant
    {
        $customerId = $payload['data']['object']['customer'] ?? null;

        if (! $customerId) {
            return null;
        }

        return Tenant::where('stripe_id', $customerId)->first();
    }
}
