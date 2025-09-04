<?php

namespace App\Livewire\Jobs;

use App\Models\Job;
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
        $jobs = Job::with(['tags', 'employer'])
            ->when(
                $this->q,
                fn($query) => $query->where('title', 'LIKE', "%{$this->q}%")
            )
            ->paginate(10);

        return view('livewire.jobs.search', [
            'jobs' => $jobs,
        ]);
    }
}
