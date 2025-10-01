<x-app-layout>
    @include('components.alerts')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
        <div class="card">
            <div class="tree" style="padding: 10%; margin: auto;">
                <ul>
                    <li>
                        <a href="#" style="font-size: 39px">{{ $parent->name }}</a>

                        <ul>
                            @foreach ($parent->children as $child)
                                <li>
                                    <a style="font-size: 39px" href="#">{{ $child->name }}</a>
                                </li>
                            @endforeach
                            <li>
                                <a style="font-size: 30px; color: cadetblue;" data-bs-toggle="modal"
                                    data-bs-target="#assignChildrenModal{{ $parent->id }}">
                                    Assign Child
                                </a>
                            </li>
                        </ul>

                        <!-- Modal -->
                        <div class="modal fade" id="assignChildrenModal{{ $parent->id }}" tabindex="-1"
                            aria-labelledby="assignChildrenModalLabel{{ $parent->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="assignChildrenModalLabel{{ $parent->id }}">
                                            Assign Players to Parent: {{ $parent->name }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
                                        <input type="text" class="form-control mb-3" placeholder="Search players..."
                                            id="playerSearch{{ $parent->id }}">

                                        <form method="POST"
                                            action="{{ route('parent-child.updateChildren', $parent->id) }}">
                                            @csrf
                                            <div id="playerList{{ $parent->id }}"
                                                style="max-height: 400px; overflow-y: auto;">
                                                @foreach ($allPlayers as $player)
                                                    <div class="form-check mb-2 player-item">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="children[]" value="{{ $player->id }}"
                                                            id="player{{ $player->id }}"
                                                            {{ $player->parent_id == $parent->id ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="player{{ $player->id }}">
                                                            {{ $player->name }} ({{ $player->email }})
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="d-flex justify-content-end mt-4">
                                                <button type="submit" class="btn btn-primary">Save Assignments</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <a href="{{ route('users.index') }}" class="btn btn-secondary" style="width: 150px; margin: 20px;">
                Back to Users
            </a>
        </div>
    </div>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .tree ul {
            padding-top: 20px;
            position: relative;
        }

        .tree li {
            float: left;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;
        }

        .tree li::before,
        .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 1px solid #ccc;
            width: 50%;
            height: 20px;
        }

        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 1px solid #ccc;
        }

        .tree li:only-child::after,
        .tree li:only-child::before {
            display: none;
        }

        .tree li:only-child {
            padding-top: 0;
        }

        .tree li:first-child::before,
        .tree li:last-child::after {
            border: 0 none;
        }

        .tree li:last-child::before {
            border-right: 1px solid #ccc;
            border-radius: 0 5px 0 0;
        }

        .tree li:first-child::after {
            border-radius: 5px 0 0 0;
        }

        .tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 1px solid #ccc;
            width: 0;
            height: 20px;
        }

        .tree li a {
            border: 1px solid #ccc;
            padding: 5px 10px;
            text-decoration: none;
            color: #666;
            font-family: Arial, Verdana, Tahoma;
            font-size: 12px;
            display: inline-block;
            border-radius: 5px;
            transition: all 0.5s;
        }

        .tree li a:hover,
        .tree li a:hover+ul li a {
            background: #c8e4f8;
            color: #000;
            border: 1px solid #94a0b4;
        }

        .tree li a:hover+ul li::after,
        .tree li a:hover+ul li::before,
        .tree li a:hover+ul::before,
        .tree li a:hover+ul ul::before {
            border-color: #94a0b4;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('playerSearch{{ $parent->id }}');
            const playerList = document.getElementById('playerList{{ $parent->id }}');
            const players = playerList.getElementsByClassName('player-item');

            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                Array.from(players).forEach(function(player) {
                    const label = player.querySelector('label').innerText.toLowerCase();
                    player.style.display = label.includes(query) ? '' : 'none';
                });
            });
        });
    </script>
</x-app-layout>
