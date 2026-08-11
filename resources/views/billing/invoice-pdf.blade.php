<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; margin: 40px; }
        h1 { font-size: 22px; margin: 0 0 4px; }
        .muted { color: #6b7280; }
        .top { display: flex; justify-content: space-between; margin-bottom: 40px; }
        .from, .to { width: 45%; }
        .card { border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; margin-top: 24px; }
        .row { display: flex; justify-content: space-between; padding: 6px 0; }
        .row.bordered { border-top: 1px solid #e5e7eb; }
        .row.total { border-top: 2px solid #111827; font-weight: bold; font-size: 14px; margin-top: 6px; }
        .badge { display: inline-block; padding: 2px 10px; border-radius: 9999px; font-size: 11px; }
        .badge.paid { background: #dcfce7; color: #166534; }
        .badge.open { background: #fef3c7; color: #92400e; }
        .badge.past_due { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="top">
        <div class="from">
            <h1>{{ config('app.name') }}</h1>
            <p class="muted">SPB Pipes — SaaS Billing</p>
        </div>
        <div class="to" style="text-align: right;">
            <div><strong>{{ $tenant->name }}</strong></div>
            <div class="muted">{{ $tenant->email }}</div>
            <div class="muted">{{ $tenant->phone }}</div>
        </div>
    </div>

    <div class="card">
        <div class="row">
            <span class="muted">Invoice #</span>
            <span>#{{ str_pad((string) $invoice->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="row">
            <span class="muted">Issued</span>
            <span>{{ $invoice->invoice_date ? $invoice->invoice_date->format('M d, Y') : '-' }}</span>
        </div>
        <div class="row">
            <span class="muted">Due</span>
            <span>{{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : '-' }}</span>
        </div>
        <div class="row">
            <span class="muted">Status</span>
            <span><span class="badge {{ $invoice->status }}">{{ ucfirst(str_replace('_', ' ', $invoice->status)) }}</span></span>
        </div>
    </div>

    <div class="card">
        <div class="row bordered">
            <span>{{ $tenant->plan ? $tenant->plan->name : 'Subscription' }} plan</span>
            <span>{{ strtoupper($invoice->currency ?? 'USD') }} {{ number_format($invoice->amount ?? 0, 2) }}</span>
        </div>
        <div class="row total">
            <span>Total</span>
            <span>{{ strtoupper($invoice->currency ?? 'USD') }} {{ number_format($invoice->amount ?? 0, 2) }}</span>
        </div>
    </div>

    <p class="muted" style="margin-top: 32px; font-size: 10px;">
        This is a system-generated invoice for your {{ config('app.name') }} subscription.
    </p>
</body>
</html>
