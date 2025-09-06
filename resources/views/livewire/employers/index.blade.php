<div>
    <div class="px-4 md:px-0 pt-30 space-y-10 max-w-[1200px] mx-auto pt-30">
        
        {{-- Header Section --}}
        <section class="text-center">
            <h1 class="font-extrabold text-4xl text-gray-800">
                Discover Top <span class="text-blue-600">Employers</span>
            </h1>
            <p class="mt-3 text-gray-600 max-w-2xl mx-auto">
                Browse companies, explore their culture, and find out who’s hiring.  
                Your next big career move starts here.
            </p>

            {{-- Search Bar --}}
            <x-forms.form action="/search/employers" class="mt-8 flex justify-center">
                <div class="w-full max-w-xl">
                    <x-forms.input 
                        name="q" 
                        placeholder="🔍 Search for an employer or company..." 
                        :label="false"
                        value="{{ request('q') }}"
                    />
                </div>
            </x-forms.form>
        </section>

        {{-- Employers Grid --}}
        <section>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($employers as $employer)
                    <div class="group p-6 bg-white rounded-2xl border border-gray-200 shadow-sm 
                                hover:shadow-lg hover:border-blue-400 transition-all duration-300">

                        {{-- Logo & Basic Info --}}
                        <div class="flex items-center gap-4 mb-4">
                            @if($employer->logo)
                                <img src="{{ asset('storage/' . $employer->logo) }}" 
                                     alt="{{ $employer->name }}" 
                                     class="h-12 w-12 rounded-full object-cover border border-gray-200">
                            @else
                                <div class="h-12 w-12 flex items-center justify-center rounded-full bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 font-bold">
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
                                
                                {{-- Ratings as Button --}}
                                <a href="/employers/reviews/{{ $employer->id }}" 
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-100">
                                    ⭐ 
                                    @if($employer->reviews_avg_rating)
                                        <span>{{ number_format($employer->reviews_avg_rating, 1) }}/5</span>
                                    @else
                                        <span>No ratings yet</span>
                                    @endif
                                </a>

                                {{-- Active Jobs as Button --}}
                                <a href="/employers/jobs/{{ $employer->id }}" 
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-500">
                                    💼 <span>{{ $employer->jobs_count }} Active Jobs</span>
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $employers->links() }}
            </div>
        </section>
    </div>
</div>
