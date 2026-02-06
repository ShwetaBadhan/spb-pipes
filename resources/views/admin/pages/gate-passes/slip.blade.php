<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gate Pass Slip - {{ $firstEntry->batch_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }

        .slip-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 5px;
        }

        .header .subtitle {
            font-size: 16px;
            color: #666;
            font-weight: normal;
        }

        .slip-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-box {
            padding: 15px;
            background: #f9f9f9;
            border-left: 4px solid #007bff;
        }

        .info-box.type-inward {
            border-left-color: #28a745;
        }

        .info-box.type-outward {
            border-left-color: #dc3545;
        }

        .info-label {
            font-weight: bold;
            color: #555;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 18px;
            color: #333;
            font-weight: 600;
        }

        .type-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            margin-top: 5px;
        }

        .type-badge.inward {
            background: #d4edda;
            color: #155724;
        }

        .type-badge.outward {
            background: #f8d7da;
            color: #721c24;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 30px 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th {
            background: #007bff;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        table tr:nth-child(even) {
            background: #f9f9f9;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        .total-row {
            font-weight: bold;
            background: #f0f0f0;
        }

        .total-row td:last-child {
            font-size: 20px;
            color: #dc3545;
        }

        .remarks-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .remarks-box .label {
            font-weight: bold;
            color: #856404;
            margin-bottom: 5px;
            display: block;
        }

        .remarks-box .value {
            color: #856404;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #333;
        }

        .signature-box {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-top: 30px;
        }

        .signature {
            text-align: center;
            padding: 40px 10px 10px 10px;
            border-top: 1px solid #333;
        }

        .signature .label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .signature .name {
            color: #666;
        }

        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .print-btn:hover {
            background: #0056b3;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .slip-container {
                box-shadow: none;
                padding: 20px;
            }

            .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <button class="print-btn" onclick="window.print()">
        <i class="fas fa-print"></i> Print Slip
    </button>

    <div class="slip-container">
        <!-- Header -->
        <div class="header">
            <h1>GATE PASS SLIP</h1>
            <p class="subtitle">Vehicle Entry/Exit Authorization</p>
        </div>

        <!-- Slip Information -->
        <div class="slip-info">
            <div class="info-box {{ $firstEntry->type == 'inward' ? 'type-inward' : 'type-outward' }}">
                <div class="info-label">Gate Pass Type</div>
                <div class="info-value">
                    @if ($firstEntry->type == 'inward')
                        <span class="type-badge inward">
                            <i class="fas fa-arrow-down"></i> INWARD
                        </span>
                    @else
                        <span class="type-badge outward">
                            <i class="fas fa-arrow-up"></i> OUTWARD
                        </span>
                    @endif
                </div>
            </div>

            <div class="info-box">
                <div class="info-label">Batch Number</div>
                <div class="info-value">{{ $firstEntry->batch_number }}</div>
            </div>

            <div class="info-box">
                <div class="info-label">Date</div>
                <div class="info-value">{{ $firstEntry->date->format('d-m-Y') }}</div>
            </div>

            <div class="info-box">
                <div class="info-label">Total Products</div>
                <div class="info-value">{{ $gatePasses->count() }}</div>
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="section-title">Product Details</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Labor Type</th>
                    <th>Workers</th>
                    <th>Rate/Worker (₹)</th>
                    <th>Total Cost (₹)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gatePasses as $index => $gp)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $gp->product->name }}</td>
                        <td>{{ $gp->quantity }}</td>
                        <td>{{ $gp->laborType->name }}</td>
                        <td>{{ $gp->workers_count }}</td>
                        <td>{{ number_format($gp->rate_amount, 2) }}</td>
                        <td>{{ number_format($gp->total_cost, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="6" style="text-align: right;"><strong>GRAND TOTAL:</strong></td>
                    <td><strong>₹{{ number_format($totalCost, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Remarks Section -->
        @if ($firstEntry->remarks)
            <div class="section-title">Remarks</div>
            <div class="remarks-box">
                <span class="label">Additional Notes:</span>
                <p class="value">{{ $firstEntry->remarks }}</p>
            </div>
        @endif

        <!-- Footer with Signatures -->
        <div class="footer">
            <div class="signature-box">
                <div class="signature">
                    <div class="label">Prepared By</div>
                    <div class="name">_________________</div>
                </div>
                <div class="signature">
                    <div class="label">Verified By</div>
                    <div class="name">_________________</div>
                </div>
                <div class="signature">
                    <div class="label">Authorized By</div>
                    <div class="name">_________________</div>
                </div>
            </div>

            <div style="margin-top: 30px; color: #666; font-size: 12px;">
                <p>Generated on: {{ now()->format('d-m-Y H:i:s') }}</p>
                <p>Slip ID: GP-{{ $firstEntry->batch_number }}-{{ $firstEntry->date->format('Ymd') }}</p>
            </div>
        </div>
    </div>

    <script>
        // Auto-focus on load for better UX
        window.onload = function() {
            // Optional: Auto-print on load (uncomment if needed)
            // setTimeout(function() {
            //     window.print();
            // }, 1000);
        };
    </script>
</body>

</html>
