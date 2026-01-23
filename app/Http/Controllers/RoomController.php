<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of rooms with filters.
     */
    public function index(Request $request)
    {
        $query = Room::active();

        // --- 1. Validate Dates ---
        if ($request->filled(['check_in', 'check_out'])) {
            $checkIn = Carbon::parse($request->check_in);
            $checkOut = Carbon::parse($request->check_out);

            // Check if Check-in is in the past (allow today)
            if ($checkIn->startOfDay()->lt(Carbon::today())) {
                session()->flash('date_error', 'Check-in date cannot be in the past.');
            }
            // Check if Check-out is not after Check-in
            elseif ($checkOut->lte($checkIn)) {
                session()->flash('date_error', 'Check-out date must be after the check-in date.');
            }
        }

        // --- 2. Validate Guests (Previous Step) ---
        if (!$request->filled('guests')) {
            session()->flash('warning', 'Guest count not set! Please input the number of guests.');
        } else {
            $query->withCapacity($request->guests);
        }

        // Apply type filter
        if ($request->filled('type')) {
            $query->ofType($request->type);
        }

        // Fetch rooms
        $rooms = $query->get();

        // Check availability ONLY if no date errors exist
        if ($request->filled(['check_in', 'check_out']) && !session()->has('date_error')) {
            $checkIn = $request->check_in;
            $checkOut = $request->check_out;

            $rooms = $rooms->filter(function ($room) use ($checkIn, $checkOut) {
                return $room->isAvailable($checkIn, $checkOut);
            });
        }

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show booking form for a specific room.
     */
    public function showBookingForm(Request $request, Room $room)
    {
        $request->validate([
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        if (! $room->isAvailable($request->check_in, $request->check_out)) {
            return back()->with('error', 'This room is not available for selected dates.');
        }

        $checkIn = new \DateTime($request->check_in);
        $checkOut = new \DateTime($request->check_out);

        // Calculate duration and total cost
        $nights = $checkIn->diff($checkOut)->days;
        $total = $room->price * $nights;

        return view('rooms.booking', compact('room', 'nights', 'total'));
    }
    
}

