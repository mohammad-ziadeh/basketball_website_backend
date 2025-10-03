<x-app-layout>
    <div class="container mt-4">
        <h2 class="mb-4">My Children’s Attendance</h2>

        @if($children->isEmpty())
            <div class="alert alert-info">No children assigned to you.</div>
        @else
            @foreach($children as $child)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary">
                        <h5 class="mb-0"  style="color: white;">{{ $child->name }} ({{ $child->email }})</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($child->attendance->isEmpty())
                            <p class="p-3 text-muted">No attendance records found.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Marked By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($child->attendance as $record)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($record->attendance_date)->format('M d, Y') }}</td>
                                                <td>
                                                    @if($record->status === 'present')
                                                        <span class="badge bg-success">Present</span>
                                                    @elseif($record->status === 'absent')
                                                        <span class="badge bg-danger">Absent</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ ucfirst($record->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $record->markedBy ? $record->markedBy->name : 'System' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</x-app-layout>
