@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Manage Roles & Permissions</h3>

    @if($user)
        <h5>User: {{ $user->name }} ({{ $user->email }})</h5>

        <!-- Roles -->
        <form action="{{ route('roles_permissions.updateRoles', $user) }}" method="POST" class="mb-4">
            @csrf
            <h6>Roles</h6>
            @foreach($roles as $role)
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" name="roles[]" value="{{ $role->name }}"
                        {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $role->name }}</label>
                </div>
            @endforeach
            <button class="btn btn-primary btn-sm mt-2">Update Roles</button>
        </form>

        <!-- Permissions -->
        <form action="{{ route('roles_permissions.updatePermissions', $user) }}" method="POST">
            @csrf
            <h6>Permissions</h6>
            <div style="max-height:300px; overflow-y:auto;">
                @foreach($permissions as $permission)
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->name }}"
                            {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $permission->name }}</label>
                    </div>
                @endforeach
            </div>
            <button class="btn btn-success btn-sm mt-2">Update Permissions</button>
        </form>
    @else
        <div class="alert alert-info">Please select a user to manage roles & permissions.</div>
    @endif
</div>
@endsection
