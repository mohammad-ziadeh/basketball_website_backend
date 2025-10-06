<x-app-layout>
    @include('components.alerts')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
        <div class="card">
            <div class="card-header">
                <h4>Take Attendance</h4>
            </div>
            <div class="card-body">
                <!-- Filter form: GET request to reload page -->
                <form method="GET" class="mb-4">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="course" class="form-label">Select Course</label>
            <select name="course_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Select Course --</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ ($courseId ?? '') == $course->id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="session" class="form-label">Select Session</label>
            <select name="session_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Select Session --</option>
                @foreach ($sessions as $session)
                    <option value="{{ $session->id }}" {{ ($sessionId ?? '') == $session->id ? 'selected' : '' }}>
                        {{ $session->session_date }}
                        @if ($session->start_time && $session->end_time)
                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $session->start_time)->format('g:i A') }}
                            →
                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $session->end_time)->format('g:i A') }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</form>


                <!-- Attendance form -->
                <form method="POST" action="{{ route('attendance.store') }}">
                    @csrf

                    <input type="hidden" name="course_id" value="{{ $courseId ?? '' }}">
                    <input type="hidden" name="session_id" value="{{ $sessionId ?? '' }}">

                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="attendanceTable">
                            @forelse ($users as $index => $user)
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
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Select a course to show players
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($users->count() > 0)
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Save Attendance</button>
                            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

  
</x-app-layout>
