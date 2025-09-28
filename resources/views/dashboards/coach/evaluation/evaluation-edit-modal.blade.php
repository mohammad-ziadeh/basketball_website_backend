<div class="modal fade" id="editEvaluationModal{{ $user->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editEvaluationModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: #ffffff; border-radius: 8px;">
            <div class="modal-header border-bottom-0" style="padding: 1.5rem 1.5rem 0;">
                <h5 class="modal-title" id="editEvaluationModalLabel{{ $user->id }}"
                    style="color: #000000; font-weight: 600;">
                    Edit Evaluation - {{ $user->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ $evaluation ? route('evaluations.update', $evaluation->id) : route('evaluations.store') }}"
                method="POST">
                @csrf
                @if ($evaluation)
                    @method('PUT')
                @endif

                <div class="modal-body" style="padding: 0 1.5rem 1rem;">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="skill_level" class="form-label">Skill Level</label>
                            <input type="number" name="skill_level" class="form-control" min="0" max="10"
                                value="{{ $evaluation->skill_level ?? '' }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="fitness_level" class="form-label">Fitness Level</label>
                            <input type="number" name="fitness_level" class="form-control" min="0"
                                max="10" value="{{ $evaluation->fitness_level ?? '' }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="discipline_level" class="form-label">Discipline Level</label>
                            <input type="number" name="discipline_level" class="form-control" min="0"
                                max="10" value="{{ $evaluation->discipline_level ?? '' }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" class="form-control">{{ $evaluation->notes ?? '' }}</textarea>
                    </div>
                </div>

                <div class="modal-footer border-top-0 d-flex justify-content-end gap-2"
                    style="padding: 0 1.5rem 1.5rem;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Evaluation</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control {
        font-size: 1rem;
        color: #000;
    }

    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
    }

    .btn {
        font-weight: 500;
    }
</style>
