<div class="w-full max-w-md mx-auto mt-30 bg-white shadow-xl p-8 rounded-xl">
    {{-- <h1 class="text-2xl font-bold text-center mb-6 text-blue-600">Employer Login</h1> --}}

    <x-page-heading class="mb-3 text-center">Login as Employer</x-page-heading>
    <p class="text-sm text-center text-gray-500 mt-1">Please enter your details.</p>

    <x-forms.divider/>

    <form wire:submit.prevent="authenticate" class="mt-6 space-y-5">

        <x-forms.input label="Email Address" wire:model="email" name="email" type="email" placeholder="you@example.com"/>
        <x-forms.input label="Password" wire:model="password" name="password" type="password" placeholder="••••••••"/>

        <!-- Forgot password -->
        <div class="text-right">
            <a href="/forgot-password" class="text-sm text-blue-600 hover:underline">Forgot your password?</a>
        </div>

        <!-- Submit Button -->
        <x-forms.button class="w-full py-2 justify-center font-medium">
            Login
        </x-forms.button>

    </form>

    <div class="mt-4 text-sm text-center text-gray-500">
        Don’t have an account? <a href="/employer/register" class="text-blue-500 underline">Register</a>
    </div>
</div>
