<?php

namespace App\Livewire\User\Account\Modals;

use App\Models\Education;
use Livewire\Component;

class EditEducation extends Component
{

    public $education_id;
    public $school_name, $degree, $field_of_study, $academic_level, $start_year, $end_year, $is_current;

    public function mount($education_id)
    {
        $education = Education::findOrFail($education_id);

        $this->education_id    = $education_id;
        $this->school_name     = $education->school_name;
        $this->degree          = $education->degree;
        $this->field_of_study  = $education->field_of_study;
        $this->academic_level  = $education->academic_level;
        $this->start_year      = $education->start_year;
        $this->end_year        = $education->end_year;
        $this->is_current      = (bool) $education->is_current;
    }

    public function update()
    {
        $validated = $this->validate([
            'school_name'    => 'required|string|max:255',
            'degree'         => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'academic_level' => 'required|string|max:255',
            'start_year'     => 'required|integer|digits:4',
            'end_year'       => 'nullable|integer|gte:start_year',
            'is_current'     => 'nullable'
        ]);

        //returns true on is_current if end_year is empty
        //overrides the is_current validated value
        $validated['is_current'] = empty($validated['end_year']);

        //find the record then update it
        $education = Education::findOrFail($this->education_id);
        $education->update($validated);

        $this->dispatch('close-education-modal');
        $this->dispatch('reloadEducation');
        $this->dispatch('notify', message: 'Education updated successfully.', status: 'Info');
    }

    public function render()
    {
        return view('livewire.user.account.modals.edit-education');
    }
}
