<div class="max-w-[1200px] mx-auto mb-16 space-y-8 pt-30 px-4">
    <!-- Heading -->
    <div class="text-center space-y-2">
        <h1 class="text-3xl font-bold text-gray-800">Create Your Account ✨</h1>
        <p class="text-sm text-gray-500">
            Fill in the details below to get started. Fields marked with 
            <span class="text-red-500 font-bold">*</span> are required.
        </p>
        <p class="text-sm font-medium text-gray-600">
            Already have an account? 
            <a href="/login" class="text-blue-600 hover:underline">Login here</a>.
        </p>
    </div>

    <form wire:submit.prevent="register" class="bg-white shadow-md rounded-2xl p-8" enctype="multipart/form-data">
        <!-- Personal Info -->
        <h2 class="text-xl font-semibold text-gray-800 mb-4">👤 Personal Information</h2>
        <div class="grid gap-6 mb-8 md:grid-cols-3">
            <x-forms.input label="First Name" name="first_name" type="text" wire:model.defer="first_name"/>
            <x-forms.input label="Middle Name" name="middle_name" type="text" :required="false" wire:model.defer="middle_name"/>
            <x-forms.input label="Last Name" name="last_name" type="text" wire:model.defer="last_name"/>
            <x-forms.input label="Birthdate" name="birthdate" type="date" wire:model.defer="birthdate"/>
            <x-forms.input label="Email Address" name="email" type="email" wire:model.defer="email"/>
            <x-forms.input label="Phone Number" name="phone_number" type="text" wire:model.defer="phone_number"/>
        </div>

        <x-forms.divider/>

        <!-- Address -->
        <h2 class="text-xl font-semibold text-gray-800 mb-4">📍 Address</h2>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <x-forms.input label="Street" name="street" type="text" wire:model.defer="street"/>
            <x-forms.input label="Barangay" name="barangay" type="text" wire:model.defer="barangay"/>
        </div>
        <div class="grid gap-6 mb-8 md:grid-cols-3">
            <x-forms.input label="City" name="city" type="text" wire:model.defer="city"/>
            <x-forms.input label="Province" name="province" type="text" wire:model.defer="province"/>
            <x-forms.input label="Zip Code" name="zip_code" type="text" wire:model.defer="zip_code"/>
        </div>

        <x-forms.divider/>

        <!-- Bio -->
        <h2 class="text-xl font-semibold text-gray-800 mb-4">📝 About You</h2>
        <div class="mb-8">
            <x-forms.textarea label="Short Bio" name="bio" placeholder="Tell us a little about yourself..." wire:model.defer="bio"/>
        </div>

        <x-forms.divider/>

        <!-- Password -->
        <h2 class="text-xl font-semibold text-gray-800 mb-4">🔒 Security</h2>
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <x-forms.input label="Password" name="password" type="password" wire:model.defer="password"/>
            <x-forms.input label="Confirm Password" name="password_confirmation" type="password" wire:model.defer="password_confirmation"/>
        </div>

        <!-- Terms -->
        <div class="flex items-start mb-8">
            <input id="terms" type="checkbox" class="w-4 h-4 mt-1 border border-gray-300 rounded" wire:model="terms"/>
            <label for="terms" class="ms-2 text-sm text-gray-600">
                I agree with the 
                <a href="/terms-and-conditions" class="text-blue-600 hover:underline">terms and conditions</a>.
            </label>
        </div>

        <!-- Button -->
        <div class="text-center">
            <x-forms.button class="py-3 text-lg font-semibold" type="submit">
                Create Account
            </x-forms.button>
        </div>
    </form>
</div>
