<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['consultant_id', 'name', 'duration'];

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
