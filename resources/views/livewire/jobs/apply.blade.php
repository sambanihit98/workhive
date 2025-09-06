<div class="px-4 md:px-0 pt-30 space-y-10 max-w-[1200px] mx-auto">
    <div>
        <!-- Job Information -->
        <section class="bg-white shadow-md rounded-2xl p-6 mb-8 flex items-center gap-6">
            @if($job->employer->logo)
                {{-- Employer Logo --}}
                <div class="shrink-0">
                    <img src="{{ asset('storage/' . $job->employer->logo) }}" 
                        alt="{{ $job->employer->name }}" 
                        class="w-24 h-24 object-contain rounded-xl shadow-sm border border-gray-200 bg-white p-2">
                </div>
            @else
                <div class="w-20 h-20 flex items-center justify-center bg-gray-100 rounded-lg border border-gray-200 text-gray-500">
                    🏢
                </div>
            @endif

            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $job->title }}</h1>
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

        <!-- Applicant Information -->
        <section class="bg-white shadow-md rounded-2xl p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Your Information</h2>
            <div class="space-y-3 text-gray-700">
                <div>
                    <p class="font-semibold">Full Name</p>
                    <p class="text-gray-600">{{ auth()->user()->first_name }} {{ auth()->user()->middle_name }} {{ auth()->user()->last_name }}</p>
                </div>
                <div>
                    <p class="font-semibold">Email</p>
                    <p class="text-gray-600">{{ auth()->user()->email }}</p>
                </div>
                <div>
                    <p class="font-semibold">Phone Number</p>
                    <p class="text-gray-600">{{ auth()->user()->phone_number }}</p>
                </div>
            </div>
        </section>

        <!-- Application Form -->
        <section class="bg-white shadow-md rounded-2xl p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Application Details</h2>

            <form wire:submit.prevent="apply" class="space-y-4" enctype="multipart/form-data">

                {{-- <div class="grid gap-6">
                    <x-forms.input label="Upload Resume" name="resume" type="file"/>
                    <x-forms.textarea label="Cover Letter (Optional)" name="cover_letter" :required="false"></x-forms.textarea>
                </div> --}}

                <div class="grid gap-6">
                    <x-forms.input 
                        label="Upload Resume" 
                        name="resume" 
                        type="file" 
                        wire:model="resume" 
                    />
                    <x-forms.textarea 
                        label="Cover Letter (Optional)" 
                        name="cover_letter" 
                        :required="false"
                        wire:model="cover_letter"
                    />
                </div>


                <div class="flex justify-end items-center gap-3 mt-8">
                    <x-forms.button :element="'cancel'" href="/jobs/{{ $job->id }}">Back</x-forms.button>
                    <x-forms.button :element="'anchor'" href="/user-account" :color="'primary'">Edit Profile</x-forms.button>
                    <x-forms.button :element="'button'" href="#" :color="'success'">Submit Application</x-forms.button>
                </div>
            </form>
        </section>

    </div>
</div>
