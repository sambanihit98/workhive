<?php

namespace App\Livewire\Employers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{

    public $email = '';
    public $password = '';

    public function mount()
    {
        if (Auth::guard('employer')->check()) {
            return redirect()->intended(route('filament.employer.pages.dashboard'));
        }
    }

    public function authenticate()
    {
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (!Auth::guard('employer')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        session()->regenerate();

        return redirect()->intended(route('filament.employer.pages.dashboard'));
    }

    public function render()
    {
        return view('livewire.employers.auth.login');
    }
}
