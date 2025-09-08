<?php

namespace App\Livewire\Employers;

use App\Models\Employer;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{

    use WithPagination;

    public $q = '';

    public function mount()
    {
        $this->q = request('q', ''); // grab ?q=... from URL
    }

    public function render()
    {
        $employers = Employer::query()
            ->withCount('jobs')               // include total jobs
            ->withAvg('reviews', 'rating')    // include average rating
            ->when(
                $this->q,
                fn($query) =>
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->q) . '%'])
            )
            ->paginate(10);

        return view('livewire.employers.search', [
            'employers' => $employers,
        ]);
    }
}
