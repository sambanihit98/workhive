<?php

namespace App\Livewire\User\Account;

use Livewire\Attributes\Title;
use Livewire\Component;

class Index extends Component
{

    public $user;
    public $address;
    public $work_experiences;
    public $educations;
    public $avatar;

    //--------------------------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------
    // This tells Livewire: “If you hear a workExperienceAdded event, run my reloadWorkExperience method.”
    protected $listeners = ['reloadWorkExperience', 'reloadEducation', 'reloadAccountInfo', 'reload-avatar' => 'reloadAvatar'];

    //ACCOUNT INFO
    public function reloadAccountInfo()
    {
        $user = auth()->guard('web')->user();

        $this->user = $user;
        $this->address = $user->user_address;
    }

    //AVATAR
    public function reloadAvatar()
    {
        $avatar = auth()->guard('web')->user()->avatar;
        $this->avatar = $avatar;
    }

    //WORK EXPERIENCE
    public function reloadWorkExperience()
    {
        $this->work_experiences = auth()->guard('web')->user()->work_experience()->get();
    }
    //EDUCATION
    public function reloadEducation()
    {
        $this->educations = auth()->guard('web')->user()->education()->get();
    }
    //--------------------------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------

    public function mount()
    {
        //All
        $this->user = auth()->guard('web')->user();
        $this->address = auth()->guard('web')->user()->user_address;

        //Work Experience
        $this->work_experiences = auth()->guard('web')->user()->work_experience;

        //Education
        $this->educations = auth()->guard('web')->user()->education;
    }

    //--------------------------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------
    #[Title('WorkHive - My Account')]
    public function render()
    {
        return view('livewire.user.account.index'); //it gets the components/layouts/app as its default layout
    }
}
