<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }
        .invoice-number {
            font-size: 16px;
            color: #666;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .info-box {
            width: 48%;
        }
        .info-box h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }
        .info-box p {
            margin: 5px 0;
            font-size: 12px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table th {
            background-color: #333;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 12px;
        }
        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
        }
        .totals {
            margin-left: auto;
            width: 40%;
        }
        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        .totals-row.total {
            font-weight: bold;
            font-size: 16px;
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
        }
        .notes {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .notes h3 {
            font-size: 14px;
            margin-bottom: 10px;
            color: #333;
        }
        .notes p {
            font-size: 11px;
            color: #555;
            line-height: 1.5;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-paid {
            background-color: #d4edda;
            color: #155724;
        }
        .status-unpaid {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div>
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-number">Invoice #{{ $invoice->invoice_number }}</div>
            </div>
            <div>
                <div class="status-badge status-{{ $invoice->status }}">
                    {{ ucfirst($invoice->status) }}
                </div>
            </div>
        </div>

        <!-- Invoice Details & Customer Info -->
        <div class="info-section">
            <div class="info-box">
                <h3>Invoice Details</h3>
                <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
                <p><strong>Issued On:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</p>
                <p><strong>Due Date:</strong> {{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') : 'N/A' }}</p>
                @if($invoice->reference_number)
                    <p><strong>Reference:</strong> {{ $invoice->reference_number }}</p>
                @endif
            </div>
            <div class="info-box">
                <h3>Billing To</h3>
                <p><strong>{{ $invoice->customer->name ?? 'N/A' }}</strong></p>
                <p>{{ $invoice->customer->address ?? 'Address not available' }}</p>
                @if($invoice->customer->phone)
                    <p><strong>Phone:</strong> {{ $invoice->customer->phone }}</p>
                @endif
                @if($invoice->customer->email)
                    <p><strong>Email:</strong> {{ $invoice->customer->email }}</p>
                @endif
                @if($invoice->customer->gst_number)
                    <p><strong>GST:</strong> {{ $invoice->customer->gst_number }}</p>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Rate</th>
                    <th>Discount</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $itemCount = 1; @endphp
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $itemCount++ }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->unit ?? 'Pcs' }}</td>
                    <td>₹{{ number_format($item->rate, 2) }}</td>
                    <td>{{ number_format($item->discount_percent ?? 0, 2) }}%</td>
                    <td>₹{{ number_format($item->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <div class="totals-row">
                <span>Subtotal:</span>
                <span>₹{{ number_format($invoice->subtotal, 2) }}</span>
            </div>
            
            @foreach($invoice->taxes as $tax)
            <div class="totals-row">
                <span>{{ $tax->tax_name }}:</span>
                <span>₹{{ number_format($tax->tax_amount, 2) }}</span>
            </div>
            @endforeach
            
            @if($invoice->shipping_cost > 0)
            <div class="totals-row">
                <span>Shipping Cost:</span>
                <span>₹{{ number_format($invoice->shipping_cost, 2) }}</span>
            </div>
            @endif
            
            @if($invoice->discount_amount > 0)
            <div class="totals-row">
                <span>Discount:</span>
                <span class="text-danger">-₹{{ number_format($invoice->discount_amount, 2) }}</span>
            </div>
            @endif
            
            @if($invoice->round_off && abs($invoice->round_off_amount) > 0.01)
            <div class="totals-row">
                <span>Round Off:</span>
                <span>{{ $invoice->round_off_amount > 0 ? '+' : '' }}₹{{ number_format($invoice->round_off_amount, 2) }}</span>
            </div>
            @endif
            
            <div class="totals-row">
                <span><strong>Total Tax:</strong></span>
                <span><strong>₹{{ number_format($invoice->total_tax, 2) }}</strong></span>
            </div>
            
            <div class="totals-row total">
                <span>Grand Total:</span>
                <span>₹{{ number_format($invoice->grand_total, 2) }}</span>
            </div>
            
            <div class="totals-row">
                <span>Total in Words:</span>
                <span>{{ convertNumberToWords($invoice->grand_total) }} Rupees Only</span>
            </div>
        </div>

        <!-- Notes -->
        @if($invoice->notes || $invoice->terms)
        <div class="notes">
            @if($invoice->notes)
            <h3>Notes</h3>
            <p>{{ $invoice->notes }}</p>
            @endif
            
            <h3>Terms & Conditions</h3>
            <ul style="padding-left: 20px; margin: 10px 0;">
                <li>All charges are final and include applicable taxes, fees, and additional costs.</li>
                <li>Payment is due within {{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->diffInDays($invoice->invoice_date) : '30' }} days of invoice date.</li>
                <li>Late payments may incur additional charges.</li>
                <li>Please reference invoice number when making payment.</li>
            </ul>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Dreams Technologies Pvt Ltd., 15 Hodges Mews, High Wycombe HP12 3JL, United Kingdom</p>
            <p>Phone: +1 54664 75945 | Email: info@kanakku.com | GST: 243E45767889</p>
            <p style="margin-top: 10px; font-size: 9px; color: #999;">
                Generated on: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}
            </p>
        </div>
    </div>
</body>
</html>