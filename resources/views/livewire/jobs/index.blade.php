<div class="px-4 md:px-0 pt-30 space-y-10 max-w-[1200px] mx-auto">
    {{-- Header Section --}}
    <section class="text-center">
        <h1 class="font-extrabold text-4xl text-gray-800">
            💼 Explore the Latest <span class="text-blue-600">Jobs</span>
        </h1>
        <p class="mt-3 text-gray-600 max-w-2xl mx-auto">
            Discover opportunities that match your skills and passion.  
            Start your journey towards your dream career today.
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

    </section>

    <section class="pt-5">

        <div class="grid lg:grid-cols-3 gap-5">
                @foreach ($jobs as $job)
                <x-job-card :$job/>
            @endforeach
        </div>

        <div class="mt-5">
            {{ $jobs->links() }}
        </div>
        
    </section>
</div>