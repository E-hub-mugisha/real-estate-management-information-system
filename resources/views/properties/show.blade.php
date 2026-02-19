@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Property Header -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="fw-bold mb-1">{{ $property->name }}</h4>
            <p class="text-muted mb-2">{{ $property->location }}</p>

            <div class="row">
                <div class="col-md-4">
                    <strong>Type:</strong> {{ $property->type }}
                </div>
                <div class="col-md-4">
                    <strong>Owner:</strong> {{ $property->owner->name ?? 'N/A' }}
                </div>
                <div class="col-md-4">
                    <strong>Total Units:</strong> {{ $property->units->count() }}
                </div>
            </div>

            @if($property->description)
                <hr>
                <p>{{ $property->description }}</p>
            @endif
        </div>
    </div>

    <!-- Units Table -->
    <div class="card shadow-sm p-4">
        <div class="card-header fw-bold">
            Units in this Property
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Unit Number</th>
                        <th>Status</th>
                        <th>Tenant</th>
                        <th>Rent</th>
                        <th>Lease End</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($property->units as $unit)
                        @php
                            $activeLease = $unit->leases->where('status', 'Active')->first();
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $unit->unit_number }}</td>
                            <td>
                                <span class="badge bg-{{ $activeLease ? 'success' : 'secondary' }}">
                                    {{ $activeLease ? 'Occupied' : 'Vacant' }}
                                </span>
                            </td>
                            <td>
                                {{ $activeLease?->tenant?->user?->name ?? '-' }}
                            </td>
                            <td>
                                {{ $activeLease ? number_format($activeLease->rent_amount) : '-' }}
                            </td>
                            <td>
                                {{ $activeLease?->end_date?->format('d M Y') ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No units found for this property
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
