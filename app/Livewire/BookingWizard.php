<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Consultant;
use App\Models\Service;
use Carbon\Carbon;
use Livewire\Component;

class BookingWizard extends Component
{
    public Consultant $consultant;
    
    public int $step = 1;

    // Step 1: Service
    public $services;
    public $selectedServiceId = null;

    // Step 2: Date
    public $selectedDate = null;
    public $minDate;

    // Step 3: Slot
    public $availableSlots = [];
    public $selectedSlotStart = null;
    public $selectedSlotEnd = null;

    public function mount(Consultant $consultant)
    {
        $this->consultant = $consultant;
        $this->services = $consultant->services;
        $this->minDate = Carbon::tomorrow()->format('Y-m-d'); // Enforce min 1 day advance
    }

    public function selectService($serviceId)
    {
        $this->selectedServiceId = $serviceId;
        $this->step = 2;
    }

    public function selectDate()
    {
        $this->validate([
            'selectedDate' => 'required|date|after_or_equal:tomorrow',
        ]);
        
        $this->generateSlots();
        $this->step = 3;
    }

    public function generateSlots()
    {
        $service = Service::find($this->selectedServiceId);
        $duration = $service->duration;
        
        $availability = $this->consultant->availabilityForDate($this->selectedDate);
        
        $this->availableSlots = [];
        
        if (!$availability) return;

        $start = Carbon::parse($this->selectedDate . ' ' . $availability->start_time);
        $end = Carbon::parse($this->selectedDate . ' ' . $availability->end_time);

        while ($start->copy()->addMinutes($duration)->lte($end)) {
            $slotStart = $start->format('H:i:s');
            $slotEnd = $start->copy()->addMinutes($duration)->format('H:i:s');
            
            $hasConflict = Booking::hasConflict($this->consultant->id, $this->selectedDate, $slotStart, $slotEnd);
            
            if (!$hasConflict) {
                $this->availableSlots[] = [
                    'start' => $slotStart,
                    'end' => $slotEnd,
                    'label' => $start->format('h:i A') . ' - ' . $start->copy()->addMinutes($duration)->format('h:i A')
                ];
            }
            // Move start to next possible slot end (contiguous slots)
            $start->addMinutes($duration);
        }
    }

    public function selectSlot($start, $end)
    {
        $this->selectedSlotStart = $start;
        $this->selectedSlotEnd = $end;
        $this->step = 4;
    }

    public function goBack()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function confirmBooking()
    {
        // Final sanity check before inserting
        $hasConflict = Booking::hasConflict(
            $this->consultant->id, 
            $this->selectedDate, 
            $this->selectedSlotStart, 
            $this->selectedSlotEnd
        );

        if ($hasConflict) {
            session()->flash('error', 'Sorry, this time slot was just booked by someone else. Please choose another.');
            $this->generateSlots();
            $this->step = 3;
            return;
        }

        $booking = Booking::create([
            'client_id' => auth()->id(),
            'consultant_id' => $this->consultant->id,
            'service_id' => $this->selectedServiceId,
            'date' => $this->selectedDate,
            'start_time' => $this->selectedSlotStart,
            'end_time' => $this->selectedSlotEnd,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Your booking request has been sent successfully!');
    }

    public function render()
    {
        return view('livewire.booking-wizard');
    }
}
