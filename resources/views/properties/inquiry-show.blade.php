@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4>Inquiry Details</h4>

    <div class="card p-4">
        <p><strong>Property:</strong> {{ $inquiry->property->title }}</p>
        <p><strong>Tenant:</strong> {{ $inquiry->tenant->user->name }}</p>
        <p><strong>Email:</strong> {{ $inquiry->tenant->user->email }}</p>
        <p><strong>Message:</strong></p>
        <div class="border p-3 bg-light">
            {{ $inquiry->message }}
        </div>

        <hr>

        <form action="{{ route('admin.inquiries.updateStatus', $inquiry->id) }}"
              method="POST">
            @csrf
            @method('PATCH')

            <label>Status</label>
            <select name="status" class="form-control w-25 mb-3">
                <option value="pending" {{ $inquiry->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="responded" {{ $inquiry->status == 'responded' ? 'selected' : '' }}>Responded</option>
                <option value="closed" {{ $inquiry->status == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>

            <button class="btn btn-success">Update Status</button>
        </form>
    </div>
</div>
@endsection