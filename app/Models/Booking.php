<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'consultant_id', 'service_id',
        'date', 'start_time', 'end_time', 'status', 'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Check if a new slot overlaps with this booking.
     * Overlap condition: new_start < existing_end AND new_end > existing_start
     */
    public static function hasConflict(int $consultantId, string $date, string $newStart, string $newEnd, ?int $excludeId = null): bool
    {
        $query = static::where('consultant_id', $consultantId)
            ->where('date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->where('start_time', '<', $newEnd)
            ->where('end_time', '>', $newStart);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
