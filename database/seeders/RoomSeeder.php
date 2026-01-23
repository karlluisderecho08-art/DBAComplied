<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'Standard Room',
                'type' => 'standard',
                'price' => 99.00,
                'capacity' => 2,
                'description' => 'Cozy room with essential amenities for a comfortable stay',
                'amenities' => json_encode(['Wifi', 'TV', 'Air Conditioning']),
                'total_rooms' => 10,
                'available_rooms' => 10,
                'image_url' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800',
                'is_active' => true,
            ],
            [
                'name' => 'Deluxe Room',
                'type' => 'deluxe',
                'price' => 150.00,
                'capacity' => 2,
                'description' => 'Spacious room with modern amenities and city view',
                'amenities' => json_encode(['Wifi', 'TV', 'Air Conditioning', 'Mini Bar']),
                'total_rooms' => 8,
                'available_rooms' => 8,
                'image_url' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800',
                'is_active' => true,
            ],
            [
                'name' => 'Executive Suite',
                'type' => 'suite',
                'price' => 300.00,
                'capacity' => 4,
                'description' => 'Luxurious suite with separate living area and premium facilities',
                'amenities' => json_encode(['Wifi', 'TV', 'Air Conditioning', 'Mini Bar', 'Coffee Machine', 'Jacuzzi']),
                'total_rooms' => 5,
                'available_rooms' => 5,
                'image_url' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800',
                'is_active' => true,
            ],
            [
                'name' => 'Presidential Suite',
                'type' => 'suite',
                'price' => 500.00,
                'capacity' => 6,
                'description' => 'Ultimate luxury with panoramic views and exclusive services',
                'amenities' => json_encode(['Wifi', 'TV', 'Air Conditioning', 'Mini Bar', 'Coffee Machine', 'Jacuzzi', 'Butler Service']),
                'total_rooms' => 2,
                'available_rooms' => 2,
                'image_url' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800',
                'is_active' => true,
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }

        $this->command->info('Rooms seeded successfully!');
    }
}
