<?php

namespace App\Livewire;

use App\Models\Consultant;
use Livewire\Component;
use Livewire\WithPagination;

class ConsultantList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Consultant::with('user');

        if (!empty($this->search)) {
            $query->where('specialization', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($q) {
                      $q->where('name', 'like', '%' . $this->search . '%');
                  });
        }

        return view('livewire.consultant-list', [
            'consultants' => $query->paginate(9),
        ]);
    }
}
