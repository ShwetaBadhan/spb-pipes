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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            padding: 20px;
            background: #f8f9fa;
            color: #333;
        }

        .slip-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 25px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }

        .header {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }

        .field {
            display: flex;
            flex-direction: column;
        }

        .field-label {
            font-weight: 600;
            font-size: 14px;
            color: #555;
            margin-bottom: 3px;
            text-align: left;
        }

        .field-value {
            border-bottom: 1px dotted #777;
            padding-bottom: 5px;
            min-height: 20px;
            font-size: 15px;
            color: #333;
        }

        .field-value.bold {
            font-weight: 600;
            color: #222;
        }

        .slip-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
        }

        .slip-table th {
            border: 1px solid #ddd;
            padding: 10px 8px;
            text-align: left;
            background: #f5f5f5;
            font-weight: 600;
            color: #444;
        }

        .slip-table td {
            border: 1px solid #ddd;
            padding: 10px 8px;
            font-size: 14px;
        }

        .slip-table tr:nth-child(even) {
            background: #fcfcfc;
        }

        .slip-table tr:last-child td {
            border-bottom: none;
        }

        .signature-section {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 15px;
            margin-top: 40px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .signature-box {
            text-align: center;
        }

        .signature-label {
            font-weight: 600;
            margin-bottom: 10px;
            color: #555;
            font-size: 14px;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            height: 25px;
            margin: 8px 0;
        }

        .signature-name {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }

        .total-row {
            font-weight: bold;
            background: #f8f9fa;
        }

        .total-row td {
            border-top: 2px solid #000;
        }

        .total-value {
            font-size: 16px;
            color: #d32f2f;
            text-align: center;
        }

        .print-btn {
            position: fixed;
            top: 15px;
            right: 15px;
            background: #1976d2;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .print-btn:hover {
            background: #1565c0;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #222;
            margin: 20px 0 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }

        .slip-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .slip-header h1 {
            font-size: 28px;
            margin-bottom: 5px;
            color: #1a237e;
            letter-spacing: 1px;
        }

        .slip-header p {
            font-size: 16px;
            color: #555;
            font-weight: 500;
        }

        @media print {
            .print-btn {
                display: none;
            }
            
            body {
                padding: 0;
                background: white;
            }
            
            .slip-container {
                box-shadow: none;
                border: none;
                padding: 15px;
                max-width: 100%;
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
        <div class="slip-header">
            <h1>GATE PASS SLIP</h1>
            <p>Vehicle Entry/Exit Authorization</p>
        </div>

        <div class="header">
           
            <div class="field">
                <div class="field-label">Date</div>
                <div class="field-value">{{ $firstEntry->date->format('d-m-Y') }}</div>
            </div>
          
            <div class="field">
                <div class="field-label">Name of Party</div>
                <div class="field-value bold">{{ $firstEntry->customer->name ?? 'N/A' }}</div>
            </div>
        <div class="field">
    <div class="field-label">Address of the Party</div>
    <div class="field-value">
        {{ $firstEntry->customer->billing_address ?? 'N/A' }},
        @if($firstEntry->customer->billingCityRelation)
            {{ $firstEntry->customer->billingCityRelation->name }}, 
        @else
            N/A, 
        @endif
        @if($firstEntry->customer->billingStateRelation)
            {{ $firstEntry->customer->billingStateRelation->name }} 
        @else
            N/A - 
        @endif
        {{ $firstEntry->customer->pincode ?? '' }}
    </div>
</div>
            <div class="field">
                <div class="field-label">Purpose</div>
                <div class="field-value">
                    @if($firstEntry->type == 'inward')
                        Material Delivery / Inward Gate Pass
                    @else
                        Material Dispatch / Outward Gate Pass
                    @endif
                </div>
            </div>

            <div class="field">
                <div class="field-label">Batch Number</div>
                <div class="field-value bold">{{ $firstEntry->batch_number }}</div>
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="section-title">Product Details</div>
        <table class="slip-table">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Drq. No/Code No. & Other specification</th>
                    <th>Description of the Items</th>
                    <th>U/M</th>
                    <th>Quantity</th>
                    <th>Approx Value (Rs.)</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gatePasses as $index => $gp)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $gp->product->code ?? 'N/A' }}</td>
                        <td>{{ $gp->product->name }}</td>
                        <td>Unit</td>
                        <td>{{ $gp->quantity }}</td>
                        <td>{{ number_format($gp->total_cost, 2) }}</td>
                        <td></td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="5" style="text-align: right; font-weight: bold;">GRAND TOTAL:</td>
                    <td class="total-value">₹{{ number_format($totalCost, 2) }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-label">Initiator</div>
                <div class="signature-line"></div>
                <div class="signature-name">Signature</div>
                <div class="signature-line"></div>
                <div class="signature-name">Name</div>
                <div class="signature-line"></div>
                <div class="signature-name">Designation</div>
            </div>
            
            <div class="signature-box">
                <div class="signature-label">Authorised Signatory</div>
                <div class="signature-line"></div>
                <div class="signature-name">Signature</div>
                <div class="signature-line"></div>
                <div class="signature-name">Name</div>
                <div class="signature-line"></div>
                <div class="signature-name">Designation</div>
            </div>
            
            <div class="signature-box">
                <div class="signature-label">Received by</div>
                <div class="signature-line"></div>
                <div class="signature-name">Signature</div>
                <div class="signature-line"></div>
                <div class="signature-name">Name</div>
                <div class="signature-line"></div>
                <div class="signature-name">(Representative of the Party)</div>
            </div>
            
            <div class="signature-box">
                <div class="signature-label">Security Department</div>
                <div class="signature-line"></div>
                <div class="signature-name">Out at _______ (Time)</div>
                <div class="signature-line"></div>
                <div class="signature-name">On _______ (Date)</div>
                <div class="signature-line"></div>
                <div class="signature-name">Signature</div>
                <div class="signature-line"></div>
                <div class="signature-name">Name</div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 25px; color: #666; font-size: 12px;">
            <p>Generated on: {{ now()->format('d-m-Y H:i:s') }}</p>
            <p>Slip ID: GP-{{ $firstEntry->batch_number }}-{{ $firstEntry->date->format('Ymd') }}</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            // Optional: Auto-print on load (uncomment if needed)
            // setTimeout(function() {
            //     window.print();
            // }, 1000);
        };
    </script>
</body>
</html>