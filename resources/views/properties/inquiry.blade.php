@extends('layouts.app')

@section('content')
<div class="container py-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    <h4>Inquire about: {{ $property->title }}</h4>

    <form action="{{ route('inquiries.store') }}" method="POST">
        @csrf

        <input type="hidden" name="property_id" value="{{ $property->id }}">

        <div class="mb-3">
            <label class="form-label">Your Message</label>
            <textarea name="message" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Send Inquiry
        </button>
    </form>
</div>
@endsection