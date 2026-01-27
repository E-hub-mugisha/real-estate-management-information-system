@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Reports & Analytics</h3>

    <!-- Filters -->
    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-3">
            <select name="property_id" class="form-select">
                <option value="">--Select Property--</option>
                @foreach($properties as $property)
                    <option value="{{ $property->id }}" {{ request('property_id')==$property->id?'selected':'' }}>{{ $property->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="month" name="month" value="{{ request('month') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <input type="number" name="year" value="{{ request('year') }}" placeholder="Year" class="form-control">
        </div>
        <div class="col-md-3">
            <select name="tenant_id" class="form-select">
                <option value="">--Select Tenant--</option>
                @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}" {{ request('tenant_id')==$tenant->id?'selected':'' }}>
                        {{ $tenant->user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <!-- Export Buttons -->
    <div class="mb-3">
        <a href="{{ route('reports.exportExcel', request()->query()) }}" class="btn btn-success">Export Excel</a>
        <a href="{{ route('reports.exportPDF', request()->query()) }}" class="btn btn-danger">Export PDF</a>
    </div>

    <!-- Charts -->
    <div class="row">
        <div class="col-md-4">
            <canvas id="occupancyChart"></canvas>
        </div>
        <div class="col-md-4">
            <canvas id="paymentChart"></canvas>
        </div>
        <div class="col-md-4">
            <canvas id="maintenanceChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    const occupancyData = {{ json_encode($occupancyTrend) }};
    const paymentData = {{ json_encode($paymentTrend) }};
    const maintenanceData = {{ json_encode($maintenanceTrend) }};

    // Occupancy Chart
    new Chart(document.getElementById('occupancyChart'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Occupancy Trend',
                data: Object.values(occupancyData),
                backgroundColor: 'rgba(54,162,235,0.6)',
                borderColor: 'rgba(54,162,235,1)',
                borderWidth:1
            }]
        },
        options: { responsive:true, scales:{y:{beginAtZero:true}} }
    });

    // Payment Chart
    new Chart(document.getElementById('paymentChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Payment Collection Trend',
                data: Object.values(paymentData),
                backgroundColor: 'rgba(75,192,192,0.2)',
                borderColor: 'rgba(75,192,192,1)',
                fill:true,
                tension:0.3
            }]
        },
        options: { responsive:true, scales:{y:{beginAtZero:true}} }
    });

    // Maintenance Chart
    new Chart(document.getElementById('maintenanceChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Maintenance Requests Trend',
                data: Object.values(maintenanceData),
                backgroundColor: 'rgba(255,99,132,0.2)',
                borderColor: 'rgba(255,99,132,1)',
                fill:true,
                tension:0.3
            }]
        },
        options: { responsive:true, scales:{y:{beginAtZero:true}} }
    });
</script>
@endpush
@endsection
