@extends('layouts.app')

@section('title', 'Complete Profile')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show">
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-3">
                
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>
                        Complete Your Profile
                    </h5>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('tenant.profile.update') }}" method="POST">
                        @csrf

                        {{-- Phone --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Phone Number <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="phone"
                                   class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', auth()->user()->tenant->phone ?? '') }}"
                                   placeholder="e.g. 0788 000 000"
                                   required>

                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- National ID --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                National ID
                            </label>
                            <input type="text"
                                   name="national_id"
                                   class="form-control form-control-lg @error('national_id') is-invalid @enderror"
                                   value="{{ old('national_id', auth()->user()->tenant->national_id ?? '') }}"
                                   placeholder="Enter your National ID">

                            @error('national_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Employment --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Employment / Occupation
                            </label>
                            <input type="text"
                                   name="employment"
                                   class="form-control form-control-lg @error('employment') is-invalid @enderror"
                                   value="{{ old('employment', auth()->user()->tenant->employment ?? '') }}"
                                   placeholder="e.g. Engineer, Teacher, Business Owner">

                            @error('employment')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Assigned Unit Info (Read Only if Exists) --}}
                        @if(auth()->user()->tenant && auth()->user()->tenant->unit)
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Assigned Property
                                </label>
                                <input type="text"
                                       class="form-control form-control-lg bg-light"
                                       value="{{ auth()->user()->tenant->unit->name }}"
                                       readonly>
                            </div>
                        @endif

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-2"></i>
                                Save Profile
                            </button>
                        </div>

                    </form>

                </div>

                <div class="card-footer text-muted text-center small">
                    Please complete your information before submitting maintenance requests.
                </div>

            </div>

        </div>
    </div>
</div>
@endsection