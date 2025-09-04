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
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($jobs as $job)
                    <a href="/jobs/{{ $job->id }}" 
                    class="group block p-6 bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-lg hover:border-blue-400 transition-all duration-300 ease-in-out">

                        {{-- Job Title --}}
                        <h3 class="text-xl font-semibold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">
                            {{ $job->title }}
                        </h3>

                        {{-- Job Description --}}
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                            {{ Str::limit($job->description, 120) }}
                        </p>

                         <!-- Employment Type & Salary -->
                        <div class="flex items-center gap-2 mt-3 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                        {{ $job->employment_type === 'Full Time' ? 'bg-gradient-to-r from-green-50 to-green-100 text-green-700' : 'bg-gradient-to-r from-yellow-50 to-yellow-100 text-yellow-700' }}">
                                🕒 {{ $job->employment_type }}
                            </span>
                            <span class="px-3 py-1 rounded-full bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 font-medium text-xs">
                                💰 {{ $job->salary ?? 'Negotiable' }}
                            </span>
                        </div>

                        {{-- Footer --}}
                        <div class="mt-4 flex items-center justify-between text-xs text-gray-400">
                            <span>📅 {{ $job->created_at->diffForHumans() }}</span>
                            <span class="font-medium text-blue-500 group-hover:underline">View Details →</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $jobs->links() }}
            </div>
        @else
            <p class="text-gray-500 text-center">No job openings available at the moment.</p>
        @endif

    </div>
</div>
