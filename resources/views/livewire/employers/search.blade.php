<div class="max-w-6xl mx-auto pt-30 pb-20 px-4 lg:px-0">

    {{-- Page Heading --}}
    <section class="text-center mb-12">
        <h1 class="font-extrabold text-4xl text-gray-800">
            🔍 Search Results for <span class="text-blue-600">Employers</span>
        </h1>
        <p class="mt-3 text-gray-600 max-w-2xl mx-auto">
            We found 
            <span class="px-2 py-1 bg-blue-100 text-blue-700 font-semibold rounded-lg">
                {{ $employers->total() }}
            </span> 
             employers that match your search
            @if($q)
                for <span class="font-medium text-gray-800">“{{ $q }}”</span>.
            @endif
        </p>
    </section>

    {{-- Employers Grid --}}
    <section>
        <div class="space-y-6">
            @forelse ($employers as $employer)
                <div class="group p-6 bg-white rounded-2xl border border-gray-200 shadow-sm 
                            hover:shadow-lg hover:border-blue-400 transition-all duration-300">

                    {{-- Logo & Basic Info --}}
                    <div class="flex items-center gap-4 mb-4">
                        @if($employer->logo)
                            <img src="{{ asset($employer->logo) }}" 
                                 alt="{{ $employer->name }}" 
                                 class="h-12 w-12 rounded-full object-cover border border-gray-200">
                        @else
                            <div class="h-12 w-12 flex items-center justify-center rounded-full 
                                        bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 font-bold">
                                {{ strtoupper(substr($employer->name, 0, 2)) }}
                            </div>
                        @endif

                        <div>
                            <a href="/employers/{{ $employer->id }}" 
                               class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition">
                                {{ $employer->name }}
                            </a>
                            <p class="text-sm text-gray-500">{{ $employer->industry }}</p>
                        </div>
                    </div>

                    {{-- Short Description --}}
                    <p class="text-sm text-gray-600 leading-relaxed line-clamp-3 mb-4">
                        {{ $employer->description }}
                    </p>

                    {{-- Stats & Actions --}}
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex gap-2">
                            {{-- Ratings --}}
                            <a href="/employers/reviews/{{ $employer->id }}" 
                               class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium 
                                      rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-100">
                                ⭐ 
                                @if($employer->reviews_avg_rating)
                                    <span>{{ number_format($employer->reviews_avg_rating, 1) }}/5</span>
                                @else
                                    <span>No ratings yet</span>
                                @endif
                            </a>

                            {{-- Active Jobs --}}
                            <a href="/employers/jobs/{{ $employer->id }}" 
                               class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium 
                                      rounded-lg bg-blue-600 text-white hover:bg-blue-500">
                                💼 <span>{{ $employer->jobs_count }} Active Jobs</span>
                            </a>
                        </div>
                    </div>
                </div>
           @empty
                <div class="col-span-full text-center text-gray-600 space-y-4">
                    <p>
                        No employers found for <strong>{{ $q }}</strong>.
                    </p>
                    <a href="{{ url('/employers') }}" 
                    class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg 
                            hover:bg-blue-500 transition">
                        ⬅️ Go Back to Employers
                    </a>
                </div>
            @endforelse

        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $employers->links() }}
        </div>
    </section>
</div>
