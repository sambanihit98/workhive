<?php

namespace App\Livewire\Employers;

use App\Models\Employer;
use Livewire\Component;

class Index extends Component
{

    public function render()
    {

        $employers = Employer::withCount('jobs')
            ->withAvg('reviews', 'rating') // ⬅️ calculates average rating
            ->paginate(15);

        return view('livewire.employers.index', ['employers' => $employers]);
    }
}
