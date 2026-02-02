<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Test PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        .content {
            margin-top: 30px;
            padding: 20px;
            background: #f5f5f5;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>✅ PDF Export is Working!</h1>
    
    <div class="content">
        <h3>Test Report</h3>
        <p>This is a simple test PDF to verify that DomPDF is working correctly.</p>
        <p><strong>Date:</strong> {{ date('Y-m-d') }}</p>
        <p><strong>Time:</strong> {{ date('H:i:s') }}</p>
    </div>
</body>
</html>