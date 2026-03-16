@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Request Details</h4>
        <a href="{{ route('maintenance.index') }}" class="btn btn-secondary btn-sm">← Back</a>
    </div>

    <div class="row g-4">

        <!-- Request Info -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header fw-semibold bg-light">Request Information</div>
                <div class="card-body">
                    <p><strong>Title:</strong> {{ $maintenance->title }}</p>
                    <p><strong>Description:</strong><br>{{ $maintenance->description }}</p>

                    <p><strong>Status:</strong>
                        <span class="badge bg-{{ 
                            $maintenance->status === 'Resolved' ? 'success' : 
                            ($maintenance->status === 'In Progress' ? 'warning' : 'secondary') }}">
                            {{ $maintenance->status }}
                        </span>
                    </p>

                    <p><strong>Submitted:</strong> {{ $maintenance->created_at->format('Y-m-d') }}</p>
                    @if($maintenance->resolved_at)
                        <p><strong>Resolved At:</strong> {{ $maintenance->resolved_at->format('Y-m-d') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tenant & Unit Info -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header fw-semibold bg-light">Tenant & Property</div>
                <div class="card-body">
                    <p><strong>Tenant:</strong> {{ $maintenance->tenant->user->name }}</p>
                    <p><strong>Phone:</strong> {{ $maintenance->tenant->phone }}</p>
                    <p><strong>Property:</strong> {{ $maintenance->unit->property->name }}</p>
                </div>
            </div>
        </div>

        <!-- Admin Response -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header fw-semibold bg-light">Response</div>
                <div class="card-body">

                    @if($maintenance->response)
                        <div class="alert alert-info">
                            {{ $maintenance->response }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('maintenance.response', $maintenance) }}">
                        @csrf
                        <div class="mb-3">
                            <textarea name="response" class="form-control" rows="3"
                                placeholder="Write response to tenant..."></textarea>
                        </div>
                        <button class="btn btn-primary">Send Response</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Status Action -->
        <div class="col-md-12">
            @canany(['maintenance.edit','maintenance.manage'])
            <div class="card shadow-sm border-0">
                <div class="card-header fw-semibold bg-light">Take Action</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('maintenance.updateStatus', $maintenance) }}">
                        @csrf
                        @method('PATCH')

                        <div class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label>Status</label>
                                <select name="status" class="form-select">
                                    <option {{ $maintenance->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option {{ $maintenance->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option {{ $maintenance->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <button class="btn btn-success">Update Status</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endcanany
        </div>

    </div>
</div>
@endsection
