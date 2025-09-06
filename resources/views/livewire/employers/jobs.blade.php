<div>
    <div class="px-4 md:px-0 space-y-10 max-w-[1200px] mx-auto pt-30">

         <!-- Section Title -->
        <div class="mb-10 text-center">
            <h2 class="text-2xl md:text-4xl font-bold text-gray-800">
                {{ $employer->name }} <span class="text-blue-600">Job Openings</span>
            </h2>
            <p class="mt-2 text-gray-600 text-sm md:text-base">
                Explore exciting career opportunities and join a growing team.
            </p>
        </div>

        @if($jobs->count() > 0)
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
        @else
            <p class="text-gray-500 text-center">No job openings available at the moment.</p>
        @endif

    </div>
</div>
