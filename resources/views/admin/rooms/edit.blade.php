@extends('layouts.app')

@section('title', 'Edit Room')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-white" style="background-color: #8E6E53;">
                    <h4 class="mb-0">Edit Room: {{ $room->name }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Room Name</label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $room->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Room Type</label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="standard" {{ old('type', $room->type) == 'standard' ? 'selected' : '' }}>Standard</option>
                                    <option value="deluxe" {{ old('type', $room->type) == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                                    <option value="suite" {{ old('type', $room->type) == 'suite' ? 'selected' : '' }}>Suite</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Price ($)</label>
                                <input type="number" 
                                       step="0.01" 
                                       name="price" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price', $room->price) }}" 
                                       required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Capacity</label>
                                <input type="number" 
                                       name="capacity" 
                                       class="form-control @error('capacity') is-invalid @enderror" 
                                       value="{{ old('capacity', $room->capacity) }}" 
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
                                       value="{{ old('total_rooms', $room->total_rooms) }}" 
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
                                      required>{{ old('description', $room->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Amenities</label>
                            @php 
                                // Ensure $currentAmenities is always an array
                                $currentAmenities = old('amenities', $room->amenities ?? []);
                                if (!is_array($currentAmenities)) {
                                    $currentAmenities = [];
                                }
                            @endphp

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="WiFi" {{ in_array('WiFi', $currentAmenities) ? 'checked' : '' }}>
                                <label class="form-check-label">Free WiFi</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="AC" {{ in_array('AC', $currentAmenities) ? 'checked' : '' }}>
                                <label class="form-check-label">AC</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="TV" {{ in_array('TV', $currentAmenities) ? 'checked' : '' }}>
                                <label class="form-check-label">TV</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="MiniBar" {{ in_array('MiniBar', $currentAmenities) ? 'checked' : '' }}>
                                <label class="form-check-label">Mini Bar</label>
                            </div>
                            @error('amenities')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Room Image</label>
                            @if($room->image_url)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $room->image_url) }}" alt="Current Image" width="100" class="rounded">
                                    <small class="text-muted d-block">Current Image</small>
                                </div>
                            @endif
                            <input type="file" 
                                   name="image" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   accept="image/*">
                            <small class="text-muted">Leave blank to keep current image</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Update Room</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection