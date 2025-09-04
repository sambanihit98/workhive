<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{

    public function create()
    {
        return view('auth-user.register');
    }


    public function store(Request $request)
    {
        //this will validated all input at once
        $validated = $request->validate([
            'first_name' => ['required'],
            'middle_name'  => ['nullable', 'string'],
            'last_name' => ['required'],
            'birthdate' => ['required'],
            'phone_number' => ['required'],
            'bio' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(5)->letters()->numbers()],
            'street'   => ['required'],
            'barangay' => ['required'],
            'city'     => ['required'],
            'province' => ['required'],
            'zip_code' => ['required']
        ]);

        //it will then be extracted to store to each of their table
        $userAttributes = array_merge($request->only([
            'first_name',
            'middle_name',
            'last_name',
            'birthdate',
            'phone_number',
            'email',
            'bio',
            'password',
        ]), ['avatar' => 'storage/avatar/default-avatar.png']);

        $userAddress = Arr::only($validated, [
            'street',
            'barangay',
            'city',
            'province',
            'zip_code',
        ]);

        $user = User::create($userAttributes);
        $user->user_address()->create($userAddress);

        Auth::login($user);

        session()->flash('message', 'Logged in!');
        session()->flash('status', 'Success');
        return redirect('/');
    }

    public function index(User $user)
    {
        return view('auth-user.index', ['user' => $user]);
    }

    public function edit()
    {
        return view('auth-user.edit');
    }

    public function update(Request $request, User $user)
    {

        //this will validated all input at once
        $validated = $request->validate([
            'first_name' => ['required'],
            'middle_name'  => ['nullable', 'string'],
            'last_name' => ['required'],
            'birthdate' => ['required'],
            'phone_number' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(Auth::id())], //code works, just vscode doesnt understand
            'street'   => ['required'],
            'barangay' => ['required'],
            'city'     => ['required'],
            'province' => ['required'],
            'zip_code' => ['required']
        ]);

        //it will then be extracted to store to each of their table
        $userAttributes = Arr::only($validated, [
            'first_name',
            'middle_name',
            'last_name',
            'birthdate',
            'phone_number',
            'email',
        ]);
        $userAddress = Arr::only($validated, [
            'street',
            'barangay',
            'city',
            'province',
            'zip_code',
        ]);

        // Update user and address
        $user->update($userAttributes);
        $user->user_address()->update($userAddress); // make sure the relation exists

        session()->flash('message', 'Updated user details successfully!');
        session()->flash('status', 'Success');
        return redirect('/user-account');
    }

    public function edit_password()
    {
        return view('auth-user.edit-password');
    }

    public function update_password(Request $request, User $user)
    {

        //this will validated all input at once
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(5)->letters()->numbers()],
        ]);
        $user->update($validated);

        session()->flash('message', 'Updated password successfully!');
        session()->flash('status', 'Success');
        return redirect('/user-account');
    }

    public function edit_bio()
    {
        return view('auth-user.edit-bio');
    }

    public function update_bio(Request $request, User $user)
    {

        //this will validated all input at once
        $validated = $request->validate([
            'bio' => ['required'],
        ]);
        $user->update($validated);

        session()->flash('message', 'Updated bio successfully!');
        session()->flash('status', 'Success');
        return redirect('/user-account');
    }

    public function edit_avatar()
    {
        return view('auth-user.edit-avatar');
    }

    public function update_avatar(Request $request, User $user)
    {
        $request->validate([
            'avatar' => ['required', File::types(['jpg', 'jpeg', 'png'])]
        ]);

        //store image to the avatar folder
        $logoPath = $request->avatar->store('avatar');
        $user->update(['avatar' => $logoPath]);

        session()->flash('message', 'Updated avatar successfully!');
        session()->flash('status', 'Success');
        return redirect('/user-account');
    }
}
