@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4>All Property Inquiries</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Property</th>
                <th>Tenant</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inquiries as $inquiry)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $inquiry->property->name }}</td>
                    <td>{{ $inquiry->tenant->user->name }}</td>
                    <td>
                        <span class="badge bg-{{ 
                            $inquiry->status == 'pending' ? 'warning' :
                            ($inquiry->status == 'responded' ? 'info' : 'success')
                        }}">
                            {{ ucfirst($inquiry->status) }}
                        </span>
                    </td>
                    <td>{{ $inquiry->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('inquiries.show', $inquiry->id) }}"
                           class="btn btn-sm btn-primary">View</a>

                        <form action="{{ route('inquiries.destroy', $inquiry->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this inquiry?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $inquiries->links() }}
</div>
@endsection