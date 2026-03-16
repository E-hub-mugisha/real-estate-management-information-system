@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>User Management</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
            + Add User
        </button>
    </div>
    <!-- error -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th width="220">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role?? '-' }}</td>
                <td>
                    <span class="badge bg-{{ $user->status ? 'success' : 'danger' }}">
                        {{ $user->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Actions
                        </button>

                        <ul class="dropdown-menu">

                            <li>
                                <button class="dropdown-item"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editUserModal{{ $user->id }}">
                                    Edit
                                </button>
                            </li>

                            <!-- <li>
                                <a class="dropdown-item"
                                    href="{{ route('roles_permissions.index') }}?user_id={{ $user->id }}">
                                    Manage Permissions
                                </a>
                            </li> -->

                            <li>
                                <form action="{{ route('users.toggleStatus', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="dropdown-item">
                                        Toggle Status
                                    </button>
                                </form>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                    onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        Delete
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </div>
                </td>
            </tr>


            @endforeach
        </tbody>
    </table>
</div>

@foreach($users as $user)
{{-- EDIT MODAL --}}
<div class="modal fade" id="editUserModal{{ $user->id }}">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('users.update', $user) }}" class="modal-content">
            @csrf @method('PUT')

            <div class="modal-header">
                <h5>Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input class="form-control mb-2" name="name"
                    value="{{ $user->name }}" required>

                <input class="form-control mb-2" name="email"
                    value="{{ $user->email }}" required>

                <select name="role" class="form-control">
                    <option value="{{ $user->role }}"
                        {{ $user->role ? 'selected' : '' }}>
                        {{ $user->role ?? 'No Role' }}
                    </option>
                    <option value="owner">Owner</option>
                    <option value="admin">Admin</option>
                    <option value="tenant">Tenant</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endforeach
{{-- CREATE MODAL --}}
<div class="modal fade" id="createUserModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('users.store') }}" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5>Create User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input class="form-control mb-2" name="name"
                    placeholder="Full Name" required>

                <input class="form-control mb-2" name="email"
                    placeholder="Email Address" required>

                <select name="role" class="form-control" required>
                    <option value="">Select Role</option>
                    <option value="owner">Owner</option>
                    <option value="admin">Admin</option>
                    <option value="tenant">Tenant</option>
                </select>
                <!-- password -->
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="position-relative">
                        <input type="password" name="password" id="passwordField"
                            class="form-control pe-5" required>

                        <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
                            id="togglePassword"
                            style="font-size: 1.2rem; cursor: pointer; color: #6c757d;"></i>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <div class="position-relative">
                        <input type="password" name="password_confirmation" id="passwordConfirmationField"
                            class="form-control pe-5" required>

                        <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
                            id="toggleConfirmationPassword"
                            style="font-size: 1.2rem; cursor: pointer; color: #6c757d;"></i>
                    </div>
                </div>

                <script>
                    function togglePasswordVisibility(toggleId, fieldId) {
                        const toggleIcon = document.getElementById(toggleId);
                        const passwordField = document.getElementById(fieldId);

                        toggleIcon.addEventListener('click', function() {
                            const type = passwordField.type === 'password' ? 'text' : 'password';
                            passwordField.type = type;

                            this.classList.toggle('bi-eye');
                            this.classList.toggle('bi-eye-slash');
                        });
                    }

                    togglePasswordVisibility('togglePassword', 'passwordField');
                    togglePasswordVisibility('toggleConfirmationPassword', 'passwordConfirmationField');
                </script>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success">Create User</button>
            </div>
        </form>
    </div>
</div>
@endsection