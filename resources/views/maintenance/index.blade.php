@extends('layouts.app')

@section('content')
<div class="container">

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
                            <a href="{{ route('maintenance.show', $req->id) }}" class="btn btn-sm btn-info">
                                View
                            </a>

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
@endsection