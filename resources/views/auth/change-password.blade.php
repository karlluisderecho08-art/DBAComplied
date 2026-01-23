@extends('layouts.app')

@section('title', 'Change Password - Grand Hotel')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-custom">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <a href="{{ route('home') }}" class="btn btn-light btn-sm me-3">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <div>
                            <h3 class="mb-0">Change Password</h3>
                            <p class="text-muted mb-0">Update your account password</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('password.change') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" 
                                   name="current_password"
                                   placeholder="Enter current password"
                                   required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password"
                                   placeholder="Enter new password"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation"
                                   placeholder="Confirm new password"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-lock me-2"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
