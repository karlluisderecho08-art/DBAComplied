<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        // 1. Users

        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'is_admin' => true,
            ]
        );

        $regularUser = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password123'),
                'is_admin' => false,
            ]
        );

        $this->command->info('Users created successfully.');

        // 2. Rooms
        $standardRoom = Room::create([
            'name' => 'Standard Room',
            'type' => 'standard',
            'price' => 1000.00,
            'capacity' => 2,
            'description' => 'Cozy room with essential amenities for a comfortable stay',
            'amenities' => ['Wifi', 'TV', 'Air Conditioning'],
            'total_rooms' => 10,
            'available_rooms' => 10,
            'image_url' => 'rooms/standard.jpg',
            'is_active' => true,
        ]);

        $deluxeRoom = Room::create([
            'name' => 'Deluxe Room',
            'type' => 'deluxe',
            'price' => 1500.00,
            'capacity' => 2,
            'description' => 'Spacious room with modern amenities and city view',
            'amenities' => ['Wifi', 'TV', 'Air Conditioning', 'Mini Bar'],
            'total_rooms' => 8,
            'available_rooms' => 8,
            'image_url' => 'rooms/deluxe.jpg',
            'is_active' => true,
        ]);

        Room::create([
            'name' => 'Executive Suite',
            'type' => 'suite',
            'price' => 3000.00,
            'capacity' => 4,
            'description' => 'Luxurious suite with separate living area.',
            'amenities' => ['Wifi', 'TV', 'AC', 'Mini Bar', 'Jacuzzi'],
            'total_rooms' => 5,
            'available_rooms' => 5,
            'image_url' => 'rooms/suite.jpg',
            'is_active' => true,
        ]);

        $this->command->info('Rooms created successfully.');


        // 3. Bookings

        Booking::create([
            'booking_id' => 'BK' . time() . '01',
            'user_id' => $regularUser->id,
            'room_id' => $standardRoom->id,
            'check_in' => Carbon::now()->addDays(5),
            'check_out' => Carbon::now()->addDays(7),
            'guests' => 2,
            'full_name' => $regularUser->name,
            'email' => $regularUser->email,
            'phone' => '09123456789',
            'special_requests' => 'Late check-in please',
            'total_amount' => $standardRoom->price * 2,
            'status' => 'confirmed',
            'payment_method' => 'credit_card',
        ]);

        Booking::create([
            'booking_id' => 'BK' . time() . '02',
            'user_id' => $regularUser->id,
            'room_id' => $deluxeRoom->id,
            'check_in' => Carbon::now()->subMonth(),
            'check_out' => Carbon::now()->subMonth()->addDays(1),
            'guests' => 1,
            'full_name' => $regularUser->name,
            'email' => $regularUser->email,
            'phone' => '09123456789',
            'special_requests' => null,
            'total_amount' => $deluxeRoom->price,
            'status' => 'cancelled',
            'payment_method' => 'cash_on_arrival',
        ]);

        $this->command->info('Bookings created successfully.');
    }
}