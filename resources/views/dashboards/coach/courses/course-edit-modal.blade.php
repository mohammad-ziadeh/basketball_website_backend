<div class="modal fade" id="editCourseModal{{ $course->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editCourseModalLabel{{ $course->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: #ffffff; border-radius: 8px;">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="editCourseModalLabel{{ $course->id }}"
                    style="color: #000000; font-weight: 600;">
                    Edit Course
                </h5>
            </div>

            <form action="{{ route('courses.update', $course->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Course Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $course->name }}"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Coach</label>
                            <select name="coach_id" class="form-control">
                                <option value="">-- Select Coach --</option>
                                @foreach ($coaches as $coach)
                                    <option value="{{ $coach->id }}"
                                        {{ $course->coach_id == $coach->id ? 'selected' : '' }}>
                                        {{ $coach->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_date"
                                value="{{ $course->start_date }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date" value="{{ $course->end_date }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Assign Players</label>

                        <input type="text" id="playerSearch{{ $course->id }}" class="form-control mb-2"
                            placeholder="Search players...">

                        <div id="playerList{{ $course->id }}" class="border rounded p-2"
                            style="max-height: 250px; overflow-y: auto; background: #f8f9fa;">
                            @foreach ($players as $player)
                                <div class="form-check mb-1 player-item{{ $course->id }}">
                                    <input class="form-check-input" type="checkbox" name="player_ids[]"
                                        value="{{ $player->id }}"
                                        id="player_{{ $course->id }}_{{ $player->id }}"
                                        {{ $course->players->contains($player->id) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-between align-items-center"
                                        for="player_{{ $course->id }}_{{ $player->id }}">
                                        <span>{{ $player->name }}</span>
                                        <small class="text-muted">{{ $player->position ?? 'Player' }}</small>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>


                </div>

                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Course</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach ($courses as $course)
            const searchInput{{ $course->id }} = document.getElementById('playerSearch{{ $course->id }}');
            const playerItems{{ $course->id }} = document.querySelectorAll(
                '.player-item{{ $course->id }}');

            if (searchInput{{ $course->id }}) {
                searchInput{{ $course->id }}.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    playerItems{{ $course->id }}.forEach(item => {
                        const name = item.textContent.toLowerCase();
                        item.style.display = name.includes(searchTerm) ? '' : 'none';
                    });
                });
            }
        @endforeach
    });
</script>
