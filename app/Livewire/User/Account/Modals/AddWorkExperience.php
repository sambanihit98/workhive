<?php

namespace App\Livewire\User\Account\Modals;

use App\Models\WorkExperience;
use Livewire\Component;

class AddWorkExperience extends Component
{
    public $company_name;
    public $job_title;
    public $location;
    public $start_date;
    public $end_date;
    public $is_current = false;
    public $description;

    public function updatedIsCurrent($value) // refers to is_current // transforms snake_case to camelCase with "updated" on the first word
    {
        if ($value) {
            $this->end_date = null;
        }
    }

    public function save()
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

        WorkExperience::create(array_merge($validated, [
            'user_id' => auth()->guard('web')->user()->id
        ]));

        $this->reset(); //clear the form
        $this->dispatch('close-work-modal'); //closes modal after submitting the form //exent located in the modal file
        $this->dispatch('reloadWorkExperience'); //event to display the newly added data w/out refreshing the page // event located in livewire page component (Index.php)
        $this->dispatch('notify', message: 'Work experience added successfully.', status: 'Success');
    }

    public function render()
    {
        return view('livewire.user.account.modals.add-work-experience');
    }
}
