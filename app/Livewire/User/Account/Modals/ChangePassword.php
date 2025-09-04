<?php

namespace App\Livewire\User\Account\Modals;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{

    public $old_password;
    public $new_password;
    public $new_password_confirmation;

    public function update()
    {
        $this->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->guard('web')->user();

        if (!Hash::check($this->old_password, $user->password)) {
            return $this->addError('old_password', 'The old password is incorrect.');
        }

        $user->password = Hash::make($this->new_password);
        $user->save();

        $this->dispatch('close-change_password-modal');
        $this->dispatch('notify', message: 'Password updated successfully.', status: 'Info');
    }


    public function render()
    {
        return view('livewire.user.account.modals.change-password');
    }
}
