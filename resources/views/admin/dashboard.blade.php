@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">Admin Dashboard</h2>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-dark shadow h-100" style="background-color: #D7CCC8;">
                <div class="card-body">
                    <h5 class="card-title opacity-75">Total Revenue</h5>
                    <h2 class="fw-bold">₱{{ number_format($totalRevenue, 2) }}</h2>
                    <small><i class="fas fa-coins me-1"></i> Lifetime Earnings</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white shadow h-100" style="background-color: #8E6E53;">
                <div class="card-body">
                    <h5 class="card-title opacity-75">Total Bookings</h5>
                    <h2 class="fw-bold">{{ $totalBookings }}</h2>
                    <small><i class="fas fa-calendar-check me-1"></i> All time</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white shadow h-100"style="background-color: #5D4037;">
                <div class="card-body">
                    <h5 class="card-title opacity-75">Active Bookings</h5>
                    <h2 class="fw-bold">{{ $activeBookings }}</h2>
                    <small><i class="fas fa-clock me-1"></i> Currently confirmed</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white h-100" style= "background-color: #312020ff">
                <div class="card-body">
                    <h5 class="card-title opacity-75">Total Rooms</h5>
                    <h2 class="fw-bold">{{ $totalRooms }}</h2>
                    <small><i class="fas fa-door-open me-1"></i> Available to rent</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h4 class="mb-3">Quick Actions</h4>
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-outline-primary btn-lg me-2">
                <i class="fas fa-plus-circle me-1"></i> Add New Room
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary btn-lg">
                <i class="fas fa-list me-1"></i> Manage Rooms
            </a>
        </div>
    </div>
</div>
@endsection