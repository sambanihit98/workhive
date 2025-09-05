<div class="max-w-[1200px] mx-auto mb-16 space-y-8 pt-30 px-4 md:px-0">
    <!-- Heading -->
    <div class="text-center space-y-2">
        <h1 class="text-3xl font-bold text-gray-800">Register as an Employer 🏢</h1>
        <p class="text-sm text-gray-500">
            Fill in your company details below. Fields marked with 
            <span class="text-red-500 font-bold">*</span> are required.
        </p>
        <p class="text-sm font-medium text-gray-600">
            Already have an account? 
            <a href="/employer/login" class="text-blue-600 hover:underline">Login here</a>.
        </p>
    </div>

    <form wire:submit.prevent="register" class="bg-white shadow-md rounded-2xl p-8">
        
        <!-- Company Info -->
        <h2 class="text-xl font-semibold text-gray-800 mb-4">🏢 Company Information</h2>
        <div class="grid mb-6 md:grid-cols-1">
            <x-forms.input label="Company Name" wire:model="name" name="name" type="text"/>
        </div>
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <x-forms.input label="Industry" wire:model="industry" name="industry" type="text"/>
            <x-forms.input label="Website" wire:model="website" name="website" type="text" :required="false"/>
            <x-forms.input label="Email Address" wire:model="email" name="email" type="email"/>
            <x-forms.input label="Phone Number" wire:model="phonenumber" name="phonenumber" type="text"/>
        </div>

        <!-- Company Description -->
        <div class="mb-8">
            <x-forms.textarea label="Company Description" wire:model="description" name="description" placeholder="Tell us about your company..."></x-forms.textarea>
        </div>

        <x-forms.divider/>

        <!-- Company Details -->
        <h2 class="text-xl font-semibold text-gray-800 mb-4">📊 Company Details</h2>
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <x-forms.input label="Company Type" wire:model="type" name="type" type="text"/>
            <x-forms.input label="Number of Employees" wire:model="number_of_employees" name="number_of_employees" type="number"/>
        </div>

        <x-forms.divider/>

        <!-- Address -->
        <h2 class="text-xl font-semibold text-gray-800 mb-4">🏠 Company Address</h2>
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <x-forms.input label="Street" wire:model="street" name="street" type="text"/>
            <x-forms.input label="Barangay" wire:model="barangay" name="barangay" type="text"/>
            <x-forms.input label="City" wire:model="city" name="city" type="text"/>
            <x-forms.input label="Province" wire:model="province" name="province" type="text"/>
            <x-forms.input label="ZIP Code" wire:model="zip_code" name="zip_code" type="text"/>
        </div>

        <x-forms.divider/>

        <!-- Security -->
        <h2 class="text-xl font-semibold text-gray-800 mb-4">🔒 Security</h2>
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <x-forms.input label="Password" wire:model="password" name="password" type="password"/>
            <x-forms.input label="Confirm Password" wire:model="password_confirmation" name="password_confirmation" type="password"/>
        </div>

        <!-- Terms -->
        <div class="flex items-start mb-8">
            <input id="terms" type="checkbox" class="w-4 h-4 mt-1 border border-gray-300 rounded" required />
            <label for="terms" class="ms-2 text-sm text-gray-600">
                I agree with the 
                <a href="/terms-and-conditions" class="text-blue-600 hover:underline">terms and conditions</a>.
            </label>
        </div>

        <!-- Button -->
        <div class="text-center">
            <x-forms.button class="py-3 text-lg font-semibold">Register Company</x-forms.button>
        </div>
    </form>
</div>
