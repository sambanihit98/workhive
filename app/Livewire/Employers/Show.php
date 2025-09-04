<?php

namespace App\Livewire\Employers;

use App\Models\Employer;
use Livewire\Component;

class Show extends Component
{

    public Employer $employer;

    public function mount(Employer $employer)
    {
        $this->employer = $employer;
    }

    public function render()
    {
        return view('livewire.employers.show');
    }
}
