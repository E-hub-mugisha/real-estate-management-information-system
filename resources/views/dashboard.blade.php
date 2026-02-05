@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="container">

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

<div class="container py-4">

    <h4 class="fw-bold mb-4">Maintenance Requests</h4>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tenant</th>
                        <th>Unit</th>
                        <th>Issue</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $req)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $req->tenant->user->name }}</td>
                        <td>{{ $req->unit->unit_number }} - {{ $req->unit->property->name }}</td>
                        <td>{{ $req->title }}</td>
                        <td>
                            <span class="badge bg-warning">{{ $req->priority }}</span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $req->status=='Completed'?'success':'secondary' }}">
                                {{ $req->status }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#update{{ $req->id }}">
                                Update
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($requests as $req)
{{-- UPDATE MODAL --}}
<div class="modal fade" id="update{{ $req->id }}">
    <div class="modal-dialog">
        <form class="modal-content"
            method="POST"
            action="{{ route('maintenance.update',$req) }}">
            @csrf @method('PUT')

            <div class="modal-header">
                <h5>Update Request</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <select class="form-control mb-2" name="priority">
                    <option {{ $req->priority=='Low'?'selected':'' }}>Low</option>
                    <option {{ $req->priority=='Medium'?'selected':'' }}>Medium</option>
                    <option {{ $req->priority=='High'?'selected':'' }}>High</option>
                </select>

                <select class="form-control" name="status">
                    <option {{ $req->status=='Pending'?'selected':'' }}>Pending</option>
                    <option {{ $req->status=='In Progress'?'selected':'' }}>In Progress</option>
                    <option {{ $req->status=='Completed'?'selected':'' }}>Completed</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    const occupancyData = @json(array_values($occupancy));
    const paymentData = @json(array_values($payments));
    const maintenanceData = @json(array_values($maintenance));

    new Chart(document.getElementById('occupancyChart'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Leases',
                data: occupancyData
            }]
        }
    });

    new Chart(document.getElementById('paymentChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenue',
                data: paymentData
            }]
        }
    });

    new Chart(document.getElementById('maintenanceChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Requests',
                data: maintenanceData
            }]
        }
    });
</script>
@endsection