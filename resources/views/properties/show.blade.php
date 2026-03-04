@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/core/index.min.css" />

<div class="container py-4">
    <div class="row">

        {{-- Left Column: Main Image + Gallery --}}
        <div class="col-md-6">

            {{-- Main Image --}}
            <!-- @if($property->main_image)
                <img src="{{ asset('storage/' . $property->main_image) }}" 
                     class="img-fluid rounded shadow-sm mb-3" 
                     alt="{{ $property->name }}">
            @else
                <img src="{{ asset('images/property-default.png') }}" 
                     class="img-fluid rounded shadow-sm mb-3" 
                     alt="No image">
            @endif -->

            {{-- Gallery Carousel --}}
            @if($property->gallery && count($property->gallery) > 0)
                <div id="propertyGalleryCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($property->gallery as $index => $img)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img 
                                    src="{{ asset('storage/' . $img) }}"
                                    data-panorama="{{ asset('storage/' . $img) }}"
                                    class="d-block w-100 rounded gallery-360"
                                    style="height:300px; object-fit:cover; cursor:pointer"
                                    alt="Gallery Image">
                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button"
                        data-bs-target="#propertyGalleryCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button"
                        data-bs-target="#propertyGalleryCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            @endif
        </div>

        {{-- Right Column: Property Details --}}
        <div class="col-md-6">
            <h3>{{ $property->name }}</h3>
            <p class="text-muted">
                {{ $property->location }}
                @if($property->address), {{ $property->address }} @endif
            </p>

            {{-- Type & Status --}}
            <div class="mb-2">
                <span class="badge bg-info text-dark">{{ $property->type }}</span>
                <span class="badge 
                    {{ $property->status == 'Available' ? 'bg-success' : '' }}
                    {{ $property->status == 'Rented' ? 'bg-warning text-dark' : '' }}
                    {{ $property->status == 'Sold' ? 'bg-danger' : '' }}
                    {{ $property->status == 'Pending' ? 'bg-secondary' : '' }}">
                    {{ $property->status }}
                </span>
            </div>

            {{-- Financials --}}
            @if($property->price)
                <p><strong>Price:</strong> ${{ number_format($property->price, 2) }}</p>
            @endif

            <p>
                <strong>Bedrooms:</strong> {{ $property->bedrooms ?? '-' }} <br>
                <strong>Bathrooms:</strong> {{ $property->bathrooms ?? '-' }} <br>
                <strong>Size:</strong> {{ $property->size ?? '-' }} {{ $property->unit_measurement }}
            </p>

            {{-- Owner --}}
            <p>
                <strong>Owner:</strong> 
                {{ $property->owner->name ?? '-' }} 
                ({{ $property->owner->email ?? '-' }})
            </p>

            {{-- Amenities --}}
            @if($property->amenities)
                <p>
                    <strong>Amenities:</strong>
                    @foreach(explode(',', $property->amenities) as $amenity)
                        <span class="badge bg-secondary me-1">
                            {{ trim($amenity) }}
                        </span>
                    @endforeach
                </p>
            @endif

            {{-- Description --}}
            @if($property->description)
                <div class="mt-3">
                    <h5>Description:</h5>
                    <p>{{ $property->description }}</p>
                </div>
            @endif

            {{-- Map --}}
            @if($property->address)
                <div class="mt-4">
                    <h5>Location Map:</h5>
                    <iframe
                        width="100%"
                        height="300"
                        style="border:0"
                        loading="lazy"
                        allowfullscreen
                        src="https://www.google.com/maps?q={{ urlencode($property->address) }}&output=embed">
                    </iframe>
                </div>
            @endif

            {{-- Actions --}}
            <!-- if tenant inquiry -->
            @if(auth()->user()->role == 'tenant')
    <a href="{{ route('inquiries.create', ['property_id' => $property->id]) }}" 
       class="btn btn-primary mt-3">
       Inquire about this property
    </a>
@endif
            @if(auth()->user()->role == 'owner' && auth()->id() == $property->owner_id || auth()->user()->role == 'admin')
            <div class="mt-4">
                <a href="{{ route('properties.edit', $property) }}" 
                   class="btn btn-warning">
                   Edit Property
                </a>

                <form action="{{ route('properties.destroy', $property) }}" 
                      method="POST" 
                      class="d-inline">
                    @csrf 
                    @method('DELETE')
                    <button class="btn btn-danger" 
                            onclick="return confirm('Delete this property?')">
                        Delete
                    </button>
                </form>
            </div>
            @endif
        </div>

        {{-- 360 Viewer --}}
        @if($property->room_360_image)
        <div class="col-md-12 mt-4">
            <h5>360° Room View:</h5>
            <div id="viewer" style="width:100%; height:450px;"></div>
        </div>
        @endif

    </div>
</div>

{{-- ImportMap --}}
<script type="importmap">
{
    "imports": {
        "three": "https://cdn.jsdelivr.net/npm/three/build/three.module.js",
        "@photo-sphere-viewer/core": "https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/core/index.module.js"
    }
}
</script>

{{-- Viewer Script --}}
@if($property->room_360_image)
<script type="module">
import { Viewer } from '@photo-sphere-viewer/core';

const viewer = new Viewer({
    container: document.querySelector('#viewer'),
    panorama: '{{ asset("storage/" . $property->room_360_image) }}',
});

// Click gallery image to update viewer
document.querySelectorAll('.gallery-360').forEach(img => {
    img.addEventListener('click', function () {
        const newPanorama = this.getAttribute('data-panorama');

        if (newPanorama) {
            viewer.setPanorama(newPanorama, {
                transition: true,
                speed: '20rpm'
            });
        }
    });
});
</script>
@endif

@endsection