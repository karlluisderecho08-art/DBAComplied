<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display a listing of the rooms (The missing function).
     */
    public function index()
    {
        // Get all rooms, newest first, 10 per page
        $rooms = Room::latest()->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new room.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:standard,deluxe,suite',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'total_rooms' => 'required|integer|min:1',
            'description' => 'required|string',
            'amenities' => 'nullable|array',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rooms', 'public');
        }

        Room::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'price' => $validated['price'],
            'capacity' => $validated['capacity'],
            'total_rooms' => $validated['total_rooms'],
            'available_rooms' => $validated['total_rooms'],
            'description' => $validated['description'],
            'amenities' => $validated['amenities'] ?? [],
            'image_url' => $imagePath,
            'is_active' => true,
        ]);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room created successfully!');
    }

    // Show the Edit Form
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.rooms.edit', compact('room'));
    }

    // Update the room in the database
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:standard,deluxe,suite',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'total_rooms' => 'required|integer|min:1',
            'description' => 'required|string',
            'amenities' => 'nullable|array',
            'image' => 'nullable|image|max:2048',
        ]);

        // Handle Image Upload (Only if a new one is uploaded)
        if ($request->hasFile('image')) {
            // Delete old image
            if ($room->image_url && Storage::disk('public')->exists($room->image_url)) {
                Storage::disk('public')->delete($room->image_url);
            }
            // Store new image
            $room->image_url = $request->file('image')->store('rooms', 'public');
        }

        // Update fields
        $room->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'price' => $validated['price'],
            'capacity' => $validated['capacity'],
            'total_rooms' => $validated['total_rooms'],
            'description' => $validated['description'],
            'amenities' => $validated['amenities'] ?? [],
            'image_url' => $room->image_url, // Keep old one if not changed
        ]);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        if ($room->image_url && Storage::disk('public')->exists($room->image_url)) {
            Storage::disk('public')->delete($room->image_url);
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully');
    }
}