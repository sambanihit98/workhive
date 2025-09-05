<?php

namespace App\Livewire\Employers\Auth;

use App\Models\Employer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Arr;

class Register extends Component
{
    public $name, $industry, $website, $email, $phonenumber, $description, $type, $number_of_employees, $password, $password_confirmation;
    public $street, $barangay, $city, $province, $zip_code; // Address fields

    // Validation rules
    protected $rules = [
        'name'                => 'required|string|max:255',
        'industry'            => 'required|string|max:255',
        'website'             => 'nullable|max:255|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w\.-]*)*\/?$/',
        'email'               => 'required|email|unique:employers,email',
        'phonenumber'         => 'required|string|max:20',
        'description'         => 'required|string|max:1000',
        'type'                => 'required|string',
        'number_of_employees' => 'required|integer',
        'password'            => 'required|string|min:8|confirmed',

        // Address validation
        'street'   => 'required|string|max:255',
        'barangay' => 'required|string|max:255',
        'city'     => 'required|string|max:255',
        'province' => 'required|string|max:255',
        'zip_code' => 'required|string|max:20',
    ];

    public function register()
    {
        $validated = $this->validate();

        // Create employer user
        $employerAttributes = Arr::only($validated, [
            'name',
            'industry',
            'website',
            'email',
            'phonenumber',
            'description',
            'type',
            'number_of_employees',
        ]);
        $employerAttributes['password'] = Hash::make($validated['password']);
        $employerAttributes['logo'] = 'logos/default-company-logo.png';

        $employer = Employer::create($employerAttributes);

        // Create employer address
        $employerAddress = Arr::only($validated, ['street', 'barangay', 'city', 'province', 'zip_code']);
        $employer->employer_addresses()->create($employerAddress);

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
