<?php

namespace App\Livewire\User\Applications\Modals;

use App\Models\Application;
use Livewire\Component;

class Withdraw extends Component

{

    public $application_id;
    public $status;

    public function mount($application_id)
    {
        $application = Application::findOrFail($application_id);
        $this->status = $application->status;
    }

    public function withdraw()
    {
        $application = Application::findOrFail($this->application_id);

        $application->update([
            'status' => 'Withdrawn',
        ]);

        $this->dispatch('close-withdraw-modal');
        $this->dispatch('reloadApplications');
        $this->dispatch('notify', message: 'Application has been withdrawn successfully.', status: 'Secondary');
    }
    public function render()
    {
        return view('livewire.user.applications.modals.withdraw');
    }
}
