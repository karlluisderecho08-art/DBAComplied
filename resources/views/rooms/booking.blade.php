@extends('layouts.app')

@section('title', 'Complete Booking - Grand Hotel')

@section('content')
<div class="container py-5">
    <div class="card border-custom">
        <div class="card-header text-white" style="background-color: #8E6E53;">
            <h4 class="mb-0">Complete Your Booking</h4>
            <p class="mb-0 small">{{ $room->name }} - ₱{{ number_format($room->price, 0) }} per night</p>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('bookings.store') }}">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <input type="hidden" name="check_in" value="{{ request('check_in') }}">
                <input type="hidden" name="check_out" value="{{ request('check_out') }}">
                <input type="hidden" name="guests" value="{{ request('guests') }}">

                <div class="row">
                    <div class="col-md-7">
                        <h5 class="mb-4">Guest Information</h5>
                        
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name *</label>
                            <input type="text" 
                                   class="form-control @error('full_name') is-invalid @enderror" 
                                   id="full_name" 
                                   name="full_name" 
                                   value="{{ old('full_name', Auth::user()->name) }}"
                                   required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', Auth::user()->email) }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="payment_method" class="form-label fw-bold">Payment Method *</label>
                            <select name="payment_method" id="payment_method" class="form-select p-3" required>
                                <option value="" disabled selected>Select a payment method</option>
                                <option value="credit_card">Credit / Debit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="gcash">GCash</option>
                                <option value="cash_on_arrival">Pay at Hotel (Cash)</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a payment method.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="special_requests" class="form-label">Special Requests</label>
                            <textarea class="form-control" 
                                      id="special_requests" 
                                      name="special_requests" 
                                      rows="3" 
                                      placeholder="Any special requirements?">{{ old('special_requests') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <h5 class="mb-4">Booking Summary</h5>
                        
                        <div class="card bg-light border-custom">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Room</span>
                                    <span>{{ $room->name }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Check-in</span>
                                    <span>{{ \Carbon\Carbon::parse(request('check_in'))->format('M d, Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Check-out</span>
                                    <span>{{ \Carbon\Carbon::parse(request('check_out'))->format('M d, Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Guests</span>
                                    <span>{{ request('guests') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Nights</span>
                                    <span>{{ $nights }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>Total</strong>
                                    <strong class="text-primary fs-4">₱{{ number_format($total, 2) }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-3">
                            <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check me-2"></i> Confirm Booking
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
