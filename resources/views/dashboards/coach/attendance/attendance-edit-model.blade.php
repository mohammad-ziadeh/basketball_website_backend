<div class="modal fade" id="editAttendanceModal{{ $record->id }}" tabindex="-1" aria-labelledby="editAttendanceModalLabel{{ $record->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAttendanceModalLabel{{ $record->id }}">Edit Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('attendance.update', $record->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="text" class="form-control" value="{{ $record->attendance_date }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Student</label>
                        <input type="text" class="form-control" value="{{ $record->user?->name }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="present" {{ $record->status == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ $record->status == 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="late" {{ $record->status == 'late' ? 'selected' : '' }}>Late</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
