<x-app-layout>

    @include('components.alerts')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">



        <div class="card">
            <div class="card-header">

                <form method="GET" action="{{ route('users.index') }}" style="margin-bottom: 1rem">
                    <div class="row">
                        <div class="col-md-2">
                            <input type="text" name="name" class="form-control" placeholder="Search Name"
                                value="{{ request('name') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="role" class="form-control">
                                <option value="all">All Roles</option>
                                <option value="player" {{ request('role') == 'player' ? 'selected' : '' }}>Player
                                </option>
                                <option value="parent" {{ request('role') == 'parent' ? 'selected' : '' }}>Parent
                                </option>
                                <option value="coach" {{ request('role') == 'coach' ? 'selected' : '' }}>Coach</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="role" class="form-control">
                                <option value="all">All Genders</option>
                                <option value="male" {{ request('role') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ request('role') == 'female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="deleted" class="form-control">
                                <option value="">Active Users</option>
                                <option value="only" {{ request('deleted') == 'only' ? 'selected' : '' }}>Deleted
                                    Users
                                </option>
                                <option value="with" {{ request('deleted') == 'with' ? 'selected' : '' }}>All Users
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <button type="button" class="btn btn-success mb-3" data-toggle="modal"
                                data-target="#createUserModal"
                                style="max-width:150px; margin-top: 1rem; margin-left: 15px;">
                                Add New User
                            </button>
                            <div style=" margin-top: 1rem;">
                                <a href="{{ route('users.index', ['show' => 'all']) }}" class="btn btn-info">Show
                                    All</a>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">Show Pagination</a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="card-body">
                <table id="cbtn-selectors" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Age</th>
                            <th>School</th>
                            <th>Joining Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($showUsers == false)
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        {!! $user->gender === 'male' ? '<i class="fa-solid fa-mars"></i>' : '<i class="fa-solid fa-venus"></i>' !!}
                                        {{ $user->name }}
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->age }}</td>
                                    <td>{{ $user->school }}</td>
                                    <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : 'N/A' }}</td>
                                    <td>
                                        @if (!$user->trashed())
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#editUserModal{{ $user->id }}">Edit</button>
                                            <form id="delete-form-{{ $user->id }}"
                                                action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete({{ $user->id }})">Delete</button>
                                            </form>
                                        @else
                                            <form action="{{ route('users.restore', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm">Restore</button>
                                            </form>
                                            <form id="perDelete-form-{{ $user->id }}"
                                                action="{{ route('users.deletePermanently', $user->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmPerDelete({{ $user->id }})">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>

                                @include('dashboards.admin.user.user-edit-modal', ['user' => $user])
                            @endforeach
                        @else
                            @foreach ($allUsers as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        {!! $user->gender === 'male' ? '<i class="fa-solid fa-mars"></i>' : '<i class="fa-solid fa-venus"></i>' !!}
                                        {{ $user->name }}
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->age }}</td>
                                    <td>{{ $user->school }}</td>
                                    <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : 'N/A' }}</td>
                                    <td>
                                        @if (!$user->trashed())
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#editUserModal{{ $user->id }}">Edit</button>
                                            <form id="delete-form-{{ $user->id }}"
                                                action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete({{ $user->id }})">Delete</button>
                                            </form>
                                        @else
                                            <form action="{{ route('users.restore', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm">Restore</button>
                                            </form>
                                            <form id="perDelete-form-{{ $user->id }}"
                                                action="{{ route('users.deletePermanently', $user->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmPerDelete({{ $user->id }})">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>


                </table>
            </div>
            @if ($showUsers == false)
                @include('components.pagination', ['pag' => $users])
            @endif
        </div>
    </div>

    @include('dashboards.admin.user.user-create-modal')


    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    @endpush

    @push('scripts')
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

        <script>
            $(document).ready(function() {
                $('#cbtn-selectors').DataTable({
                    dom: 'Bfrtip',
                    paging: false,
                    searching: false,
                    info: false,
                    buttons: [{
                            extend: 'copyHtml5',
                            exportOptions: {
                                columns: [0, ':visible']
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions: {
                                columns: [0, 1, 2, 5]
                            }
                        },
                        'colvis'
                    ]
                }).buttons().container().appendTo('#cbtn-selectors_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endpush
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        function confirmPerDelete(id) {
            Swal.fire({
                title: "Delete permanently?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('perDelete-form-' + id).submit();
                }
            });
        }

        $(document).ready(function() {
            setTimeout(() => {
                $('#successMessage').fadeOut('slow');
                $('#errorMessage').fadeOut('slow');
            }, 3000);
        });
    </script>
</x-app-layout>
