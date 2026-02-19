@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-4">
        <h4 class="fw-bold">Lease Management</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLease">
            + Create Lease
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tenant</th>
                        <th>Unit</th>
                        <th>Rent</th>
                        <th>Period</th>
                        <th>Status</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leases as $lease)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $lease->tenant->user->name }}</td>
                        <td>{{ $lease->unit->unit_number }} - {{ $lease->unit->property->name }}</td>
                        <td>{{ number_format($lease->rent_amount) }} RWF</td>
                        <td>{{ $lease->start_date }} → {{ $lease->end_date }}</td>
                        <td>
                            <span class="badge bg-{{ $lease->status=='Active'?'success':'secondary' }}">
                                {{ $lease->status }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editLease{{ $lease->id }}">
                                Edit
                            </button>

                            <form method="POST"
                                action="{{ route('leases.destroy',$lease) }}"
                                class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete lease?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>


                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($leases as $lease)
{{-- EDIT LEASE MODAL --}}
<div class="modal fade" id="editLease{{ $lease->id }}">
    <div class="modal-dialog">
        <form class="modal-content"
            method="POST"
            action="{{ route('leases.update',$lease) }}">
            @csrf @method('PUT')

            <div class="modal-header">
                <h5>Edit Lease</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input class="form-control mb-2"
                    name="rent_amount"
                    value="{{ $lease->rent_amount }}">

                <input type="date" class="form-control mb-2"
                    name="start_date"
                    value="{{ $lease->start_date }}">

                <input type="date" class="form-control mb-2"
                    name="end_date"
                    value="{{ $lease->end_date }}">

                <select class="form-control" name="status">
                    <option {{ $lease->status=='Active'?'selected':'' }}>Active</option>
                    <option {{ $lease->status=='Expired'?'selected':'' }}>Expired</option>
                    <option {{ $lease->status=='Terminated'?'selected':'' }}>Terminated</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Update Lease</button>
            </div>
        </form>
    </div>
</div>
@endforeach
{{-- ADD LEASE MODAL --}}
<div class="modal fade" id="addLease">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('leases.store') }}">
            @csrf

            <div class="modal-header">
                <h5>Create Lease</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <select class="form-control mb-2" name="tenant_id" required>
                    <option value="">Select Tenant</option>
                    @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}">
                        {{ $tenant->user->name }}
                    </option>
                    @endforeach
                </select>

                <select class="form-control mb-2" name="unit_id" required>
                    <option value="">Select Unit</option>
                    @foreach($units as $unit)
                    <option value="{{ $unit->id }}">
                        {{ $unit->unit_number }} - {{ $unit->property->name }}
                    </option>
                    @endforeach
                </select>

                <input class="form-control mb-2"
                    name="rent_amount"
                    placeholder="Rent Amount" required>

                <input type="date" class="form-control mb-2"
                    name="start_date" required>

                <input type="date" class="form-control"
                    name="end_date" required>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success">Create Lease</button>
            </div>
        </form>
    </div>
</div>
@endsection