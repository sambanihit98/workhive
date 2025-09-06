<div class="max-w-6xl mx-auto pt-30 pb-20 px-4 lg:px-0">
    {{-- Page Heading --}}
    <section class="text-center mb-12">
        <h1 class="font-extrabold text-4xl text-gray-800">
            Search Results for <span class="text-blue-600">Jobs</span>
        </h1>
        <p class="mt-3 text-gray-600 max-w-2xl mx-auto">
            We found 
            <span class="px-2 py-1 bg-blue-100 text-blue-700 font-semibold rounded-lg">
                {{ $jobs->total() }}
            </span> 
             employers that match your search
            @if($q)
                for <span class="font-medium text-gray-800">“{{ $q }}”</span>.
            @endif
        </p>
    </section>

    {{-- Job Listings --}}
    <div class="space-y-6">
        @forelse ($jobs as $job)
            <x-job-card-wide :$job />
        @empty
            <div class="col-span-full text-center text-gray-600 space-y-4">
                    <p>
                        No jobs found for <strong>{{ $q }}</strong>.
                    </p>
                    <a href="{{ url('/jobs') }}" 
                    class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg 
                            hover:bg-blue-500 transition">
                        ⬅️ Go Back to Jobs
                    </a>
                </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($jobs->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $jobs->links() }}
        </div>
    @endif
</div>
