<?php

namespace App\Livewire;

use App\Models\Employer;
use App\Models\Job;
use App\Models\Tag;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $jobs = Job::with(['tags', 'employer'])
            ->where('urgent_hiring', 0)
            ->latest()
            ->take(5)
            ->get();

        $urgent_hiring_jobs = Job::with(['tags', 'employer'])
            ->where('urgent_hiring', 1)
            ->latest()
            ->get();

        $employers = Employer::withCount('jobs')
            ->orderByDesc('jobs_count')
            ->take(5)
            ->get();

        return view('livewire.home', [
            'jobs' => $jobs,
            'urgent_hiring_jobs' => $urgent_hiring_jobs,
            'tags' => Tag::all(),
            'employers' => $employers,
        ]);
    }
}
