<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Booking;
use App\Models\Consultant;
use Livewire\Component;
use Livewire\WithPagination;

class AdminDashboard extends Component
{
    use WithPagination;

    public $tab = 'users';

    public function setTab($tabName)
    {
        $this->tab = $tabName;
        $this->resetPage();
    }

    public function render()
    {
        $data = [];

        if ($this->tab === 'users') {
            $data['users'] = User::paginate(10);
        } elseif ($this->tab === 'consultants') {
            $data['consultants'] = Consultant::with('user')->paginate(10);
        } elseif ($this->tab === 'bookings') {
            $data['bookings'] = Booking::with(['client', 'consultant.user', 'service'])->latest('date')->paginate(15);
        }

        return view('livewire.admin-dashboard', $data);
    }
}
