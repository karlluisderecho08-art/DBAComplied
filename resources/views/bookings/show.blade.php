@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #8E6E53;">
                    <h4 class="mb-0">Booking {{ $booking->id }}</h4>
                    <span class="badge bg-light text-dark">{{ ucfirst($booking->status) }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Room Details</h5>
                            <h4 class="text-capitalize">{{ $booking->room->name }}</h4>
                            <p class="text-capitalize">{{ $booking->room->type }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h5 class="text-muted mb-3">Dates</h5>
                            <p class="mb-1"><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($booking->check_in)->format('F d, Y') }}</p>
                            <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($booking->check_out)->format('F d, Y') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted">Guest Information</h5>
                            <p class="mb-1">{{ Auth::user()->name }}</p>
                            <p>{{ Auth::user()->email }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h5 class="text-muted">Total Price</h5>
                            <h3 class="text-primary">₱{{ number_format($booking->total_amount, 2) }}</h3>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>

                        @if($booking->status !== 'cancelled')
                        <form action="{{ route('bookings.cancel', $booking) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking? This cannot be undone.');">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                Cancel Booking
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection