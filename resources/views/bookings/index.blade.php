@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')

<div class="booking-hero d-flex align-items-center text-white mb-5" style="background-color: #8E6E53;">
    <div class="container">
        <h1 class="fw-bold">My Bookings</h1>
        <p class="opacity-75">Your hotel reservations</p>
    </div>
</div>

<div class="container mb-5">

    <div class="row g-4">

        @forelse($bookings as $booking)
        <div class="col-md-6">
            <div class="card booking-card shadow-sm h-100">

                @if($booking->room->image_url)
                    <img src="{{ asset('storage/' . $booking->room->image_url) }}" 
                         class="card-img-top booking-img" style="height: 200px; object-fit: cover;">
                @else
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304"
                         class="card-img-top booking-img" style="height: 200px; object-fit: cover;">
                @endif

                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0 fw-bold">{{ $booking->room->name }}</h5>
                        
                        @if($booking->status === 'confirmed' || $booking->status === 'completed')
                            <span class="badge bg-success">{{ ucfirst($booking->status) }}</span>
                        @elseif($booking->status === 'cancelled')
                            <span class="badge bg-danger">{{ ucfirst($booking->status) }}</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ ucfirst($booking->status) }}</span>
                        @endif
                    </div>

                    <p class="text-muted mb-1">
                        <i class="far fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }} 
                        &rarr; 
                        {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                    </p>

                    <p class="mb-3">
                        <i class="fas fa-user-friends me-1"></i> Guests: <strong>{{ $booking->guests }}</strong>
                    </p>
                    
                    <p class="mb-3">
                        <i class="fas fa-tag me-1"></i> Total: <strong>₱{{ number_format($booking->total_amount, 2) }}</strong>
                    </p>

                    <div class="mt-auto d-flex justify-content-between gap-2">
                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                            View Details
                        </a>

                        @if($booking->status !== 'cancelled' && $booking->status !== 'completed')
                            <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                    Cancel Booking
                                </button>
                            </form>
                        @else
                            <button class="btn btn-outline-secondary btn-sm flex-grow-1" disabled>
                                {{ $booking->status === 'completed' ? 'Completed' : 'Booking Cancelled' }}
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="text-muted mb-4">
                <i class="fas fa-suitcase fa-3x mb-3"></i>
                <h3>No bookings found</h3>
                <p>You haven't made any reservations yet.</p>
            </div>
            <a href="{{ route('rooms.index') }}" class="btn btn-primary btn-lg">
                Browse Rooms
            </a>
        </div>
        @endforelse

    </div>

</div>
@endsection