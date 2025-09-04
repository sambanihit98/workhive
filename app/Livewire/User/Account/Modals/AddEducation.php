<?php

namespace App\Livewire\User\Account\Modals;

use App\Models\Education;
use Livewire\Component;

class AddEducation extends Component
{

    public $school_name;
    public $degree;
    public $field_of_study;
    public $academic_level;
    public $start_year;
    public $end_year;
    public $is_current = false;

    public function updatedIsCurrent($value) // refers to is_current // transforms snake_case to camelCase with "updated" on the first word
    {
        if ($value) {
            $this->end_year = '';
        }
    }

    public function save()
    {
        $validated = $this->validate([
            'school_name'    => 'required|string|max:255',
            'degree'         => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'academic_level' => 'required|string|max:255',
            'start_year'     => 'required|integer',
            'end_year'       => 'nullable|integer|gte:start_year',
            'is_current'     => 'nullable'
        ]);

        //returns true on is_current if end_year is empty
        //overrides the is_current validated value
        $validated['is_current'] = empty($validated['end_year']);

        Education::create(array_merge($validated, [
            'user_id' => auth()->guard('web')->user()->id
        ]));

        $this->reset(); //clear the form
        $this->dispatch('close-education-modal'); //closes modal after submitting the form //exent located in the modal file
        $this->dispatch('reloadEducation'); //event to display the newly added data w/out refreshing the page // event located in livewire page component (Index.php)
        $this->dispatch('notify', message: 'Education added successfully.', status: 'Success');
    }

    public function render()
    {
        return view('livewire.user.account.modals.add-education');
    }
}
