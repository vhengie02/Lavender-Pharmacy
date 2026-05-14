@extends('layouts.app')

@section('title', 'My Profile - Lavender Pharmacy')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1 style="color: #5D3A66;"><i class="fas fa-user"></i> My Profile</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">Name</label>
                    <p class="h5">{{ $user->name }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Email</label>
                    <p class="h5">{{ $user->email }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Contact Number</label>
                    <p class="h5">{{ $user->contact_number ?? 'Not provided' }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Address</label>
                    <p class="h5">{{ $user->address ?? 'Not provided' }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Role</label>
                    <p class="h5"><span class="badge bg-primary">{{ ucfirst($user->role) }}</span></p>
                </div>
                <a href="{{ route('profile.edit') }}" class="btn btn-primary" style="background-color: #B57EDC; border-color: #B57EDC;">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
