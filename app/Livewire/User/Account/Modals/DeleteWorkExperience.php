<?php

namespace App\Livewire\User\Account\Modals;

use App\Models\WorkExperience;
use Livewire\Component;

class DeleteWorkExperience extends Component
{

    public $work_experience_id;

    public  function delete()
    {
        $work = WorkExperience::find($this->work_experience_id);

        if ($work) {
            $work->delete();
        }

        $this->dispatch('close-work-modal');
        $this->dispatch('reloadWorkExperience');
        $this->dispatch('notify', message: 'Work experience deleted successfully.', status: 'Danger');
    }

    public function render()
    {
        return view('livewire.user.account.modals.delete-work-experience');
    }
}
