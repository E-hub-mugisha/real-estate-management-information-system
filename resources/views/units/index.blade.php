@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Unit Management</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUnitModal">
            + Add Unit
        </button>
    </div>

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Unit</th>
                <th>Property</th>
                <th>Rent (RWF)</th>
                <th>Status</th>
                <th width="200">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($units as $unit)
            <tr>
                <td>{{ $unit->unit_number }}</td>
                <td>{{ $unit->property->name ?? '-' }}</td>
                <td>{{ number_format($unit->rent) }}</td>
                <td>
                    <span class="badge bg-{{ $unit->status == 'Vacant' ? 'success' : 'warning' }}">
                        {{ $unit->status }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#editUnit{{ $unit->id }}">
                        Edit
                    </button>

                    <form action="{{ route('units.destroy', $unit) }}"
                        method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete this unit?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>


            @endforeach
        </tbody>
    </table>
</div>

@foreach($units as $unit)
{{-- EDIT UNIT MODAL --}}
<div class="modal fade" id="editUnit{{ $unit->id }}">
    <div class="modal-dialog">
        <form method="POST"
            action="{{ route('units.update', $unit) }}"
            class="modal-content">
            @csrf @method('PUT')

            <div class="modal-header">
                <h5>Edit Unit</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input class="form-control mb-2" name="unit_number"
                    value="{{ $unit->unit_number }}" required>

                <select class="form-control mb-2" name="property_id">
                    @foreach($properties as $property)
                    <option value="{{ $property->id }}"
                        {{ $unit->property_id == $property->id ? 'selected' : '' }}>
                        {{ $property->name }}
                    </option>
                    @endforeach
                </select>

                <input type="number" class="form-control mb-2"
                    name="rent" value="{{ $unit->rent }}" required>

                <select class="form-control" name="status">
                    <option {{ $unit->status == 'Vacant' ? 'selected' : '' }}>Vacant</option>
                    <option {{ $unit->status == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Update Unit</button>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- CREATE UNIT MODAL --}}
<div class="modal fade" id="addUnitModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('units.store') }}" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5>Add Unit</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input class="form-control mb-2" name="unit_number"
                    placeholder="Unit Number (e.g A1)" required>

                <select class="form-control mb-2" name="property_id" required>
                    <option value="">Select Property</option>
                    @foreach($properties as $property)
                    <option value="{{ $property->id }}">{{ $property->name }}</option>
                    @endforeach
                </select>

                <input type="number" class="form-control mb-2"
                    name="rent" placeholder="Monthly Rent" required>

                <select class="form-control" name="status">
                    <option>Vacant</option>
                    <option>Occupied</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success">Save Unit</button>
            </div>
        </form>
    </div>
</div>
@endsection