<div class="modal fade" id="createCourseModal" tabindex="-1" role="dialog" aria-labelledby="createCourseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: #ffffff; border-radius: 8px;">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="createCourseModalLabel" style="color: #000000; font-weight: 600;">
                    Add New Course
                </h5>
            </div>

            <form action="{{ route('courses.store') }}" method="POST">
                @csrf

                <div class="modal-body">
                    {{-- Course details --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Course Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Coach</label>
                            <select name="coach_id" class="form-control">
                                <option value="">-- Select Coach --</option>
                                @foreach ($coaches as $coach)
                                    <option value="{{ $coach->id }}">{{ $coach->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                    </div>

                    {{-- Player assignment --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Assign Players</label>

                        {{-- Search bar --}}
                        <input type="text" id="playerSearchCreate" class="form-control mb-2"
                            placeholder="Search players...">

                        {{-- Scrollable checkbox list --}}
                        <div id="playerListCreate" class="border rounded p-2"
                            style="max-height: 250px; overflow-y: auto; background: #f8f9fa;">
                            @foreach ($players as $player)
                                <div class="form-check mb-1 player-item-create">
                                    <input class="form-check-input" type="checkbox" name="player_ids[]"
                                        value="{{ $player->id }}" id="player_create_{{ $player->id }}">
                                    <label class="form-check-label d-flex justify-content-between align-items-center"
                                        for="player_create_{{ $player->id }}">
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
                    <button type="submit" class="btn btn-success">Create Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Search filtering script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('playerSearchCreate');
        const playerItems = document.querySelectorAll('.player-item-create');

        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            playerItems.forEach(item => {
                const name = item.textContent.toLowerCase();
                item.style.display = name.includes(searchTerm) ? '' : 'none';
            });
        });
    });
</script>
