@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>User Management</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
            + Add User
        </button>
    </div>

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
                <td>{{ $user->roles->first()->name ?? '-' }}</td>
                <td>
                    <span class="badge bg-{{ $user->status ? 'success' : 'danger' }}">
                        {{ $user->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#editUserModal{{ $user->id }}">
                        Edit
                    </button>

                    <a href="{{ route('roles_permissions.index') }}?user_id={{ $user->id }}"
                        class="btn btn-sm btn-warning">Manage Permissions</a>

                    <form action="{{ route('users.toggleStatus', $user) }}" method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-secondary">Toggle</button>
                    </form>

                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete this user?')">
                            Delete
                        </button>
                    </form>
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
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}"
                        {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                    @endforeach
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
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success">Create User</button>
            </div>
        </form>
    </div>
</div>
@endsection