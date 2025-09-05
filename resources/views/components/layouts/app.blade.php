@include('partials.header')

<div>
    <nav class="fixed top-0 left-0 w-full z-50 bg-[color:#1a2e44] shadow-sm" x-data="{ open: false }">
        <div class="flex justify-between items-center py-3 max-w-[1200px] mx-auto px-4 sm:px-0">
            <div class="flex items-center gap-x-10 text-white">
                {{-- Logo --}}
                <div>
                    <a href="/">
                        <h1 class="font-bold text-2xl">WorkHive</h1>
                        <p class="text-xs flex justify-end">For Canlaon</p>
                    </a>
                </div>

                {{-- Desktop Nav Links --}}
                <div class="hidden md:flex items-center gap-x-5 text-white">
                    <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                    <x-nav-link href="/jobs" :active="request()->is('jobs*', 'search/jobs')">Jobs</x-nav-link>
                    <x-nav-link href="/employers" :active="request()->is('employers*', 'search/employers')">Employers</x-nav-link>
                </div>
            </div>

            {{-- Desktop Auth --}}
            <div>
                <div class="hidden md:flex items-center gap-x-6 text-white">
                    @auth
                        <div class="flex items-center space-x-2 font-bold">
                            <x-nav-link href="/applications" :active="request()->is('applications*')">Applications</x-nav-link>
                            <x-nav-link href="/user/account" :active="request()->is('user/account', 'user/account/*')">My Account</x-nav-link>
                            <x-cta-button :element="'button'" data-modal-target="logout-confirmation-modal" data-modal-toggle="logout-confirmation-modal">Log Out</x-cta-button>
                        </div>
                    @endauth

                    @guest
                        <div class="flex items-center gap-x-6">
                            <div class="font-bold space-x-2">
                                <x-nav-link href="/register" :active="request()->is('register')">Sign Up</x-nav-link>
                                <x-nav-link href="/login" :active="request()->is('login')">Log In</x-nav-link>
                            </div>
                            <x-cta-button href="/employer/login">Continue as Employer</x-cta-button>
                        </div>
                    @endguest
                </div>
            </div>

            {{-- Mobile Hamburger --}}
            <div class="md:hidden flex items-center">
                <button @click="open = true" class="text-white focus:outline-none">
                    <!-- Hamburger Icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Overlay --}}
        <div x-show="open" x-cloak
             class="fixed inset-0 z-40 bg-black/30"
             x-transition.opacity
             @click="open = false">
        </div>

        {{-- Mobile Slide-in Menu --}}
        <div x-show="open" x-cloak
             x-transition:enter="transition transform duration-300 ease-out"
             x-transition:enter-start="translate-x-full opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-transition:leave="transition transform duration-300 ease-in"
             x-transition:leave-start="translate-x-0 opacity-100"
             x-transition:leave-end="translate-x-full opacity-0"
             class="fixed top-0 right-0 h-full w-64 bg-[color:#1a2e44] text-white z-50 flex flex-col p-6 space-y-4 md:hidden">

            {{-- Close button --}}
            <button @click="open = false" class="self-end text-white mb-6 focus:outline-none">
                ✕
            </button>

            {{-- Menu Links --}}
            <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
            <x-nav-link href="/jobs" :active="request()->is('jobs', 'jobs/*', 'search/jobs')">Jobs</x-nav-link>
            <x-nav-link href="/employers" :active="request()->is('employers*', 'search/employers')">Employers</x-nav-link>

            @auth
                <x-nav-link href="/applications" :active="request()->is('applications*')">Applications</x-nav-link>
                <x-nav-link href="/user/account" :active="request()->is('user/account', 'user/account/*')">My Account</x-nav-link>
                <x-cta-button :element="'button'" data-modal-target="logout-confirmation-modal" data-modal-toggle="logout-confirmation-modal">Log Out</x-cta-button>
            @endauth

            @guest
                <x-nav-link href="/register" :active="request()->is('register')">Sign Up</x-nav-link>
                <x-nav-link href="/login" :active="request()->is('login')">Log In</x-nav-link>
                <x-cta-button href="/employer/login">Continue as Employer</x-cta-button>
            @endguest
        </div>
    </nav>
        
    <main class="mx-auto">
        {{ $slot }}
    </main>
</div>

@include('partials.footer')
