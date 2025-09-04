<div 
    x-show="showEditInfoModal" 
    x-on:close-user_info-modal.window="showEditInfoModal = false"
    x-transition 
    x-data="{ tab: 'personal' }" 
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 overflow-y-auto"
    style="display: none;"
>
    <div class="relative p-4 w-full max-w-4xl bg-white rounded-lg shadow dark:bg-gray-700 max-h-[90vh] overflow-y-auto"
         @click.away="showEditInfoModal = false">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Edit Account Info
            </h3>
            <button type="button" @click="showEditInfoModal = false"
                class="text-gray-400 hover:text-gray-900 hover:bg-gray-200 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>

        <div class="flex mb-4 text-white">
            <button 
                @click="tab = 'personal'" 
                :class="tab === 'personal' ? 'border-b-2 border-blue-400 text-blue-400' : 'text-gray-600'" 
                class="px-4 py-2 text-sm font-medium focus:outline-none">
                Personal Info
            </button>
            <button 
                @click="tab = 'address'" 
                :class="tab === 'address' ? 'border-b-2 border-blue-400 text-blue-400' : 'text-gray-600'" 
                class="px-4 py-2 text-sm font-medium focus:outline-none">
                Address
            </button>
        </div>


        {{-- Modal Form Body --}}
        <form class="p-4 md:p-5" wire:submit.prevent="update">

            <div x-show="tab === 'personal'" x-transition>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-7">
                    Edit your basic information. Make sure everything is correct before saving changes.
                </p>
                <div class="grid gap-4 mb-4 grid-cols-3">
                    <div class="col-span-1">
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                        <input type="text" id="first_name" wire:model="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required value="{{ $user->first_name }}">
                    </div>
                    <div class="col-span-1">
                        <label for="middle_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle Name</label>
                        <input type="text" id="middle_name" wire:model="middle_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required value="{{ $user->middle_name }}">
                    </div>
                    <div class="col-span-1">
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                        <input type="text" id="last_name" wire:model="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required value="{{ $user->last_name }}">
                    </div>
                    <div class="col-span-1">
                        <label for="birthdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Birthdate</label>
                        <input type="date" id="birthdate" wire:model="birthdate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required value="{{ $user->birthdate }}">
                    </div>
                    <div class="col-span-1">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" id="email" wire:model="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required value="{{ $user->email }}">
                    </div>
                     <div class="col-span-1">
                        <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
                        <input type="text" id="phone_number" wire:model="phone_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required value="{{ $user->phone_number }}">
                    </div>
                    <div class="col-span-3">
                        <label for="bio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bio</label>
                        <textarea id="bio" wire:model="bio" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 h-40">{{ $user->bio }}</textarea>                    
                    </div>
                </div>
            </div>

            <div x-show="tab === 'address'" x-transition>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-7">
                    Update your address below if you've moved or changed residence recently.
                </p>
                <div class="grid gap-4 grid-cols-3">
                    <div class="col-span-2">
                        <label for="street" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Street</label>
                        <input type="text" id="street" wire:model="street" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required value="{{ $address->street }}">
                    </div>

                    <div class="col-span-1">
                        <label for="barangay" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barangay</label>
                        <input type="text" id="barangay" wire:model="barangay" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required value="{{ $address->barangay }}">
                    </div>

                    <div class="col-span-1">
                        <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                        <input type="text" id="city" wire:model="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required value="{{ $address->city }}">
                    </div>

                    <div class="col-span-1">
                        <label for="province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Province</label>
                        <input type="text" id="province" wire:model="province" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required value="{{ $address->province }}">
                    </div>

                    <div class="col-span-1">
                        <label for="zip_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Zip Code</label>
                        <input type="text" id="zip_code" wire:model="zip_code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required value="{{ $address->zip_code }}">
                    </div>
                </div>
            </div>

            <x-forms.divider/>
            <p class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                Your personal information is confidential and used only in accordance with our <a href="#" class="underline">privacy policy</a>. <br>
                Having trouble updating your info? <a href="#" class="underline">Contact support</a> and we’ll help you out.
            </p>

            <div class="flex justify-end">
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Update
                </button>
            </div>

        </form>
    </div>
</div>
