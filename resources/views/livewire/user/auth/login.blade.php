<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 pt-30">
    <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">
        
        <!-- Heading -->
        <div class="text-center mb-6">
            <x-page-heading class="mb-3 text-center">Applicant Login</x-page-heading>
            <p class="text-sm text-gray-500 mt-1">
                Access your account to apply for jobs and manage your applications.
            </p>
        </div>

        <x-forms.divider text="or continue with email" />

        <!-- Login Form -->
        <form wire:submit.prevent="login" class="mt-6 space-y-5">
            <!-- Email -->
            <x-forms.input 
                label="Email Address" 
                name="email" 
                type="email" 
                placeholder="you@example.com" 
                wire:model="email"
            />
            <!-- Password -->
            <x-forms.input 
                label="Password" 
                name="password" 
                type="password" 
                placeholder="••••••••" 
                wire:model="password"
            />
            <!-- Forgot password -->
            <div class="text-right">
                <a href="/forgot-password" class="text-sm text-blue-600 hover:underline">
                    Forgot your password?
                </a>
            </div>

            <!-- Submit Button -->
            <x-forms.button type="submit" class="w-full py-2 justify-center font-medium">
                Login
            </x-forms.button>
        </form>

        <!-- Flash message -->
        @if (session()->has('message'))
            <div class="mt-4 text-center text-green-600 text-sm">
                {{ session('message') }}
            </div>
        @endif

        <!-- Footer -->
        <p class="text-center text-sm text-gray-500 mt-6">
            Don’t have an account?
            <a href="/register" class="text-blue-600 font-medium hover:underline">Sign up here</a>
        </p>
    </div>
</div>
