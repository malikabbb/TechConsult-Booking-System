<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Consultant;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_has_conflict_prevents_overlap()
    {
        $consultant = Consultant::factory()->create();
        $client = User::factory()->create(['role' => 'client']);
        $service = Service::factory()->create(['consultant_id' => $consultant->id]);

        // Existing booking 10:00 to 11:00
        Booking::create([
            'client_id' => $client->id,
            'consultant_id' => $consultant->id,
            'service_id' => $service->id,
            'date' => '2026-10-10',
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'status' => 'confirmed'
        ]);

        // Test overlap: exact same time -> Conflict!
        $this->assertTrue(Booking::hasConflict($consultant->id, '2026-10-10', '10:00:00', '11:00:00'));

        // Test overlap: overlapping end time (09:30 to 10:30) -> Conflict!
        $this->assertTrue(Booking::hasConflict($consultant->id, '2026-10-10', '09:30:00', '10:30:00'));

        // Test overlap: overlapping start time (10:30 to 11:30) -> Conflict!
        $this->assertTrue(Booking::hasConflict($consultant->id, '2026-10-10', '10:30:00', '11:30:00'));
        
        // Test no overlap: before (09:00 to 10:00) -> Safe
        $this->assertFalse(Booking::hasConflict($consultant->id, '2026-10-10', '09:00:00', '10:00:00'));

        // Test no overlap: after (11:00 to 12:00) -> Safe
        $this->assertFalse(Booking::hasConflict($consultant->id, '2026-10-10', '11:00:00', '12:00:00'));
        
        // Test cancelled booking overlap -> Safe
        Booking::create([
            'client_id' => $client->id,
            'consultant_id' => $consultant->id,
            'service_id' => $service->id,
            'date' => '2026-10-10',
            'start_time' => '13:00:00',
            'end_time' => '14:00:00',
            'status' => 'cancelled'
        ]);
        $this->assertFalse(Booking::hasConflict($consultant->id, '2026-10-10', '13:00:00', '14:00:00'));
    }
}
