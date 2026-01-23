@extends('layouts.app')

@section('title', 'Manage Rooms')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Rooms</h2>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Room
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Capacity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                    <tr>
                        <td>
                            @if($room->image_url)
                                <img src="{{ asset('storage/' . $room->image_url) }}" class="rounded" width="50" height="50" style="object-fit: cover;">
                            @else
                                <span class="text-muted">No Img</span>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $room->name }}</td>
                        <td><span class="badge bg-info text-dark">{{ ucfirst($room->type) }}</span></td>
                        <td>₱{{ number_format($room->price, 2) }}</td>
                        <td>{{ $room->capacity }} Guests</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this room?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No rooms found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $rooms->links() }}
        </div>
    </div>
</div>
@endsection