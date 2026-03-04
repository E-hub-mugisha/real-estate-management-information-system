@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Create Property</h4>
        <a href="{{ route('properties.index') }}" class="btn btn-secondary btn-sm">
            ← Back to Properties
        </a>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row g-4 justify-content-center">

        <!-- Tenant Info -->
        <div class="col-md-10">
            <div class="card shadow-sm border-0 p-4">
                <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">Property Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name') }}" required>
                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    {{-- Location --}}
                    <div class="mb-3">
                        <label class="form-label">Location <span class="text-danger">*</span></label>
                        <input type="text" name="location" class="form-control"
                            value="{{ old('location') }}" required>
                        @error('location') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    {{-- Address --}}
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address') }}">
                    </div>

                    {{-- Type --}}
                    <div class="mb-3">
                        <label class="form-label">Property Type</label>
                        <select name="type" class="form-select" required>
                            <option value="Residential" {{ old('type') == 'Residential' ? 'selected' : '' }}>Residential</option>
                            <option value="Commercial" {{ old('type') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            @foreach(['Available','Rented','Sold','Pending'] as $status)
                            <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Price --}}
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control"
                            value="{{ old('price') }}">
                    </div>

                    {{-- Bedrooms / Bathrooms --}}
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Bedrooms</label>
                            <input type="number" name="bedrooms" class="form-control"
                                value="{{ old('bedrooms') }}">
                        </div>
                        <div class="col">
                            <label class="form-label">Bathrooms</label>
                            <input type="number" name="bathrooms" class="form-control"
                                value="{{ old('bathrooms') }}">
                        </div>
                    </div>

                    {{-- Size --}}
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Size</label>
                            <input type="number" name="size" class="form-control"
                                value="{{ old('size') }}">
                        </div>
                        <div class="col">
                            <label class="form-label">Unit</label>
                            <input type="text" name="unit_measurement" class="form-control"
                                value="{{ old('unit_measurement', 'sqm') }}">
                        </div>
                    </div>

                    {{-- Owner --}}
                    @if(auth()->user()->role == 'admin')
                    <div class="mb-3">
                        <label class="form-label">Owner</label>
                        <select name="owner_id" class="form-select" required>
                            <option value="">Select Owner</option>
                            @foreach($owners as $owner)
                            <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                                {{ $owner->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <input type="hidden" name="owner_id" value="{{ auth()->id() }}">
                    @endif

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>

                    {{-- Amenities --}}
                    <div class="mb-3">
                        <label class="form-label">Amenities (comma separated)</label>
                        <input type="text" name="amenities" class="form-control"
                            value="{{ old('amenities') }}">
                    </div>

                    {{-- Main Image --}}
                    <div class="mb-3">
                        <label class="form-label">Main Image</label>
                        <input type="file" name="main_image" class="form-control">
                    </div>

                    {{-- Gallery --}}
                    <div class="mb-3">
                        <label class="form-label">Gallery Images</label>
                        <input type="file" name="gallery[]" class="form-control" multiple>
                    </div>
                    
                    {{-- 360° Room Image --}}
                    <div class="mb-3">
                        <label class="form-label">360° Room Image</label>
                        <input type="file" name="room_360_image" class="form-control">  
                    </div>

                    <button class="btn btn-success">Add Property</button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection