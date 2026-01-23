<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\Booking;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application homepage.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get featured rooms
        $featuredRooms = Room::active()
            ->whereIn('type', ['deluxe', 'suite'])
            ->take(2)
            ->get();

        // Get user's recent bookings
        $recentBookings = Booking::forUser($user->id)
            ->with('room')
            ->latest()
            ->take(3)
            ->get();

        return view('home', compact('user', 'featuredRooms', 'recentBookings'));
    }
}
