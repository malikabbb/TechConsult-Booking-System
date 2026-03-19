<?php

namespace App\Livewire;

use App\Models\Booking;
use Carbon\Carbon;
use Livewire\Component;

class ConsultantDashboard extends Component
{
    public function updateStatus($bookingId, $status)
    {
        $booking = Booking::findOrFail($bookingId);
        
        // Ensure owner
        if ($booking->consultant_id !== auth()->user()->consultant->id) {
            abort(403);
        }

        $booking->update(['status' => $status]);
        session()->flash('success', 'Booking status updated to ' . $status);
    }

    public function render()
    {
        $consultant = auth()->user()->consultant;
        $today = Carbon::today()->format('Y-m-d');

        $todaysBookings = Booking::with(['client', 'service'])
            ->where('consultant_id', $consultant->id)
            ->where('date', $today)
            ->orderBy('start_time')
            ->get();

        $upcomingBookings = Booking::with(['client', 'service'])
            ->where('consultant_id', $consultant->id)
            ->where('date', '>', $today)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('livewire.consultant-dashboard', [
            'todaysBookings' => $todaysBookings,
            'upcomingBookings' => $upcomingBookings,
        ]);
    }
}
