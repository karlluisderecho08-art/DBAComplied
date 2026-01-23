@extends('layouts.app')

@section('title', 'Rooms - Grand Hotel')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h1 class="text-dark">Reserve Your Room</h1>
        <p class="text-muted">Find the perfect accommodation for your stay</p>
    </div>

    {{-- Date Error Banner --}}
    @if (session('date_error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Invalid Dates:</strong> {{ session('date_error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Warning Banner --}}
    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Attention:</strong> {{ session('warning') }}
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-dark ms-2">Go Back</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- DELETED THE EMPTY <div class="row"> LOOP HERE --}}

    <div class="card mb-4 border-custom">
        <div class="card-body">
            <form method="GET" action="{{ route('rooms.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Check-in Date</label>
                        <input type="date" class="form-control" name="check_in" value="{{ request('check_in') }}" min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Check-out Date</label>
                        <input type="date" class="form-control" name="check_out" value="{{ request('check_out') }}" min="{{ request('check_in') ?: date('Y-m-d') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Guests</label>
                        <select class="form-select" name="guests">
                            <option value="">--</option>
                            @foreach([1,2,3,4,5,6] as $num)
                                <option value="{{ $num }}" {{ request('guests') == $num ? 'selected' : '' }}>{{ $num == 6 ? '6+' : $num }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Room Type</label>
                        <select class="form-select" name="type">
                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Types</option>
                            <option value="standard" {{ request('type') == 'standard' ? 'selected' : '' }}>Standard</option>
                            <option value="deluxe" {{ request('type') == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                            <option value="suite" {{ request('type') == 'suite' ? 'selected' : '' }}>Suite</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse($rooms as $room)
        <div class="col-lg-6">
            <div class="card h-100 border-custom hover-shadow">
                <div class="position-relative">
                    {{-- FIXED IMAGE SOURCE --}}
                    <img src="{{ $room->image_url ? asset('storage/' . $room->image_url) : 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800' }}" 
                         class="card-img-top" 
                         alt="{{ $room->name }}" 
                         style="height: 300px; object-fit: cover;">
                         
                    <span class="badge bg-light text-dark position-absolute top-0 end-0 m-3">
                        {{ $room->available_rooms }} Available
                    </span>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h4>{{ $room->name }}</h4>
                            <div class="text-warning mb-2">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="text-muted">{{ $room->description }}</p>
                        </div>
                        <div class="text-end">
                            <h3 class="text-primary">₱{{ number_format($room->price, 0) }}</h3>
                            <small class="text-muted">per night</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p class="text-muted mb-2">
                            <i class="fas fa-users me-2"></i> Up to {{ $room->capacity }} guests
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            {{-- Added null check for amenities --}}
                            @if(is_array($room->amenities) || is_object($room->amenities))
                                @foreach($room->amenities as $amenity)
                                <span class="badge bg-light-custom text-dark">
                                    <i class="fas fa-check me-1"></i> {{ $amenity }}
                                </span>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    @if(request('check_in') && request('check_out'))
                    <form method="GET" action="{{ route('rooms.book', $room) }}">
                        <input type="hidden" name="check_in" value="{{ request('check_in') }}">
                        <input type="hidden" name="check_out" value="{{ request('check_out') }}">
                        <input type="hidden" name="guests" value="{{ request('guests') }}">
                        <button type="submit" class="btn btn-primary w-100" {{ $room->available_rooms == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-bed me-2"></i> {{ $room->available_rooms > 0 ? 'Book Now' : 'Sold Out' }}
                        </button>
                    </form>
                    @else
                    <button type="button" class="btn btn-outline-primary w-100" onclick="alert('Please select check-in and check-out dates first!')">
                        <i class="fas fa-calendar me-2"></i> Select Dates to Book
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> No rooms available for the selected criteria.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection