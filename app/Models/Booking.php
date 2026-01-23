<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'guests',
        'full_name',
        'email',
        'phone',
        'special_requests',
        'total_amount',
        'status',
        'payment_method',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Generate unique booking ID
     */
    public static function generateBookingId()
    {
        return 'BK' . time() . rand(1000, 9999);
    }

    /**
     * Get the user that owns the booking
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the room that is booked
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Calculate number of nights
     */
    public function getNightsAttribute()
    {
        return $this->check_in->diffInDays($this->check_out);
    }

    /**
     * Scope for user bookings
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for confirmed bookings
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope for active bookings (not cancelled)
     */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'cancelled');
    }
}
