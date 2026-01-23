<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'price',
        'capacity',
        'description',
        'amenities',
        'total_rooms',
        'available_rooms',
        'image_url',
        'is_active',
        'payment_method',
    ];

    protected $casts = [
        'amenities' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get all bookings for this room
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if room is available for given dates
     */
public function isAvailable($checkIn, $checkOut)
{
    $overlappingBookings = $this->bookings()
        ->where('status', '!=', 'cancelled')
        ->where(function ($query) use ($checkIn, $checkOut) {
            // Logic: A booking overlaps if it starts BEFORE you leave 
            // AND ends AFTER you arrive.
            $query->where('check_in', '<', $checkOut)
                  ->where('check_out', '>', $checkIn);
        })
        ->count();

    return $this->available_rooms > $overlappingBookings;
}

    /**
     * Scope for active rooms
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for filtering by type
     */
    public function scopeOfType($query, $type)
    {
        if ($type && $type !== 'all') {
            return $query->where('type', $type);
        }
        return $query;
    }

    /**
     * Scope for filtering by capacity
     */
    public function scopeWithCapacity($query, $guests)
    {
        if ($guests) {
            return $query->where('capacity', '>=', $guests);
        }
        return $query;
    }
}
