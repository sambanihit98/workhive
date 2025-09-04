<?php

namespace App\Livewire\User\Account\Modals;

use App\Models\WorkExperience;
use Livewire\Component;

class EditWorkExperience extends Component
{

    public $work_experience_id;
    public $company_name, $job_title, $location, $start_date, $end_date, $is_current, $description;

    public function mount($work_experience_id)
    {
        $experience = WorkExperience::findOrFail($work_experience_id);

        $this->work_experience_id = $work_experience_id;
        $this->company_name       = $experience->company_name;
        $this->job_title          = $experience->job_title;
        $this->location           = $experience->location;
        $this->start_date         = $experience->start_date;
        $this->end_date           = $experience->end_date;
        $this->is_current         = (bool) $experience->is_current;
        $this->description        = $experience->description;
    }

    public function update()
    {
        $validated = $this->validate([
            'company_name' => 'required|string|max:255',
            'job_title'    => 'required|string|max:255',
            'location'     => 'string|max:255',
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
            'is_current'   => 'nullable',
            'description'  => 'nullable|string',
        ]);

        //returns true on is_current if end_date is empty
        //overrides the is_current validated value
        $validated['is_current'] = empty($validated['end_date']);

        //find the record then update it
        $experience = WorkExperience::findOrFail($this->work_experience_id);
        $experience->update($validated);

        $this->dispatch('close-work-modal');
        $this->dispatch('reloadWorkExperience');
        $this->dispatch('notify', message: 'Work experience updated successfully.', status: 'Info');
    }

    public function render()
    {
        return view('livewire.user.account.modals.edit-work-experience');
    }
}
