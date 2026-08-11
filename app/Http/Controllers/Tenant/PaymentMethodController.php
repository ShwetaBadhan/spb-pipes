<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentMethodController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $tenant = currentTenant();
        abort_if(! $tenant, 404);

        $data = $request->validate([
            'payment_method_id' => ['required', 'string'],
        ]);

        try {
            $tenant->addPaymentMethod($data['payment_method_id']);
            $tenant->updateDefaultPaymentMethod($data['payment_method_id']);
        } catch (\Throwable $e) {
            Log::error('Payment method add failed: '.$e->getMessage());

            return back()->with('error', 'Unable to save this payment method.');
        }

        return back()->with('success', 'Payment method saved.');
    }

    public function setDefault(Request $request, string $paymentMethodId): RedirectResponse
    {
        $tenant = currentTenant();
        abort_if(! $tenant, 404);

        try {
            $tenant->updateDefaultPaymentMethod($paymentMethodId);
        } catch (\Throwable $e) {
            Log::error('Set default payment method failed: '.$e->getMessage());

            return back()->with('error', 'Unable to set default payment method.');
        }

        return back()->with('success', 'Default payment method updated.');
    }

    public function destroy(string $paymentMethodId): RedirectResponse
    {
        $tenant = currentTenant();
        abort_if(! $tenant, 404);

        try {
            $method = $tenant->findPaymentMethod($paymentMethodId);
            $method?->delete();
        } catch (\Throwable $e) {
            Log::error('Remove payment method failed: '.$e->getMessage());

            return back()->with('error', 'Unable to remove payment method.');
        }

        return back()->with('success', 'Payment method removed.');
    }
}
