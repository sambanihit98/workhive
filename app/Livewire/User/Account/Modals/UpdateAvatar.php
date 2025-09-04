<?php

namespace App\Livewire\User\Account\Modals;

use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateAvatar extends Component
{
    use WithFileUploads;

    public $avatar;
    public $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function update()
    {
        $this->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:20480',
        ]);

        $path = $this->avatar->store('avatars', 'public');
        $this->user->avatar = $path;
        $this->user->save();

        $url = asset('storage/' . $path) . '?v=' . uniqid();

        $this->dispatch('close-avatar-modal');
        $this->dispatch('reload-avatar', url: $url);
        $this->dispatch('notify', message: 'Avatar updated successfully.', status: 'Info');
    }

    public function render()
    {
        return view('livewire.user.account.modals.update-avatar');
    }
}
