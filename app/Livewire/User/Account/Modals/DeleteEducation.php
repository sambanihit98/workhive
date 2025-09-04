<?php

namespace App\Livewire\User\Account\Modals;

use App\Models\Education;
use Livewire\Component;

class DeleteEducation extends Component
{

    public $education_id;

    public  function delete()
    {
        $education = Education::find($this->education_id);

        if ($education) {
            $education->delete();
        }

        $this->dispatch('close-education-modal');
        $this->dispatch('reloadEducation');
        $this->dispatch('notify', message: 'Education deleted successfully.', status: 'Danger');
    }

    public function render()
    {
        return view('livewire.user.account.modals.delete-education');
    }
}
