<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Monthly Performance Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 20px; color: #333; }
        h2, h3 { text-align: center; margin-bottom: 10px; }
        p { margin: 5px 0; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 13px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; }
        tfoot td { font-weight: bold; background-color: #e0e0e0; }
    </style>
</head>
<body>
    <h2>Monthly Performance Report</h2>

    <p><strong>Player:</strong> {{ $monthlyPerformance->player->name }}</p>
    <p><strong>Month:</strong> {{ \Carbon\Carbon::createFromDate($monthlyPerformance->year, $monthlyPerformance->month, 1)->format('F Y') }}</p>
    <p><strong>Average Score:</strong> {{ round($average, 2) }}</p>
    <p><strong>Remarks:</strong> {{ $monthlyPerformance->remarks ?? 'N/A' }}</p>

    <h3>Sessions Summary</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Score</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sessions as $key => $session)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($session->session_date)->format('d-m-Y') }}</td>
                    <td>{{ $session->score }}</td>
                    <td>{{ $session->remarks ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td colspan="2">{{ $total }}</td>
            </tr>
            <tr>
                <td colspan="2">Average</td>
                <td colspan="2">{{ round($average, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
