<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new booking
     */
    // app/Http/Controllers/BookingController.php

// app/Http/Controllers/BookingController.php

public function store(Request $request)
    {
        // 1. FULL VALIDATION (Must be present to populate $validated)
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|digits:11',
            'payment_method' => 'required|string',
            'special_requests' => 'nullable|string',
        ]);

        // 2. Prepare Data
        $room = Room::findOrFail($validated['room_id']);
        
        // Calculate Total Price
        $checkIn = new \DateTime($validated['check_in']);
        $checkOut = new \DateTime($validated['check_out']);
        $nights = $checkIn->diff($checkOut)->days;
        $total = $room->price * $nights;
        
        $bookingId = Booking::generateBookingId();

        // 3. Call Stored Procedure
        try {
            DB::select('CALL sp_create_booking(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                Auth::id(),
                $room->id,
                $validated['check_in'],
                $validated['check_out'],
                $validated['guests'],
                $validated['full_name'],
                $validated['email'],
                $validated['phone'],
                $validated['payment_method'],
                $validated['special_requests'] ?? null,
                $total,
                $bookingId
            ]);

            return redirect()->route('bookings.index')
                ->with('success', 'Booking confirmed via Database Transaction!');

        } catch (\Exception $e) {
            return back()->with('error', 'Booking Failed: ' . $e->getMessage());
        }
    }

    /**
     * Display user's bookings
     */
    public function index()
    {
        $bookings = Booking::forUser(Auth::id())
            ->with('room')
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Display a specific booking
     */
    public function show(Booking $booking)
    {
        // Ensure user owns this booking
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('bookings.show', compact('booking'));
    }

    /**
     * Cancel a booking
     */
    public function cancel(Booking $booking)
    {
        // Ensure the user owns this booking
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->route('bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }

    
}
