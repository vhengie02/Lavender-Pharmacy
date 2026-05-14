@extends('layouts.app')

@section('title', 'Register - Lavender Pharmacy')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body p-5">
                <h1 class="card-title text-center mb-4" style="color: #5D3A66;">
                    <i class="fas fa-user-plus"></i> Create Account
                </h1>

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contact_number" class="form-label">Contact Number (Optional)</label>
                        <input type="tel" class="form-control" id="contact_number" name="contact_number" value="{{ old('contact_number') }}">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address (Optional)</label>
                        <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3" style="background-color: #B57EDC; border-color: #B57EDC;">
                        Register
                    </button>
                </form>

                <p class="text-center">
                    Already have an account? <a href="{{ route('login') }}">Login here</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
