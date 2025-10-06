@foreach ($course->sessions as $session)
    <div class="modal fade" id="editSessionModal{{ $session->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('courses.sessions.update', [$course->id, $session->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Session</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label>Date</label>
                        <input type="date" name="session_date" class="form-control mb-2"
                            value="{{ $session->session_date }}" required>
                        <label>Start Time</label>
                        <input type="time" name="start_time" class="form-control mb-2"
                            value="{{ $session->start_time }}">
                        <label>End Time</label>
                        <input type="time" name="end_time" class="form-control" value="{{ $session->end_time }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
