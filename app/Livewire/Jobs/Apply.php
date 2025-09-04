<?php

namespace App\Livewire\Jobs;

use App\Models\Application;
use App\Models\Job;
use Livewire\Component;
use Livewire\WithFileUploads;

class Apply extends Component
{

    use WithFileUploads;

    public $job;
    public $resume;
    public $cover_letter;

    public function mount(Job $job)
    {
        $this->job = $job;

        // Prevent duplicate applications
        $hasApplied = Application::where('user_id', auth()->id())
            ->where('job_id', $job->id)
            ->exists();

        if ($hasApplied) {
            return redirect()->route('jobs.show', $job->id);
        }
    }

    public function apply()
    {
        $this->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:20480', // 20MB
            'cover_letter' => 'nullable|string',
        ]);

        // Test to see if file is uploaded
        // dd($this->resume);

        // Store file
        $path = $this->resume->store('resume', 'public');

        Application::create([
            'job_id' => $this->job->id,
            'user_id' => auth()->id(),
            'status' => 'Pending',
            'cover_letter' => $this->cover_letter ?? null,
            'resume' => $path,
        ]);

        session()->flash('message', 'Applied job successfully!');
        session()->flash('status', 'Success');

        return redirect()->route('jobs.show', $this->job->id);
    }


    public function render()
    {
        return view('livewire.jobs.apply');
    }
}
