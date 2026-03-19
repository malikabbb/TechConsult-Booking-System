<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'specialization', 'experience_years',
        'session_price', 'office_location', 'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get availability for a given date (day of week).
     */
    public function availabilityForDate(string $date): ?Availability
    {
        $dayName = strtolower(date('l', strtotime($date)));
        return $this->availabilities()->where('day_of_week', $dayName)->first();
    }
}
