@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Edit Property</h4>
        <a href="{{ route('properties.index') }}" class="btn btn-secondary btn-sm">
            ← Back to Properties
        </a>
    </div>

    <div class="row g-4 justify-content-center">

        <!-- Tenant Info -->
        <div class="col-md-10">
            <div class="card shadow-sm border-0 p-4">
                <form action="{{ route('properties.update', $property) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">Property Name</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $property->name) }}" required>
                    </div>

                    {{-- Location --}}
                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control"
                            value="{{ old('location', $property->location) }}" required>
                    </div>

                    {{-- Address --}}
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address', $property->address) }}">
                    </div>

                    {{-- Type / Status --}}
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select" required>
                                <option value="Apartment" {{ $property->type == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                @foreach(['Available','Rented','Sold','Pending'] as $status)
                                <option value="{{ $status }}" {{ $property->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Price, Bedrooms, Bathrooms --}}
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" name="price" class="form-control"
                                value="{{ old('price', $property->price) }}">
                        </div>
                        <div class="col">
                            <label class="form-label">Bedrooms</label>
                            <input type="number" name="bedrooms" class="form-control"
                                value="{{ old('bedrooms', $property->bedrooms) }}">
                        </div>
                        <div class="col">
                            <label class="form-label">Bathrooms</label>
                            <input type="number" name="bathrooms" class="form-control"
                                value="{{ old('bathrooms', $property->bathrooms) }}">
                        </div>
                    </div>

                    {{-- Size --}}
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Size</label>
                            <input type="number" name="size" class="form-control"
                                value="{{ old('size', $property->size) }}">
                        </div>
                        <div class="col">
                            <label class="form-label">Unit</label>
                            <input type="text" name="unit_measurement" class="form-control"
                                value="{{ old('unit_measurement', $property->unit_measurement) }}">
                        </div>
                    </div>

                    {{-- Owner --}}
                    @if(auth()->user()->role == 'admin')
                    <div class="mb-3">
                        <label class="form-label">Owner</label>
                        <select name="owner_id" class="form-select" required>
                            <option value="">Select Owner</option>
                            @foreach($owners as $owner)
                            <option value="{{ $owner->id }}" {{ $property->owner_id == $owner->id ? 'selected' : '' }}>
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
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $property->description) }}</textarea>
                    </div>

                    {{-- Amenities --}}
                    <div class="mb-3">
                        <label class="form-label">Amenities</label>
                        <input type="text" name="amenities" class="form-control"
    value="{{ old('amenities', is_array($property->amenities) ? implode(', ', $property->amenities) : $property->amenities) }}">
                    </div>

                    {{-- Images --}}
                    <div class="mb-3">
                        <label class="form-label">Main Image</label>
                        <input type="file" name="main_image" class="form-control">
                        @if($property->main_image)
                        <img src="{{ asset('storage/' . $property->main_image) }}" alt="" class="img-fluid mt-2" style="max-height:100px">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gallery Images</label>
                        <input type="file" name="gallery[]" class="form-control" multiple>
                        @if($property->gallery)
                        <div class="mt-2 d-flex flex-wrap gap-2">
                            @foreach($property->gallery as $img)
                            <img src="{{ asset('storage/' . $img) }}" alt="" class="img-fluid" style="max-height:80px">
                            @endforeach
                        </div>
                        @endif
                    </div>

                    {{-- 360° Room Image --}}
                    <div class="mb-3">
                        <label class="form-label">360° Room Image</label>
                        <input type="file" name="room_360_image" class="form-control">
                        @if($property->room_360_image)
                        <img src="{{ asset('storage/' . $property->room_360_image) }}" alt="" class="img-fluid mt-2" style="max-height:100px">
                        @endif
                    </div>

                    <button class="btn btn-primary">Update Property</button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection