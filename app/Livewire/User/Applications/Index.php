<?php

namespace App\Livewire\User\Applications;

use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{

    protected $listeners = ['reloadApplications'];
    public $applications;

    public function reloadApplications()
    {
        $this->applications = auth()->guard('web')->user()->application()->latest()->get();
    }

    public function mount()
    {
        $this->applications = Application::with(['job.employer'])->where('user_id', auth()->guard('web')->id())->latest()->get();
    }

    public function render()
    {
        return view('livewire.user.applications.index');
    }
}
