<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Calculate Total Revenue (Only confirmed/completed bookings)
        $totalRevenue = Booking::where('status', '!=', 'cancelled')->sum('total_amount');

        // 2. Count Total Bookings
        $totalBookings = Booking::count();

        // 3. Count Active/Confirmed Bookings
        $activeBookings = Booking::where('status', 'confirmed')->count();

        // 4. Count Total Rooms
        $totalRooms = Room::count();

        return view('admin.dashboard', compact('totalRevenue', 'totalBookings', 'activeBookings', 'totalRooms'));
    }
}