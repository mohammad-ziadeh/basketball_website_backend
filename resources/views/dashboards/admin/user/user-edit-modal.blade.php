<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Added modal-lg -->
        <div class="modal-content" style="background-color: #ffffff; border-radius: 8px;">
            <div class="modal-header border-bottom-0" style="padding: 1.5rem 1.5rem 0;">
                <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}"
                    style="color: #000000; font-weight: 600;">
                    Edit User
                </h5>
            </div>

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body" style="padding: 0 1.5rem 1rem;">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label" style="color: #000000;">Full Name</label>
                            <input type="text" class="form-control" name="name"
                                value="{{ old('name', $user->name) }}" required
                                style="border: 1px solid #ced4da; border-radius: 4px; padding: 0.375rem 0.75rem;">
                        </div>
                        <div class="col-md-6">
                            <label for="school" class="form-label" style="color: #000000;">School</label>
                            <input type="text" class="form-control" name="school"
                                value="{{ old('school', $user->school) }}" required
                                style="border: 1px solid #ced4da; border-radius: 4px; padding: 0.375rem 0.75rem;">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group mb-3">
                        <label for="email" class="form-label" style="color: #000000;">Email</label>
                        <input type="email" class="form-control" name="email"
                            value="{{ old('email', $user->email) }}" required
                            style="border: 1px solid #ced4da; border-radius: 4px; padding: 0.375rem 0.75rem;">
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-3">
                        <label for="password" class="form-label" style="color: #000000;">
                            Password <small class="text-muted">(leave blank to keep current)</small>
                        </label>
                        <input type="password" class="form-control" name="password" placeholder="••••••••"
                            style="border: 1px solid #ced4da; border-radius: 4px; padding: 0.375rem 0.75rem;">
                    </div>

                    <!-- Phone & Birth Date -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label" style="color: #000000;">Phone</label>
                            <input type="text" class="form-control" name="phone"
                                value="{{ old('phone', $user->phone) }}"
                                style="border: 1px solid #ced4da; border-radius: 4px; padding: 0.375rem 0.75rem;">
                        </div>
                        <div class="col-md-6">
                            <label for="dob" class="form-label" style="color: #000000;">Birth Date</label>
                            <input type="date" class="form-control" name="dob"
                                value="{{ $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '' }}"
                                style="border-radius: 5px;">
                        </div>
                    </div>

                    <!-- Gender & Role -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="gender" class="form-label" style="color: #000000;">Gender</label>
                            <select name="gender" class="form-control" required
                                style="border: 1px solid #ced4da; border-radius: 4px; padding: 0.375rem 0.75rem;">
                                <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="form-label" style="color: #000000;">Role</label>
                            <select name="role" class="form-control" required
                                style="border: 1px solid #ced4da; border-radius: 4px; padding: 0.375rem 0.75rem;">
                                <option value="player" {{ $user->role == 'player' ? 'selected' : '' }}>Player</option>
                                <option value="coach" {{ $user->role == 'coach' ? 'selected' : '' }}>Coach</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="parent" {{ $user->role == 'parent' ? 'selected' : '' }}>Parent</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-0 d-flex justify-content-end gap-2"
                    style="padding: 0 1.5rem 1.5rem;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        style="color: #495057; border-color: #ced4da; background: transparent; border-radius: 4px;">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary"
                        style="background-color: #007bff; color: white; border: none; border-radius: 4px;">
                        Update
                    </button>
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