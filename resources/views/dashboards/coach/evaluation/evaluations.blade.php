<x-app-layout>
    @include('components.alerts')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
        <div class="card">
            <div class="card-header">
                <h5>Player Evaluations</h5>
            </div>

            <div class="card-body">
                <table id="cbtn-selectors" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Player</th>
                            <th>Evaluator</th>
                            <th>Skill</th>
                            <th>Fitness</th>
                            <th>Discipline</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            @php $evaluation = $user->evaluations->first(); @endphp

                            {{-- Main row --}}
                            <tr data-bs-toggle="collapse" data-bs-target="#notesRow{{ $user->id }}"
                                style="cursor: pointer;">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $evaluation->evaluator->name ?? auth()->user()->name }}</td>
                                <td>
                                    @if ($evaluation)
                                        <div class="progress" style="height: 20px; border-radius: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $evaluation->skill_level * 10 }}%; border-radius: 8px;"
                                                aria-valuenow="{{ $evaluation->skill_level }}" aria-valuemin="0"
                                                aria-valuemax="10">{{ $evaluation->skill_level }}</div>
                                        </div>
                                    @else
                                        Not Evaluated
                                    @endif
                                </td>
                                <td>
                                    @if ($evaluation)
                                        <div class="progress" style="height: 20px; border-radius: 8px;">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: {{ $evaluation->fitness_level * 10 }}%; border-radius: 8px;"
                                                aria-valuenow="{{ $evaluation->fitness_level }}" aria-valuemin="0"
                                                aria-valuemax="10">{{ $evaluation->fitness_level }}</div>
                                        </div>
                                    @else
                                        Not Evaluated
                                    @endif
                                </td>
                                <td>
                                    @if ($evaluation)
                                        <div class="progress" style="height: 20px; border-radius: 8px;">
                                            <div class="progress-bar bg-warning" role="progressbar"
                                                style="width: {{ $evaluation->discipline_level * 10 }}%; border-radius: 8px;"
                                                aria-valuenow="{{ $evaluation->discipline_level }}" aria-valuemin="0"
                                                aria-valuemax="10">{{ $evaluation->discipline_level }}</div>
                                        </div>
                                    @else
                                        Not Evaluated
                                    @endif
                                </td>
                                <td>Click to view</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editEvaluationModal{{ $user->id }}">
                                        Edit
                                    </button>
                                </td>
                            </tr>

                            {{-- Notes sub-row --}}
                            <tr class="collapse bg-light" id="notesRow{{ $user->id }}">
                                <td colspan="8" style="white-space: pre-wrap;">
                                    <strong>Notes:</strong> {{ $evaluation->notes ?? '-' }}
                                </td>
                                <td style="display: none;">

                                </td>
                                <td style="display: none;">

                                </td>
                                <td style="display: none;">

                                </td>
                                <td style="display: none;">

                                </td>
                                <td style="display: none;">

                                </td>
                                <td style="display: none;">

                                </td>
                                <td style="display: none;">

                                </td>
                            </tr>

                            @include('dashboards.coach.evaluation.evaluation-edit-modal', [
                                'user' => $user,
                            ])
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>


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
    <script>
        $(document).ready(function() {


            $('.edit-editModal').click(function() {
                let btn = $(this);
                $('#modalForm').attr('action', btn.data('action'));
                $('#modalMethod').val(btn.data('method'));
                $('#modalUserId').val(btn.data('user-id'));
                $('#modalSkill').val(btn.data('skill'));
                $('#modalFitness').val(btn.data('fitness'));
                $('#modalDiscipline').val(btn.data('discipline'));
                $('#modalNotes').val(btn.data('notes'));
            });
        });
    </script>

</x-app-layout>
