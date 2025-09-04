<?php

namespace App\Livewire\Employers;

use App\Models\Employer;
use Livewire\Component;

class Jobs extends Component
{

    public Employer $employer;

    public function mount(Employer $employer)
    {
        $this->employer = $employer;
    }

    public function render()
    {

        $jobs = $this->employer->jobs()->latest()->paginate(15);

        return view('livewire.employers.jobs', ['jobs' => $jobs]);
    }
}
