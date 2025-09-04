<div class="max-w-[1200px] mx-auto pt-32 pb-16 px-4 md:px-0">

    {{-- Applied Notification --}}
    @if ($hasApplied)
        <div class="bg-white border border-green-300 rounded-2xl shadow-lg p-6 flex items-start gap-4 mb-10">
            <!-- Icon -->
            <div class="flex-shrink-0 bg-green-100 text-green-600 rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <!-- Text Content -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-green-700">
                    Application Submitted Successfully
                </h3>
                <p class="text-gray-600 mt-1">
                    You’ve applied for this job and your application is now under review.
                    You can track its status anytime from your <a href="/applications"
                    class="text-green-600 font-medium hover:underline">Applications Dashboard</a>.
                </p>
            </div>
        </div>
    @endif

    {{-- JOB DETAILS BOX --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8">
        {{-- Job Header --}}
        <section class="flex flex-col md:flex-row items-start md:items-center gap-6 border-b border-gray-200 pb-8">
            {{-- Employer Logo --}}
            <div class="shrink-0">
                <img src="{{ asset($job->employer->logo) }}" 
                    alt="{{ $job->employer->name }}" 
                    class="w-24 h-24 object-contain rounded-xl shadow-sm border border-gray-200 bg-white p-2">
            </div>

            {{-- Job Title & Employer --}}
            <div class="flex-1">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 flex flex-wrap items-center gap-3">
                    {{ $job->title }}

                    {{-- Urgent Hiring Badge --}}
                    @if($job->urgent_hiring)
                        <span class="px-4 py-1 text-sm font-semibold text-white bg-red-600 rounded-full shadow-md">
                            🔥 Urgent Hiring
                        </span>
                    @endif
                </h1>

                <p class="mt-3 text-lg font-medium text-blue-600 hover:underline">
                    <a href="/employers/{{ $job->employer->id }}">
                        {{ $job->employer->name }}
                    </a>
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Posted {{ $job->created_at->diffForHumans() }}
                </p>
            </div>
        </section>

        {{-- Job Details --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
            <div class="flex flex-col bg-gray-50 rounded-xl p-5 shadow-sm">
                <p class="text-sm font-semibold text-gray-500">📍 Location</p>
                <span class="text-gray-800 text-base mt-2">{{ $job->location }}</span>
            </div>
            <div class="flex flex-col bg-gray-50 rounded-xl p-5 shadow-sm">
                <p class="text-sm font-semibold text-gray-500">💰 Salary</p>
                <span class="text-gray-800 text-base mt-2">{{ $job->salary }}</span>
            </div>
            <div class="flex flex-col bg-gray-50 rounded-xl p-5 shadow-sm">
                <p class="text-sm font-semibold text-gray-500">🕒 Employment Type</p>
                <span class="text-gray-800 text-base mt-2">{{ $job->employment_type }}</span>
            </div>
        </section>

        {{-- Job Description --}}
        <section class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-5">Job Description</h2>
            <div class="prose prose-gray max-w-none text-gray-700 leading-relaxed">
                {!! $job->description !!}
            </div>
        </section>

        {{-- Actions --}}
        <section class="flex flex-row justify-end items-center gap-4 mt-12">
            <x-forms.button :element="'cancel'" href="/jobs/" :color="'secondary'">Back to Jobs</x-forms.button>

            @if ($hasApplied)
                <x-forms.button :element="'anchor'" href="/applications" :color="'success'">View Application</x-forms.button>
            @else
                <x-forms.button :element="'anchor'" href="/jobs/{{ $job->id }}/apply" :color="'primary'">Apply Now</x-forms.button>
            @endif
        </section>

    </div>

    {{-- Recent Jobs Carousel --}}
    <section 
        x-data="{
            interval: null,
            scrollContainer: null,
            cardWidth: 0,
            start() {
                this.interval = setInterval(() => {
                    if (!this.scrollContainer) return;

                    this.scrollContainer.scrollBy({ 
                        left: this.cardWidth, 
                        behavior: 'smooth' 
                    });

                    if (this.scrollContainer.scrollLeft + this.scrollContainer.clientWidth >= this.scrollContainer.scrollWidth - 10) {
                        this.scrollContainer.scrollTo({ left: 0, behavior: 'smooth' });
                    }
                }, 5000);
            }
        }"
        x-init="
            scrollContainer = $refs.carousel;
            cardWidth = $refs.carousel.querySelector('[data-card]').offsetWidth + 24;
            start()
        "
        class="mt-16"
    >
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Recent Jobs</h2>

        <div class="overflow-x-auto hide-scrollbar pb-8 transition-all duration-700" x-ref="carousel">
            <div class="flex gap-6 items-stretch">
                @foreach($recentJobs->take(20) as $recentJob)
                    <div class="min-w-[380px] flex" data-card>
                        <x-job-card :job="$recentJob" class="flex-1" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</div>
