<div class="space-y-10">
    {{-- ------------------------------------------------------------------------------------------------------------ --}}
    {{-- Hero / Banner Section --}}
    <section class="relative flex items-center justify-center h-[110vh] bg-cover bg-center" 
        style="background-image: url('/storage/img/plain-bg-img.jpg')">

        {{-- Overlay for readability --}}
        <div class="absolute inset-0 bg-gradient-to-b from-white/80 via-white/60 to-white/90"></div>

        <div class="relative z-10 text-center max-w-3xl mx-auto px-6">
            <h1 class="font-extrabold text-5xl md:text-6xl lg:text-7xl leading-tight text-gray-900">
                Opportunities That Match Your <span class="text-blue-600">Ambition</span>
            </h1>

            <p class="mt-6 text-lg md:text-xl text-gray-700">
                Discover your dream job, explore exciting opportunities, and connect with top companies looking for talents like you.
            </p>

            {{-- Search Bar --}}
            <x-forms.form action="/search/jobs" class="mt-8 flex justify-center" method="GET">
                <div class="w-full max-w-xl">
                    <x-forms.input 
                        name="q" 
                        placeholder="🔍 Find your next job..." 
                        :label="false"
                        value="{{ request('q') }}"
                    />
                </div>
            </x-forms.form>

            {{-- CTAs --}}
            <div class="mt-8 flex justify-center space-x-4">
                <a href="/jobs" 
                class="bg-blue-600 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:bg-blue-500 transition">
                    Browse Jobs
                </a>
                <a href="/employers" 
                class="bg-white text-blue-600 font-semibold px-6 py-3 rounded-xl shadow-lg border border-blue-200 hover:bg-blue-50 transition">
                    Find Employers
                </a>
            </div>
        </div>
    </section>

    {{-- ------------------------------------------------------------------------------------------------------------ --}}
    {{-- Main Content --}}
    <section class="max-w-[1200px] mx-auto mt-12 px-4 sm:px-0">
        <!-- Heading -->
        <div class="text-center">
            <h2 class="text-3xl font-bold">🔥 Urgent Hiring Jobs</h2>
            <p class="text-gray-600 mt-2 text-sm max-w-2xl mx-auto">
                Explore opportunities that need immediate talent. These positions are 
                <strong class="text-red-500">urgent</strong> and perfect if you're ready to 
                <strong class="text-blue-600">start right away</strong>.
            </p>
        </div>

        <!-- Job Cards -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
            @foreach ($urgent_hiring_jobs as $job)
                <x-job-card :$job class="shadow-lg hover:shadow-xl transition rounded-xl border border-gray-100 bg-white"/>
            @endforeach
        </div>
    </section>

    {{-- Divider --}}
    <div class="max-w-[1200px] mx-auto px-4 sm:px-0">
        <div class="bg-black/10 my-15 h-px w-full"></div>
    </div>
    
    <div class="max-w-[1200px] mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8 px-4 sm:px-0">
        {{-- Recent Jobs (2/3 width on desktop, full on mobile) --}}
        <section class="lg:col-span-2 order-1">
            <div class="flex items-center justify-between">
                <x-section-heading>Recent Jobs</x-section-heading>
                <a href="/jobs" 
                    class="flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                    See all jobs
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="mt-6 space-y-6">
                @foreach ($jobs as $job)
                    <x-job-card-wide :$job/>
                @endforeach
            </div>
        </section>

        {{-- Top Employers (1/3 width on desktop, full on mobile) --}}
        <section class="lg:col-span-1 order-2">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <x-section-heading>Top Employers</x-section-heading>
                <a href="/employers" 
                    class="flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                    See all
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                        stroke="currentColor" class="w-4 h-4 ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Employers List -->
            <div class="mt-6 space-y-4">
                @foreach ($employers as $employer)
                    <a href="/employers/{{ $employer->id }}" 
                        class="group block p-6 bg-white border border-gray-200 rounded-2xl shadow-sm 
                            hover:shadow-lg hover:border-blue-400 transition-all duration-300 ease-in-out">

                        {{-- Logo + Name --}}
                        <div class="flex items-center gap-3 mb-4">
                            @if($employer->logo)
                                <img src="{{ asset('storage/' . $employer->logo) }}" 
                                    alt="{{ $employer->name }}" 
                                    class="h-10 w-10 rounded-full object-cover border border-gray-200">
                            @else
                                <div class="h-10 w-10 flex items-center justify-center rounded-full bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 font-bold text-sm">
                                    {{ strtoupper(substr($employer->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">
                                    {{ $employer->name }}
                                </h3>
                                <p class="text-sm text-gray-600">{{ $employer->industry }}</p>
                            </div>
                        </div>

                        {{-- Active Jobs --}}
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 rounded-full bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 font-medium text-xs">
                                💼 {{ $employer->jobs_count }} Active Jobs
                            </span>
                        </div>

                        {{-- Footer --}}
                        <div class="mt-4 flex items-center justify-between text-xs text-gray-400">
                            <span>🏢 Employer</span>
                            <span class="font-medium text-blue-500 group-hover:underline">View Profile →</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    </div>

</div>