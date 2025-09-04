<?php

namespace App\Livewire\Jobs;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{

    public Job $job;
    public bool $hasApplied = false;
    public $recentJobs;

    public function mount(Job $job)
    {
        $this->job = $job;

        $this->hasApplied = Application::where('user_id', Auth::id())
            ->where('job_id', $job->id)
            ->exists();

        // Eager-load employer for the card and exclude the current job
        $this->recentJobs = Job::with('employer')
            ->latest()
            ->where('id', '!=', $job->id)
            ->take(20)
            ->get();
    }

    public function render()
    {
        return view('livewire.jobs.show');
    }
}
