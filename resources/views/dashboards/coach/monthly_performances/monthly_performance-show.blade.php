<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Monthly Records</h5>

                <div class="d-flex align-items-center gap-2">
                    <select id="month-select" class="form-select form-select-sm">
                        <option value="">Select Month</option>
                        @foreach ($monthlyRecords as $record)
                            <option value="{{ $record->id }}">
                                {{ \Carbon\Carbon::createFromDate($record->year, $record->month, 1)->format('F Y') }}
                            </option>
                        @endforeach
                    </select>

                    <button id="download-pdf-btn" class="btn btn-success btn-sm" disabled>
                        Download PDF
                    </button>


                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Month</th>
                            <th>Average Score</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthlyRecords as $record)
                            <tr>
                                <td>{{ $record->year }}</td>
                                <td>{{ \Carbon\Carbon::createFromDate($record->year, $record->month, 1)->format('F') }}
                                </td>
                                <td>{{ $record->average_score }}</td>
                                <td>{{ $record->remarks }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const monthSelect = document.getElementById('month-select');
const downloadBtn = document.getElementById('download-pdf-btn');

monthSelect.addEventListener('change', function() {
    if (this.value) {
        downloadBtn.disabled = false;
        downloadBtn.onclick = () => {
            window.location.href = `/monthly_performances/export/${this.value}`;
        };
    } else {
        downloadBtn.disabled = true;
    }
});

    </script>
</x-app-layout>
