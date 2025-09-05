<div class="px-4 md:px-0 max-w-[1200px] mx-auto py-16 pt-30">
    <!-- Company Header -->
    <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
        <!-- Logo -->
        <div class="flex-shrink-0">
            <img src="{{ asset('storage/' . $employer->logo) }}" alt="{{ $employer->name }} Logo" class="w-32 h-32 object-contain rounded-xl shadow-md">
        </div>

        <!-- Company Info -->
        <div class="flex-1 space-y-3">
            <h1 class="text-3xl font-bold text-gray-800">{{ $employer->name }}</h1>
            <p class="text-lg text-gray-600">{{ $employer->industry }}</p>

            @if($employer->location)
                <p class="text-gray-500"><span class="font-semibold">Location:</span> {{ $employer->location }}</p>
            @endif

            @if($employer->website)
                <p>
                    <a href="{{ $employer->website }}" target="_blank" class="text-blue-600 hover:underline">
                        Visit Website →
                    </a>
                </p>
            @endif
        </div>
    </div>

    <!-- Divider -->
    <div class="my-10 border-t border-gray-200"></div>

    <!-- About Section -->
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold text-gray-800">About {{ $employer->name }}</h2>
        <p class="text-gray-600 leading-relaxed">
            {{ $employer->description ?? 'No company description available at the moment.' }}
        </p>
    </div>

    <!-- Divider -->
    <div class="my-10 border-t border-gray-200"></div>

    <!-- Jobs Section -->
    <div class="space-y-6">
        <h2 class="text-2xl font-semibold text-gray-800">Job Openings</h2>
        
        @if($employer->jobs && $employer->jobs->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($employer->jobs as $job)
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
        @else
            <p class="text-gray-500">No job openings available at the moment.</p>
        @endif
    </div>

    <!-- Divider -->
    <div class="my-10 border-t border-gray-200"></div>

    <!-- Reviews Section -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800">Reviews</h2>
            <a href="{{ url('/employers/reviews/' . $employer->id) }}" 
               class="text-blue-600 hover:underline text-sm font-medium">
                View All →
            </a>
        </div>

        <!-- Overall Rating -->
        <div class="p-6 bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-2xl shadow-md mb-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">🌟 Overall Rating</h3>

            @if($employer->reviews && $employer->reviews->count() > 0)
                <div class="flex flex-col items-center">
                    <div class="flex items-center text-yellow-400 text-2xl mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= round($employer->reviews->avg('rating')) ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                        @endfor
                    </div>
                    <p class="mt-1 text-3xl font-bold text-gray-900">
                        {{ number_format($employer->reviews->avg('rating'), 1) }}
                        <span class="text-lg text-gray-600">/ 5</span>
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        Based on <span class="font-semibold">{{ $employer->reviews->count() }}</span> review{{ $employer->reviews->count() > 1 ? 's' : '' }}
                    </p>
                </div>
            @else
                <p class="text-center text-gray-500">No reviews yet for this employer.</p>
            @endif
        </div>

        <!-- Latest Reviews -->
        @if($employer->reviews && $employer->reviews->count() > 0)
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($employer->reviews->take(4) as $review)
                    <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition duration-200 relative overflow-hidden">
                        <!-- Header -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                @if($review->user && $review->user->avatar)
                                    <img src="{{ asset($review->user->avatar) }}" 
                                        alt="{{ $review->user->full_name ?? 'User' }}" 
                                        class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                        {{ strtoupper(substr($review->user->full_name ?? 'A', 0, 1)) }}
                                    </div>
                                @endif

                                <div>
                                    <p class="font-semibold text-gray-800">{{ $review->user->full_name ?? 'Anonymous User' }}</p>
                                    <p class="text-xs text-gray-500">{{ $review->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>

                            <!-- Rating -->
                            <div class="flex items-center text-yellow-400 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                @endfor
                                <span class="ml-2 text-gray-600 text-xs">({{ $review->rating }}/5)</span>
                            </div>
                        </div>

                        <!-- Comment -->
                        <p class="mt-4 text-gray-700 leading-relaxed">
                            {{ Str::limit($review->comment, 120) ?? 'No comment provided.' }}
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No reviews yet for this employer.</p>
        @endif
    </div>
</div>
