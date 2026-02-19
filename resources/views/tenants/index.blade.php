@extends('layouts.app')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Tenant Management</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTenantModal">
            + Onboard Tenant
        </button>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- TENANTS TABLE --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tenant Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Unit</th>
                        <th>Status</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tenants as $tenant)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tenant->user->name }}</td>
                        <td>{{ $tenant->user->email }}</td>
                        <td>{{ $tenant->phone }}</td>
                        <td>
                            {{ $tenant->unit
                                ? $tenant->unit->unit_number.' - '.$tenant->unit->property->name
                                : 'Not Assigned' }}
                        </td>
                        <td>
                            <span class="badge bg-{{ $tenant->status === 'Active' ? 'success' : 'secondary' }}">
                                {{ $tenant->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('tenants.show', $tenant->id) }}"
                                class="btn btn-sm btn-info">
                                View
                            </a>

                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editTenant{{ $tenant->id }}">
                                Edit
                            </button>

                            <form method="POST"
                                action="{{ route('tenants.destroy',$tenant) }}"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Remove this tenant?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>


                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            No tenants found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($tenants as $tenant)
{{-- EDIT TENANT MODAL --}}
<div class="modal fade" id="editTenant{{ $tenant->id }}">
    <div class="modal-dialog">
        <form class="modal-content"
            method="POST"
            action="{{ route('tenants.update',$tenant) }}">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Edit Tenant</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-2">
                    <label class="form-label">Phone</label>
                    <input class="form-control"
                        name="phone"
                        value="{{ $tenant->phone }}">
                </div>

                <div class="mb-2">
                    <label class="form-label">National ID</label>
                    <input class="form-control"
                        name="national_id"
                        value="{{ $tenant->national_id }}">
                </div>

                <div class="mb-2">
                    <label class="form-label">Employment</label>
                    <input class="form-control"
                        name="employment"
                        value="{{ $tenant->employment }}">
                </div>

                <div class="mb-2">
                    <label class="form-label">Unit</label>
                    <select class="form-control" name="unit_id">
                        <option value="">No Unit</option>
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}"
                            {{ $tenant->unit_id == $unit->id ? 'selected' : '' }}>
                            {{ $unit->unit_number }} - {{ $unit->property->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-2">
                    <label class="form-label">Status</label>
                    <select class="form-control" name="status">
                        <option {{ $tenant->status=='Active'?'selected':'' }}>Active</option>
                        <option {{ $tenant->status=='Inactive'?'selected':'' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Update Tenant</button>
            </div>
        </form>
    </div>
</div>
@endforeach
{{-- ADD TENANT MODAL --}}
<div class="modal fade" id="addTenantModal">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('tenants.store') }}">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Onboard Tenant</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-2">
                    <label class="form-label">Full Name</label>
                    <input class="form-control" name="name" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Email</label>
                    <input class="form-control" name="email" type="email" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Phone</label>
                    <input class="form-control" name="phone" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">National ID</label>
                    <input class="form-control" name="national_id">
                </div>

                <div class="mb-2">
                    <label class="form-label">Employment</label>
                    <input class="form-control" name="employment">
                </div>

                <div class="mb-2">
                    <label class="form-label">Assign Unit (optional)</label>
                    <select class="form-control" name="unit_id">
                        <option value="">Select Unit</option>
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}">
                            {{ $unit->unit_number }} - {{ $unit->property->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success">Create Tenant</button>
            </div>
        </form>
    </div>
</div>
@endsection