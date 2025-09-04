<?php

namespace App\Livewire\User\Auth;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class Register extends Component
{

    public $first_name;
    public $middle_name;
    public $last_name;
    public $birthdate;
    public $phone_number;
    public $bio;
    public $email;
    public $password;
    public $password_confirmation;
    public $street;
    public $barangay;
    public $city;
    public $province;
    public $zip_code;

    public function register()
    {
        $validated = $this->validate([
            'first_name'   => ['required'],
            'middle_name'  => ['nullable', 'string'],
            'last_name'    => ['required'],
            'birthdate'    => ['required'],
            'phone_number' => ['required'],
            'bio'          => ['required'],
            'email'        => ['required', 'email', 'unique:users,email'],
            'password'     => ['required', 'confirmed', Password::min(5)->letters()->numbers()],
            'street'       => ['required'],
            'barangay'     => ['required'],
            'city'         => ['required'],
            'province'     => ['required'],
            'zip_code'     => ['required'],
        ]);

        $userAttributes = array_merge(Arr::only($validated, [
            'first_name',
            'middle_name',
            'last_name',
            'birthdate',
            'phone_number',
            'email',
            'bio',
            'password',
        ]), ['avatar' => 'storage/avatar/default-avatar.png']);

        $user = User::create($userAttributes);

        $user->user_address()->create(Arr::only($validated, [
            'street',
            'barangay',
            'city',
            'province',
            'zip_code',
        ]));

        Auth::login($user);

        // $this->dispatch('notify', message: 'Account created successfully! Logged in.', status: 'Success');

        return redirect()->intended('/')->with('notify', [
            'message' => 'Account created successfully! Logged in.',
            'status'  => 'Success',
        ]);
    }

    public function render()
    {
        return view('livewire.user.auth.register');
    }
}
