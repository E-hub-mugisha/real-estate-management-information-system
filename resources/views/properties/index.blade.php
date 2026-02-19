@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Property Management</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPropertyModal">
            + Add Property
        </button>
    </div>

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Name</th>
                <th>Location</th>
                <th>Type</th>
                <th>Owner</th>
                <th width="200">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($properties as $property)
            <tr>
                <td>{{ $property->name }}</td>
                <td>{{ $property->location }}</td>
                <td>{{ $property->type }}</td>
                <td>{{ $property->owner->name ?? '-' }}</td>
                <td>
                    <a href="{{ route('properties.show', $property->id) }}"
                        class="btn btn-sm btn-outline-primary">
                        View
                    </a>
                    <button class="btn btn-sm btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#editProperty{{ $property->id }}">
                        Edit
                    </button>

                    <form action="{{ route('properties.destroy', $property) }}"
                        method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete this property?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>


            @endforeach
        </tbody>
    </table>
</div>

@foreach($properties as $property)
{{-- EDIT MODAL --}}
<div class="modal fade" id="editProperty{{ $property->id }}">
    <div class="modal-dialog">
        <form method="POST"
            action="{{ route('properties.update', $property) }}"
            class="modal-content">
            @csrf @method('PUT')

            <div class="modal-header">
                <h5>Edit Property</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input class="form-control mb-2" name="name"
                    value="{{ $property->name }}" required>

                <input class="form-control mb-2" name="location"
                    value="{{ $property->location }}" required>

                <select class="form-control mb-2" name="type">
                    <option {{ $property->type == 'Residential' ? 'selected' : '' }}>
                        Residential
                    </option>
                    <option {{ $property->type == 'Commercial' ? 'selected' : '' }}>
                        Commercial
                    </option>
                </select>

                <select class="form-control" name="owner_id">
                    @foreach($owners as $owner)
                    <option value="{{ $owner->id }}"
                        {{ $property->owner_id == $owner->id ? 'selected' : '' }}>
                        {{ $owner->name }}
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
<div class="modal fade" id="addPropertyModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('properties.store') }}" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5>Add Property</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input class="form-control mb-2" name="name"
                    placeholder="Property Name" required>

                <input class="form-control mb-2" name="location"
                    placeholder="Location" required>

                <select class="form-control mb-2" name="type" required>
                    <option value="">Select Type</option>
                    <option>Residential</option>
                    <option>Commercial</option>
                </select>

                <select class="form-control" name="owner_id" required>
                    <option value="">Select Owner</option>
                    @foreach($owners as $owner)
                    <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success">Save Property</button>
            </div>
        </form>
    </div>
</div>
@endsection