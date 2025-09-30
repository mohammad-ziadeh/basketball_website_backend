<x-app-layout>
    @include('components.alerts')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">



        <div class="card mb-6">
            <div class="card-header text-black">
                <h5 class="mb-0">Players</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($players as $player)
                            <tr>
                                <td>{{ $player->name }}</td>
                                <td>{{ $player->email }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success select-player-btn"
                                        data-player-id="{{ $player->id }}" data-player-name="{{ $player->name }}">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-6 d-none" id="session-form-card">
            <div class="card-header d-flex justify-content-between align-items-center bg-info text-white">
                <h5 style="color: white;">Add Session Performance for <span id="selected-player-name"></span></h5>
                <button class="btn btn-sm btn-light" id="hide-form-btn">Hide</button>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('session_performances.store') }}">
                    @csrf
                    <input type="hidden" name="player_id" id="selected-player-id">

                    <div class="mb-3">
                        <label for="session_date" class="form-label">Session Date</label>
                        <input type="date" name="session_date" id="session_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="score" class="form-label">Score (0-100)</label>
                        <input type="number" name="score" id="score" class="form-control" min="0"
                            max="100" required>
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Performance</button>
                </form>
            </div>
        </div>

        <div class="card d-none" id="session-table-card">
            <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                <h5 style="color: white;">Recent Session Performances for <span id="selected-player-name-table"></span>
                </h5>
                <button class="btn btn-sm btn-light" id="hide-table-btn">Hide</button>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0" id="session-table">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Score</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        const sessions = @json($sessions);

        const formCard = document.getElementById('session-form-card');
        const tableCard = document.getElementById('session-table-card');

        document.querySelectorAll('.select-player-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const playerId = btn.dataset.playerId;
                const playerName = btn.dataset.playerName;

                formCard.classList.remove('d-none');
                document.getElementById('selected-player-name').textContent = playerName;
                document.getElementById('selected-player-id').value = playerId;

                tableCard.classList.remove('d-none');
                document.getElementById('selected-player-name-table').textContent = playerName;

                const filtered = sessions.filter(s => s.player_id == playerId);
                const tbody = document.querySelector('#session-table tbody');
                tbody.innerHTML = '';

                filtered.forEach(s => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${s.session_date}</td>
                        <td>${s.score}</td>
                        <td>${s.remarks || '-'}</td>
                    `;
                    tbody.appendChild(tr);
                });
            });
        });

        document.getElementById('hide-form-btn').addEventListener('click', () => {
            formCard.classList.add('d-none');
        });

        document.getElementById('hide-table-btn').addEventListener('click', () => {
            tableCard.classList.add('d-none');
        });
    </script>

</x-app-layout>
