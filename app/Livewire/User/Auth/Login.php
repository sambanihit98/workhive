<?php

namespace App\Livewire\User\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{

    public $email = '';
    public $password = '';

    public function login()
    {
        $attributes = $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Sorry, these credentials do not match our records!',
            ]);
        }

        session()->regenerate();

        // $this->dispatch('notify', message: 'Logged in!', status: 'Success');

        return redirect()->intended('/')->with('notify', [
            'message' => 'Logged in!',
            'status'  => 'Success',
        ]);
    }

    public function render()
    {
        return view('livewire.user.auth.login');
    }
}
