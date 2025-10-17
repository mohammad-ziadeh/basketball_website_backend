<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Billing Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
            color: #333;
            font-size: 13px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .header h2 {
            margin: 0;
            color: #007bff;
        }

        .summary {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .summary td,
        .summary th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .summary th {
            background: #f8f9fa;
            text-align: left;
        }

        .total {
            background-color: #e9f7ef;
            font-weight: bold;
        }

        .expenses-table {
            width: 100%;
            border-collapse: collapse;
        }

        .expenses-table th,
        .expenses-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .expenses-table th {
            background-color: #f8f9fa;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Billing Report</h2>
        <p><strong>Course:</strong> {{ $billing->course->name }}</p>
        <p><strong>Billing ID:</strong> #{{ str_pad($billing->id, 4, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Date:</strong> {{ $billing->created_at->format('M d, Y') }}</p>
    </div>

    <table class="summary">
        <tr>
            <th>Total Income</th>
            <td>${{ number_format($billing->total_income, 2) }}</td>
        </tr>
        <tr>
            <th>Total Expenses</th>
            <td>${{ number_format($billing->total_expenses, 2) }}</td>
        </tr>
        <tr class="total">
            <th>Final Payment</th>
            <td>${{ number_format($billing->final_payment, 2) }}</td>
        </tr>
    </table>

    <h4 style="margin-bottom: 10px;">Expense Breakdown</h4>
    @if ($billing->expenses->count())
        <table class="expenses-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Expense Name</th>
                    <th>Amount ($)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($billing->expenses as $index => $expense)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $expense->name }}</td>
                        <td>${{ number_format($expense->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="color: #777;">No expenses recorded for this billing.</p>
    @endif

    <div class="footer">
        <p>Generated on {{ now()->format('M d, Y h:i A') }}</p>
        <p>© {{ date('Y') }} Billing Management System</p>
    </div>

</body>

</html>
