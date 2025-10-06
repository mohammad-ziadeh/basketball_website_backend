<x-app-layout>
    @include('components.alerts')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Courses</h3>
            <button class="btn btn-success d-flex align-items-center gap-1" data-bs-toggle="modal"
                data-bs-target="#createCourseModal">
                <i class="bi bi-plus-lg"></i> Create Course
            </button>
        </div>

        @if ($courses->isEmpty())
            <div class="alert alert-info text-center">
                No courses found.
            </div>
        @else
            <div class="row g-4">
                @foreach ($courses as $course)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100 border-0 course-card">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold mb-2">{{ $course->name }}</h5>
                                <p class="text-muted mb-1">
                                    <i class="bi bi-person-badge"></i>
                                    <strong>Coach:</strong> {{ $course->coach?->name ?? '-' }}
                                </p>
                                <p class="text-muted mb-3">
                                    <i class="bi bi-calendar-range"></i>
                                    <strong>Duration:</strong> {{ $course->start_date }} → {{ $course->end_date }}
                                </p>

                                <div class="d-flex justify-content-between mt-auto gap-1 flex-wrap">
                                    <button class="btn btn-outline-primary btn-sm flex-grow-1" data-bs-toggle="collapse"
                                        data-bs-target="#sessions-{{ $course->id }}">
                                        <i class="bi bi-calendar-event"></i> Sessions
                                    </button>

                                    <button type="button" class="btn btn-outline-secondary btn-sm flex-grow-1"
                                        data-bs-toggle="modal" data-bs-target="#editCourseModal{{ $course->id }}">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>

                                    <form id="delete-form-{{ $course->id }}"
                                        action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                        class="flex-grow-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm w-100"
                                            onclick="confirmDelete({{ $course->id }})">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>

                                {{-- Sessions Collapse --}}
                                <div class="collapse mt-3" id="sessions-{{ $course->id }}">
                                    <div class="border-top pt-2">
                                        <h6 class="fw-bold mb-2">Sessions</h6>

                                        <form action="{{ route('courses.sessions.store', $course->id) }}"
                                            method="POST" class="d-flex gap-2 mb-2">
                                            @csrf
                                            <input type="date" name="session_date"
                                                class="form-control form-control-sm" required>
                                            <input type="time" name="start_time"
                                                class="form-control form-control-sm">
                                            <input type="time" name="end_time" class="form-control form-control-sm">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </form>

                                        @if ($course->sessions->isEmpty())
                                            <p class="text-muted small">No sessions yet.</p>
                                        @else
                                            <ul class="list-group list-group-flush">
                                                @foreach ($course->sessions as $session)
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                        <div>
                                                            <strong>{{ $session->session_date }}</strong><br>
                                                            <small>
                                                                {{ \Carbon\Carbon::parse($session->start_time)->format('g:i A') }}
                                                                →
                                                                {{ \Carbon\Carbon::parse($session->end_time)->format('g:i A') }}
                                                            </small>
                                                        </div>
                                                        <div>
                                                            <button type="button"
                                                                class="btn btn-outline-secondary btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editSessionModal{{ $session->id }}">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>

                                                            <form
                                                                action="{{ route('courses.sessions.destroy', [$course->id, $session->id]) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-outline-danger btn-sm"
                                                                    onclick="return confirm('Delete this session?')">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </li>
                                                @endforeach

                                            </ul>
                                        @endif
                                    </div>
                                </div>
                                {{-- End Sessions --}}
                            </div>
                        </div>
                    </div>

                    {{-- Edit Session Modals --}}
                    @foreach ($course->sessions as $session)
                        @include('dashboards.coach.courses.sessions.session-edit-modal', [
                            'course' => $course,
                            'session' => $session,
                        ])
                    @endforeach

                    {{-- Edit Course Modal --}}
                    @include('dashboards.coach.courses.course-edit-modal', ['course' => $course])
                @endforeach
            </div>
        @endif
    </div>

    @include('dashboards.coach.courses.course-create-modal')

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <style>
            /* Card hover effect */
            .course-card {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                border-radius: 12px;
            }

            .course-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            }

            /* Session list scroll */
            .max-h-200 {
                max-height: 200px;
                overflow-y: auto;
            }

            /* Buttons */
            .btn-outline-primary,
            .btn-outline-secondary,
            .btn-outline-danger {
                border-radius: 8px;
            }

            /* Card title */
            .card-title {
                font-size: 1.2rem;
            }

            @media (max-width: 768px) {
                .card-title {
                    font-size: 1rem;
                }
            }
        </style>
    @endpush

    @push('scripts')
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

            $(document).ready(function() {
                setTimeout(() => {
                    $('#successMessage').fadeOut('slow');
                    $('#errorMessage').fadeOut('slow');
                }, 3000);
            });
        </script>
    @endpush
</x-app-layout>
