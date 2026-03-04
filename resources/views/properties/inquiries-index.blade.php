@extends('layouts.admin')

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
            </tr>
        </thead>
        <tbody>
            @foreach($inquiries as $inquiry)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $inquiry->property->title }}</td>
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
                    
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $inquiries->links() }}
</div>
@endsection