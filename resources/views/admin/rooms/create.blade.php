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
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       required 
                                       placeholder="e.g. Ocean View Suite">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Room Type</label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="standard" {{ old('type') == 'standard' ? 'selected' : '' }}>Standard</option>
                                    <option value="deluxe" {{ old('type') == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                                    <option value="suite" {{ old('type') == 'suite' ? 'selected' : '' }}>Suite</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Price per Night (Php ₱)</label>
                                <input type="number" 
                                       step="0.01" 
                                       name="price" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price') }}" 
                                       required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Guest Capacity</label>
                                <input type="number" 
                                       name="capacity" 
                                       class="form-control @error('capacity') is-invalid @enderror" 
                                       value="{{ old('capacity') }}" 
                                       required>
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Total Rooms</label>
                                <input type="number" 
                                       name="total_rooms" 
                                       class="form-control @error('total_rooms') is-invalid @enderror" 
                                       value="{{ old('total_rooms') }}" 
                                       required>
                                @error('total_rooms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="4" 
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Amenities</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="WiFi" {{ in_array('WiFi', old('amenities', [])) ? 'checked' : '' }}>
                                <label class="form-check-label">Free WiFi</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="AC" {{ in_array('AC', old('amenities', [])) ? 'checked' : '' }}>
                                <label class="form-check-label">Air Conditioning</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="TV" {{ in_array('TV', old('amenities', [])) ? 'checked' : '' }}>
                                <label class="form-check-label">Smart TV</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="MiniBar" {{ in_array('MiniBar', old('amenities', [])) ? 'checked' : '' }}>
                                <label class="form-check-label">Mini Bar</label>
                            </div>
                            @error('amenities')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Room Image</label>
                            <input type="file" 
                                   name="image" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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