@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4>Generate Report</h4>

    <form action="{{ route('reports.generate') }}" method="GET" class="row g-3">
        <div class="col-md-3">
            <label>From</label>
            <input type="date" name="from_date" class="form-control">
        </div>
        <div class="col-md-3">
            <label>To</label>
            <input type="date" name="to_date" class="form-control">
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Generate Report</button>
        </div>
    </form>
</div>
@endsection