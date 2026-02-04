@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h3 class="fw-bold mb-4">Admin Dashboard</h3>

    <!-- KPI CARDS -->
    <div class="row g-3 mb-4">
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
                    <h6>Occupied Units</h6>
                    <h3 class="text-success">{{ $occupiedUnits }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Vacant Units</h6>
                    <h3 class="text-danger">{{ $vacantUnits }}</h3>
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
    </div>

    <!-- CHARTS -->
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h6>Occupancy Trend (This Year)</h6>
                <canvas id="occupancyChart"></canvas>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h6>Payment Collection Trend</h6>
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

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

const occupancyData = @json(array_values($occupancy));
const paymentData = @json(array_values($payments));
const maintenanceData = @json(array_values($maintenance));

new Chart(document.getElementById('occupancyChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{ label: 'Leases', data: occupancyData }]
    }
});

new Chart(document.getElementById('paymentChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{ label: 'Revenue', data: paymentData }]
    }
});

new Chart(document.getElementById('maintenanceChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{ label: 'Requests', data: maintenanceData }]
    }
});
</script>
@endsection
