@extends('layouts.app')

@section('title', 'Home - Grand Hotel')

@section('content')
<!-- Hero Section -->
<div class="hero-section position-relative">
    <img src="https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxsdXh1cnklMjBob3RlbCUyMGxvYmJ5fGVufDF8fHx8MTc2NjIyODA3Nnww&ixlib=rb-4.1.0&q=80&w=1080" 
         alt="Hotel Lobby" class="w-100" style="height: 500px; object-fit: cover;">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container text-center text-white">
            <h1 class="display-4 fw-bold mb-3">Welcome back, {{ $user->name }}!</h1>
            <p class="lead mb-4">Experience luxury and comfort at Grand Hotel</p>
            <a href="{{ route('rooms.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-bed me-2"></i> Book Your Stay
            </a>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5 text-dark">Our Amenities</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card h-100 border-custom hover-shadow">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-wifi"></i>
                        </div>
                        <h5>Free Wi-Fi</h5>
                        <p class="text-muted">High-speed internet</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-custom hover-shadow">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-coffee"></i>
                        </div>
                        <h5>Restaurant</h5>
                        <p class="text-muted">24/7 dining service</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-custom hover-shadow">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <h5>Fitness Center</h5>
                        <p class="text-muted">State-of-the-art gym</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-custom hover-shadow">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-swimming-pool"></i>
                        </div>
                        <h5>Swimming Pool</h5>
                        <p class="text-muted">Indoor & outdoor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Rooms -->
<div class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 text-dark">Featured Rooms</h2>
        <div class="row g-4">
            @foreach($featuredRooms as $room)
            <div class="col-md-6">
                <div class="card h-100 border-custom hover-shadow">
                    <img src="{{ $room->image_url ? asset('storage/' . $room->image_url) : 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800' }}" 
     class="card-img-top" 
     alt="{{ $room->name }}" 
     style="height: 300px; object-fit: cover;"> 
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h4 class="card-title">{{ $room->name }}</h4>
                                <div class="text-warning mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="text-muted">{{ $room->description }}</p>
                            </div>
                            <div class="text-end">
                                <h3 class="text-primary mb-0">₱{{ number_format($room->price, 0) }}</h3>
                                <small class="text-muted">per night</small>
                            </div>
                        </div>
                        <a href="{{ route('rooms.index') }}" class="btn btn-primary w-100">
                            <i class="fas fa-calendar me-2"></i> Reserve Now
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Location -->
<div class="py-5 bg-light">
    <div class="container">
        <div class="card border-custom">
            <div class="card-body text-center p-5">
                <i class="fas fa-map-marker-alt text-primary mb-3" style="font-size: 3rem;"></i>
                <h3 class="mb-3">Visit Us</h3>
                <p class="text-muted mb-2">1016 Anonas, Sta. Mesa, Manila, Kalakhang Maynila</p>
                <p class="text-muted">Phone: +63 (02) 5335 1787</p>
            </div>
        </div>
    </div>
</div>
@endsection
