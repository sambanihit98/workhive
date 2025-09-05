<?php

namespace App\Livewire\Employers\Auth;

use App\Models\Employer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{

    public $name, $industry, $website, $email, $phonenumber, $description, $type, $number_of_employees, $password, $password_confirmation;

    // Validation rules
    protected $rules = [
        'name'                => 'required|string|max:255',
        'industry'            => 'required|string|max:255',
        'website'             => 'nullable|max:255|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w\.-]*)*\/?$/',
        'email'               => 'required|email|unique:users,email',
        'phonenumber'         => 'required|string|max:20',
        'description'         => 'required|string|max:1000',
        'type'                => 'required|string',
        'number_of_employees' => 'required|integer',
        'password'            => 'required|string|min:8|confirmed',
    ];

    public function register()
    {
        $validated = $this->validate(); //Livewire will automatically look for a protected $rules property inside your component and use those rules for validation.

        // Create employer user
        $employer = Employer::create([
            'name'                => $validated['name'],
            'email'               => $validated['email'],
            'password'            => Hash::make($validated['password']),
            'phonenumber'         => $validated['phonenumber'],
            'industry'            => $validated['industry'],
            'website'             => $validated['website'],
            'description'         => $validated['description'],
            'type'                => $validated['type'],
            'number_of_employees' => $validated['number_of_employees'],
            'logo'                => 'logos/default-company-logo.png',
        ]);

        // Log in the user
        Auth::guard('employer')->login($employer);

        session()->regenerate();

        return redirect()->intended(route('filament.employer.pages.dashboard'));
    }

    public function render()
    {
        return view('livewire.employers.auth.register');
    }
}
