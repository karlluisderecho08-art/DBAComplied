@extends('layouts.app')

@section('title', 'Forgot Password - Grand Hotel')

@section('content')
<div class="auth-page min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-custom">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="hotel-logo-lg mx-auto mb-3">
                                <i class="fas fa-hotel"></i>
                            </div>
                            <h2 class="fw-bold">Forgot Password</h2>
                            <p class="text-muted">Enter your email to receive a password reset link</p>
                        </div>

                        @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       placeholder="Enter your registered email"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-envelope me-2"></i> Send Reset Link
                            </button>

                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-primary">
                                    <i class="fas fa-arrow-left me-1"></i> Back to Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
