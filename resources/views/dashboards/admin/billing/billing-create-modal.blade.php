<div class="modal fade" id="createBillingModal" tabindex="-1" aria-labelledby="createBillingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm rounded-4">

            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-semibold text-dark" id="createBillingModalLabel">
                    Create Billing
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('billings.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="course_id" class="form-label fw-semibold">Select Course</label>
                        <select name="course_id" id="course_id" class="form-select form-select-sm rounded-3" required>
                            <option value="">Select Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm px-3">
                        Save Billing
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .modal-content {
        border-radius: 1rem !important;
    }

    .modal-header h5 {
        font-size: 1.1rem;
    }

    .modal-footer .btn {
        font-weight: 500;
        border-radius: 0.5rem;
    }

    .modal-footer .btn-outline-secondary {
        color: #6c757d;
        border-color: #dee2e6;
    }

    .modal-footer .btn-outline-secondary:hover {
        background-color: #f8f9fa;
    }

    .modal-footer .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .modal-footer .btn-primary:hover {
        background-color: #0b5ed7;
    }
</style>
