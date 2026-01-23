@extends('layouts.app')

@section('title', 'Add New Room')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-white" style="background-color: #8E6E53;">
                    <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Add New Room</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Room Name</label>
                                <input type="text" name="name" class="form-control" required placeholder="e.g. Ocean View Suite">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Room Type</label>
                                <select name="type" class="form-select" required>
                                    <option value="standard">Standard</option>
                                    <option value="deluxe">Deluxe</option>
                                    <option value="suite">Suite</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Price per Night (Php ₱)</label>
                                <input type="number" step="0.01" name="price" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Guest Capacity</label>
                                <input type="number" name="capacity" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Total Rooms</label>
                                <input type="number" name="total_rooms" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Amenities</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="WiFi">
                                <label class="form-check-label">Free WiFi</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="AC">
                                <label class="form-check-label">Air Conditioning</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="TV">
                                <label class="form-check-label">Smart TV</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="MiniBar">
                                <label class="form-check-label">Mini Bar</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Room Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Save Room
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection