<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Labor Cost Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 12px;
        }
        .summary-cards {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .card {
            display: table-cell;
            width: 25%;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            vertical-align: top;
        }
        .card h3 {
            margin: 10px 0;
            color: #333;
            font-size: 18px;
        }
        .card p {
            margin: 0;
            color: #666;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 6px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            color: #666;
            font-size: 10px;
        }
        .report-type {
            background-color: #e7f3ff;
            padding: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #2196F3;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Labor Cost Report</h1>
        <p><strong>Period:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        <p><strong>Report Type:</strong> {{ ucfirst(str_replace('-', ' ', $reportType)) }}</p>
        <p><strong>Generated On:</strong> {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}</p>
    </div>

    @if($data['type'] == 'summary')
        <div class="summary-cards">
            <div class="card">
                <h3>₹{{ number_format($data['total_cost'] ?? 0, 2) }}</h3>
                <p>Total Cost</p>
            </div>
            <div class="card">
                <h3>{{ $data['total_assignments'] ?? 0 }}</h3>
                <p>Total Assignments</p>
            </div>
            <div class="card">
                <h3>₹{{ number_format($data['production_cost'] ?? 0, 2) }}</h3>
                <p>Production Cost</p>
            </div>
            <div class="card">
                <h3>₹{{ number_format($data['logistics_cost'] ?? 0, 2) }}</h3>
                <p>Logistics Cost</p>
            </div>
        </div>

        <div class="report-type">
            <h3 style="font-size: 14px;">Top 5 Labor Types by Cost</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Labor Type</th>
                    <th>Category</th>
                    <th>Total Cost</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['top_labor_types'] ?? [] as $item)
                    <tr>
                        <td>{{ $item->laborType->name ?? 'N/A' }}</td>
                        <td>{{ ucfirst($item->laborType->category ?? 'N/A') }}</td>
                        <td>₹{{ number_format($item->total_cost ?? 0, 2) }}</td>
                        <td>{{ ($data['total_cost'] ?? 0) > 0 ? number_format(($item->total_cost / $data['total_cost']) * 100, 2) : 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="report-type" style="margin-top: 20px;">
            <h3 style="font-size: 14px;">Top 5 Products by Labor Cost</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Total Cost</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['top_products'] ?? [] as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'N/A' }}</td>
                        <td>₹{{ number_format($item->total_cost ?? 0, 2) }}</td>
                        <td>{{ ($data['total_cost'] ?? 0) > 0 ? number_format(($item->total_cost / $data['total_cost']) * 100, 2) : 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($data['type'] == 'detailed')
        <div class="report-type">
            <h3 style="font-size: 14px;">Detailed Labor Cost Report</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Labor Type</th>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Batch</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Total Cost</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['records'] ?? [] as $record)
                    <tr>
                        <td>{{ $record->date->format('d M Y') }}</td>
                        <td>{{ $record->laborType->name ?? 'N/A' }}</td>
                        <td>{{ ucfirst($record->laborType->category ?? 'N/A') }}</td>
                        <td>{{ $record->product->name ?? 'N/A' }}</td>
                        <td>{{ $record->batch_number ?? '-' }}</td>
                        <td>{{ number_format($record->quantity ?? 0, 2) }}</td>
                        <td>₹{{ number_format($record->rate_amount ?? 0, 2) }}</td>
                        <td>₹{{ number_format($record->total_cost ?? 0, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary-cards" style="margin-top: 20px;">
            <div class="card">
                <h3>₹{{ number_format($data['summary']['total_cost'] ?? 0, 2) }}</h3>
                <p>Total Cost</p>
            </div>
            <div class="card">
                <h3>{{ $data['summary']['total_assignments'] ?? 0 }}</h3>
                <p>Total Assignments</p>
            </div>
        </div>
    @endif

    @if($data['type'] == 'category-wise')
        <div class="report-type">
            <h3 style="font-size: 14px;">Labor Cost by Category</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Total Cost</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['categories'] ?? [] as $category)
                    <tr>
                        <td>{{ ucfirst($category->category ?? 'N/A') }}</td>
                        <td>₹{{ number_format($category->total_cost ?? 0, 2) }}</td>
                        <td>{{ ($data['total_cost'] ?? 0) > 0 ? number_format(($category->total_cost / $data['total_cost']) * 100, 2) : 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary-cards" style="margin-top: 20px;">
            <div class="card">
                <h3>₹{{ number_format($data['production_cost'] ?? 0, 2) }}</h3>
                <p>Production Cost</p>
            </div>
            <div class="card">
                <h3>₹{{ number_format($data['logistics_cost'] ?? 0, 2) }}</h3>
                <p>Logistics Cost</p>
            </div>
        </div>
    @endif

    @if($data['type'] == 'product-wise')
        <div class="report-type">
            <h3 style="font-size: 14px;">Labor Cost by Product</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Total Cost</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['products'] ?? [] as $product)
                    <tr>
                        <td>{{ $product->product->name ?? 'N/A' }}</td>
                        <td>₹{{ number_format($product->total_cost ?? 0, 2) }}</td>
                        <td>{{ ($data['total_cost'] ?? 0) > 0 ? number_format(($product->total_cost / $data['total_cost']) * 100, 2) : 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($data['type'] == 'labor-type-wise')
        <div class="report-type">
            <h3 style="font-size: 14px;">Labor Cost by Labor Type</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Labor Type</th>
                    <th>Category</th>
                    <th>Total Cost</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['labor_types'] ?? [] as $item)
                    <tr>
                        <td>{{ $item->laborType->name ?? 'N/A' }}</td>
                        <td>{{ ucfirst($item->laborType->category ?? 'N/A') }}</td>
                        <td>₹{{ number_format($item->total_cost ?? 0, 2) }}</td>
                        <td>{{ ($data['total_cost'] ?? 0) > 0 ? number_format(($item->total_cost / $data['total_cost']) * 100, 2) : 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <p>This report was generated automatically by the Labor Cost Management System</p>
        <p>© {{ date('Y') }} All Rights Reserved</p>
    </div>
</body>
</html>