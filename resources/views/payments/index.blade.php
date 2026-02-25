@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="fw-bold mb-4">Rent & Payment Tracking</h4>

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
                        <th>Rent</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leases as $lease)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $lease->tenant->user->name }}</td>
                        <td>{{ $lease->unit->unit_number }} - {{ $lease->unit->property->name }}</td>
                        <td>{{ number_format($lease->rent_amount) }}</td>
                        <td>{{ number_format($lease->totalPaid()) }}</td>
                        <td>
                            <span class="badge bg-{{ $lease->balance() > 0 ? 'danger' : 'success' }}">
                                {{ number_format($lease->balance()) }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#pay{{ $lease->id }}">
                                Pay
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- PAYMENT MODAL --}}
@foreach($leases as $lease)
<div class="modal fade" id="pay{{ $lease->id }}">
    <div class="modal-dialog">
        <form class="modal-content"
            method="POST"
            action="{{ route('payments.store') }}">
            @csrf
            <div class="modal-header">
                <h5>Add Payment</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="lease_id" value="{{ $lease->id }}">

                <div class="mb-2">
                    <label class="form-label">Amount Paid</label>
                    <input class="form-control"
                        name="amount"
                        required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Payment Date</label>
                    <input type="date"
                        class="form-control"
                        name="payment_date"
                        required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Payment Method</label>
                    <select class="form-control" name="method">
                        <option value="cash">Cash</option>
                        <option value="bank">Bank Transfer</option>
                        <option value="mobile">Mobile Money</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save Payment</button>
            </div>
        </form>
    </div>
</div>
@endforeach
@endsection