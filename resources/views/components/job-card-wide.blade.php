@props(['job'])

<a href="/jobs/{{ $job->id }}" 
    class="group block p-6 bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-lg hover:border-blue-400 transition-all duration-300 ease-in-out">

    {{-- Employer Logo + Urgent --}}
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            {{-- Employer Logo or Placeholder --}}
            @if($job->employer && $job->employer->logo)
                <img src="{{ asset('storage/' . $job->employer->logo) }}" 
                    alt="{{ $job->employer->name }}" 
                    class="h-12 w-12 rounded-full object-cover border border-gray-200 shadow-sm">
            @else
                <div class="h-12 w-12 flex items-center justify-center rounded-full bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700 font-bold text-sm shadow-sm">
                    {{ strtoupper(substr($job->employer->name ?? 'N/A', 0, 2)) }}
                </div>
            @endif

            <span class="text-sm font-medium text-gray-700">{{ $job->employer->name ?? 'Unknown Employer' }}</span>
        </div>

        {{-- Urgent Hiring Badge --}}
        @if($job->urgent_hiring)
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-red-50 to-red-100 text-red-700 shadow-sm">
                🚨 Urgent Hiring
            </span>
        @endif
    </div>

    {{-- Job Title --}}
    <h3 class="text-lg md:text-xl font-semibold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">
        {{ $job->title }}
    </h3>

    {{-- Job Description --}}
    <p class="mt-2 text-sm text-gray-600 leading-relaxed">
        {{ Str::limit(strip_tags($job->description), 100) }}
    </p>

    {{-- Employment Type & Salary --}}
    <div class="flex flex-wrap items-center gap-2 mt-3 text-sm">
        <span class="px-3 py-1 rounded-full text-xs font-medium 
                    {{ $job->employment_type === 'Full Time' 
                        ? 'bg-gradient-to-r from-green-50 to-green-100 text-green-700' 
                        : 'bg-gradient-to-r from-yellow-50 to-yellow-100 text-yellow-700' }}">
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
