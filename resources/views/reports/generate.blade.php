@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4>Report @if($from && $to) ({{ $from }} - {{ $to }}) @endif</h4>
        <a href="{{ route('reports.pdf', ['from_date' => request('from_date'), 'to_date' => request('to_date')]) }}"
            class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Download PDF
        </a>

    </div>
    <!-- Leases -->
    <h5 class="mt-4">Leases</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tenant</th>
                <th>Property</th>
                <th>Unit</th>
                <th>Status</th>
                <th>Start</th>
                <th>End</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leases as $lease)
            <tr>
                <td>{{ $lease->tenant->user->name ?? 'N/A' }}</td>
                <td>{{ $lease->unit->property->name ?? 'N/A' }}</td>
                <td>{{ $lease->unit->name ?? 'N/A' }}</td>
                <td>{{ $lease->status }}</td>
                <td>{{ $lease->start_date }}</td>
                <td>{{ $lease->end_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Payments -->
    <h5 class="mt-4">Payments</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Lease ID</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->lease_id }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->payment_date }}</td>
                <td>{{ $payment->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Maintenance -->
    <h5 class="mt-4">Maintenance Requests</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tenant</th>
                <th>Property</th>
                <th>Unit</th>
                <th>Status</th>
                <th>Submitted</th>
            </tr>
        </thead>
        <tbody>
            @foreach($maintenance as $m)
            <tr>
                <td>{{ $m->tenant->user->name ?? 'N/A' }}</td>
                <td>{{ $m->unit->property->name ?? 'N/A' }}</td>
                <td>{{ $m->unit->name ?? 'N/A' }}</td>
                <td>{{ $m->status }}</td>
                <td>{{ $m->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection