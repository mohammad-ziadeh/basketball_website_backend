<x-app-layout>
    @include('components.alerts')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
        <div class="card">
            <div class="card-header">
                <h4>Take Attendance</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('attendance.store') }}">
                    @csrf

                    <!-- Date -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Attendance Date</label>
                        <input type="date" name="date" id="date" class="form-control"
       value="{{ $date ?? now()->toDateString() }}" required>
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <select name="attendance[{{ $index }}][status]" class="form-select"
                                            required>
                                            <option value="present"
                                                {{ ($existingAttendance[$user->id] ?? '') == 'present' ? 'selected' : '' }}>
                                                Present</option>
                                            <option value="absent"
                                                {{ ($existingAttendance[$user->id] ?? '') == 'absent' ? 'selected' : '' }}>
                                                Absent</option>
                                            <option value="late"
                                                {{ ($existingAttendance[$user->id] ?? '') == 'late' ? 'selected' : '' }}>
                                                Late</option>
                                        </select>
                                        <input type="hidden" name="attendance[{{ $index }}][user_id]"
                                            value="{{ $user->id }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Save Attendance</button>
                        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
