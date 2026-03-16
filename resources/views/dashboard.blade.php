@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="container">

<h3 class="fw-bold mb-2">Dashboard</h3>
<p class="mb-4">Welcome {{ auth()->user()->name }}</p>

{{-- ================= ADMIN DASHBOARD ================= --}}
@if(auth()->user()->role == 'admin')

<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Properties</h6>
                <h3>{{ $totalProperties ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Units</h6>
                <h3>{{ $totalUnits }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Revenue</h6>
                <h3>{{ number_format($totalRevenue) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Pending Maintenance</h6>
                <h3 class="text-warning">{{ $pendingMaintenance }}</h3>
            </div>
        </div>
    </div>

</div>

@endif


{{-- ================= OWNER DASHBOARD ================= --}}
@if(auth()->user()->role == 'owner')

<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>My Properties</h6>
                <h3>{{ $totalProperties ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Occupied Property</h6>
                <h3 class="text-success">{{ $totalUnits }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Revenue from Rent</h6>
                <h3>{{ number_format($totalRevenue) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Tenant Requests</h6>
                <h3 class="text-danger">{{ $pendingMaintenance }}</h3>
            </div>
        </div>
    </div>

</div>

@endif


{{-- ================= TENANT DASHBOARD ================= --}}
@if(auth()->user()->role == 'tenant')

<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>My Lease</h6>
                <h3>{{ $leasesCount ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>My Payments</h6>
                <h3>{{ number_format($totalRevenue) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>My Maintenance Requests</h6>
                <h3>{{ $pendingMaintenance }}</h3>
            </div>
        </div>
    </div>

</div>

@endif


{{-- ================= CHARTS (ADMIN + OWNER ONLY) ================= --}}
@if(auth()->user()->role != 'tenant')

<div class="row mb-4">

    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6>Occupancy Trend</h6>
            <canvas id="occupancyChart"></canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6>Revenue Trend</h6>
            <canvas id="paymentChart"></canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6>Maintenance Requests</h6>
            <canvas id="maintenanceChart"></canvas>
        </div>
    </div>

</div>

@endif

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

const occupancyData = @json(array_values($occupancy ?? []));
const paymentData = @json(array_values($payments ?? []));
const maintenanceData = @json(array_values($maintenance ?? []));

new Chart(document.getElementById('occupancyChart'), {
type:'bar',
data:{labels:months,datasets:[{label:'Leases',data:occupancyData}]}
});

new Chart(document.getElementById('paymentChart'), {
type:'line',
data:{labels:months,datasets:[{label:'Revenue',data:paymentData}]}
});

new Chart(document.getElementById('maintenanceChart'), {
type:'line',
data:{labels:months,datasets:[{label:'Requests',data:maintenanceData}]}
});

</script>

@endsection