@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Property Management</h4>
        @if( Auth::user()->role == 'admin' || Auth::user()->role == 'owner')
        <a href="{{ route('properties.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Property
        </a>
        @endif
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
                    @if( Auth::user()->role == 'admin' || Auth::user()->role == 'owner')
                    <a href="{{ route('properties.edit', $property->id) }}"
                        class="btn btn-sm btn-outline-secondary">
                        Edit
                    </a>

                    <form action="{{ route('properties.destroy', $property) }}"
                        method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete this property?')">
                            Delete
                        </button>
                    </form>
                    @endif
                </td>
            </tr>


            @endforeach
        </tbody>
    </table>
</div>



@endsection