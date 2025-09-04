<?php

namespace App\Livewire\Jobs;

use App\Models\Job;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedTag = null;

    protected $queryString = ['search', 'selectedTag', 'page'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedTag()
    {
        $this->resetPage();
    }

    public function render()
    {
        $jobs = Job::with(['tags', 'employer'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedTag, function ($query) {
                $query->whereHas('tags', function ($q) {
                    $q->where('name', $this->selectedTag);
                });
            })
            ->latest()
            ->paginate(15);

        return view('livewire.jobs.index', [
            'jobs' => $jobs,
            'tags' => Tag::all(),
        ]);
    }
}
