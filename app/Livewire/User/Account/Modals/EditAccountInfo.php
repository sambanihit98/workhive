<?php

namespace App\Livewire\User\Account\Modals;

use App\Models\User;
use App\Models\UserAddress;
use Livewire\Component;

class EditAccountInfo extends Component
{

    public $user;
    public $address;

    //personal info
    public $user_id, $first_name, $middle_name, $last_name, $birthdate, $email, $phone_number, $bio;
    //address
    public $street, $barangay, $city, $province, $zip_code;

    public function mount($user, $address)
    {
        $this->first_name = $user->first_name;
        $this->middle_name = $user->middle_name;
        $this->last_name = $user->last_name;
        $this->birthdate = $user->birthdate;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->bio = $user->bio;

        $this->street = $address->street;
        $this->barangay = $address->barangay;
        $this->city = $address->city;
        $this->province = $address->province;
        $this->zip_code = $address->zip_code;
    }

    public function update()
    {
        $user_id = auth()->guard('web')->user()->id;

        $validated = $this->validate([
            'first_name'   => 'required|string|max:255',
            'middle_name'  => 'nullable|string',
            'last_name'    => 'required|string|max:255',
            'birthdate'    => 'required|string|max:255',
            'email'        => 'required|email',
            'phone_number' => 'required|string|max:255',
            'bio'          => 'required|string',

            'street'       => 'required|string|max:255',
            'barangay'     => 'required|string|max:255',
            'city'         => 'required|string|max:255',
            'province'     => 'required|string|max:255',
            'zip_code'     => 'required|string|max:255'
        ]);

        $user         = User::findOrFail($user_id);
        $user_address = UserAddress::findOrFail($user_id);

        $user->update([
            'first_name'   => $validated['first_name'],
            'middle_name'  => $validated['middle_name'],
            'last_name'    => $validated['last_name'],
            'birthdate'    => $validated['birthdate'],
            'email'        => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'bio'          => $validated['bio'],
        ]);

        $user_address->update([
            'street'   => $validated['street'],
            'barangay' => $validated['barangay'],
            'city'     => $validated['city'],
            'province' => $validated['province'],
            'zip_code' => $validated['zip_code'],
        ]);

        $this->dispatch('close-user_info-modal');
        $this->dispatch('reloadAccountInfo');
        $this->dispatch('notify', message: 'Account info updated successfully.', status: 'Info');
    }

    public function render()
    {
        return view('livewire.user.account.modals.edit-account-info');
    }
}
