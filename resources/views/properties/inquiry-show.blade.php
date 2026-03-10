@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4>Inquiry Details</h4>
    <!-- back to inquiries list -->
    <a href="{{ route('inquiries.index') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Back to Inquiries
    </a>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- success message -->
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="card p-4">
        <p><strong>Property:</strong> {{ $inquiry->property->name }}</p>
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
                <option value="approved" {{ $inquiry->status == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ $inquiry->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            <button class="btn btn-success">Update Status</button>
        </form>
    </div>
</div>
@endsection