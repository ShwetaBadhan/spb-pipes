<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Created</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4f46e5; color: white; padding: 15px; border-radius: 5px 5px 0 0; }
        .content { background: #f9fafb; padding: 20px; border: 1px solid #e5e7eb; border-radius: 0 0 5px 5px; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
        .total { font-weight: bold; font-size: 1.2em; color: #4f46e5; }
        .btn { display: inline-block; background: #4f46e5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>📄 New Invoice Created</h2>
        </div>
        <div class="content">
            <p>Hello Admin,</p>
            <p>A new invoice has been created in the system.</p>
            
            <div class="detail-row"><strong>Invoice Number:</strong> <span>{{ $invoice->invoice_number }}</span></div>
            <div class="detail-row"><strong>Customer:</strong> <span>{{ $invoice->customer->name ?? 'N/A' }}</span></div>
            <div class="detail-row"><strong>Invoice Date:</strong> <span>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</span></div>
            <div class="detail-row"><strong>Due Date:</strong> <span>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</span></div>
            <div class="detail-row"><strong>Status:</strong> <span>{{ ucfirst($invoice->status) }}</span></div>
            <div class="detail-row"><strong>Subtotal:</strong> <span>₹{{ number_format($invoice->subtotal, 2) }}</span></div>
            <div class="detail-row"><strong>Tax:</strong> <span>₹{{ number_format($invoice->total_tax, 2) }}</span></div>
            <div class="detail-row"><strong>Discount:</strong> <span>- ₹{{ number_format($invoice->discount_amount, 2) }}</span></div>
            <div class="detail-row"><strong>Shipping:</strong> <span>₹{{ number_format($invoice->shipping_cost, 2) }}</span></div>
            <div class="detail-row total"><strong>Grand Total:</strong> <span>₹{{ number_format($invoice->grand_total, 2) }}</span></div>
            
            @if($invoice->notes)
                <p><strong>Notes:</strong><br>{{ $invoice->notes }}</p>
            @endif
            
            <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="btn">View Invoice</a>
            
            <p style="margin-top: 20px; font-size: 0.9em; color: #666;">
                This is an automated notification from your Inventory Management System.
            </p>
        </div>
    </div>
</body>
</html>