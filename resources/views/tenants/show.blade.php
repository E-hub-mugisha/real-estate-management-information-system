@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Tenant Profile</h4>
        <a href="{{ route('tenants.index') }}" class="btn btn-secondary btn-sm">
            ← Back to Tenants
        </a>
    </div>

    <div class="row g-4">

        <!-- Tenant Info -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:80px;height:80px;font-size:28px;">
                        {{ strtoupper(substr($tenant->user->name, 0, 1)) }}
                    </div>

                    <h5 class="fw-bold">{{ $tenant->user->name }}</h5>
                    <p class="text-muted mb-1">{{ $tenant->user->email }}</p>

                    <span class="badge bg-{{ $tenant->status === 'Active' ? 'success' : 'secondary' }}">
                        {{ $tenant->status }}
                    </span>
                </div>

                <hr class="my-0">

                <div class="card-body">
                    <p><strong>Phone:</strong> {{ $tenant->phone }}</p>
                    <p><strong>National ID:</strong> {{ $tenant->national_id ?? 'N/A' }}</p>
                    <p><strong>Employment:</strong> {{ $tenant->employment ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Unit & Property Info -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light fw-semibold">
                    Unit & Property
                </div>
                <div class="card-body">
                    @if($tenant->unit)
                    <p><strong>Property:</strong> {{ $tenant->unit->property->name }}</p>
                    <p><strong>Location:</strong> {{ $tenant->unit->property->location }}</p>
                    <p><strong>Unit:</strong> {{ $tenant->unit->unit_number }}</p>
                    <p><strong>Rent:</strong> {{ number_format($tenant->unit->rent) }} RWF</p>
                    @else
                    <p class="text-muted">No unit assigned</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Lease Info -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light fw-semibold">
                    Lease Information
                </div>
                <div class="card-body">
                    @forelse($tenant->leases as $lease)
                    <p><strong>Start:</strong> {{ $lease->start_date }}</p>
                    <p><strong>End:</strong> {{ $lease->end_date }}</p>
                    <p><strong>Rent:</strong> {{ number_format($lease->rent_amount) }} RWF</p>
                    <hr>
                    @empty
                    <p class="text-muted">No active lease</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Payment History -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0 p-4">
                <div class="card-header bg-light fw-semibold">
                    Payment History
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tenant->payments as $payment)
                            <tr>
                                <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                                <td>{{ number_format($payment->amount) }} RWF</td>
                                <td>{{ $payment->method }}</td>
                                <td>
                                    <span class="badge bg-success">Paid</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    No payments recorded
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection