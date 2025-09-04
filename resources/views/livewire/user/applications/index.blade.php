<div class="max-w-[1200px] mx-auto pt-32 pb-16 px-4 md:px-0 space-y-10">

    <h1 class="text-3xl font-bold text-gray-900">My Applications</h1>
    <p class="text-gray-600">Here you can review all the jobs you’ve applied for, along with their status and details.</p>

    <div class="grid gap-6">
        @forelse ($applications as $application)
            <div x-data="{ showWithdrawModal: false }" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <!-- Job Title & Company -->
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">
                            {{ $application->job->title }}
                        </h2>
                        <p class="text-gray-600">
                            {{ $application->job->employer->name ?? 'Unknown Company' }}
                        </p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($application->status === 'Pending') bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 
                        @elseif($application->status === 'Hired') bg-gradient-to-r from-green-100 to-green-200 text-green-800
                        @elseif($application->status === 'Reviewed') bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800
                        @elseif($application->status === 'Accepted') bg-gradient-to-r from-green-100 to-green-200 text-green-800
                        @elseif($application->status === 'Rejected') bg-gradient-to-r from-red-100 to-red-200 text-red-800
                        @elseif($application->status === 'Withdrawn') bg-gradient-to-r from-gray-200 to-gray-300 text-gray-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($application->status) }}
                    </span>
                </div>

                <!-- Job Info -->
                <div class="mt-4 grid md:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div>
                        <p><span class="font-medium text-gray-900">Location:</span> {{ $application->job->location ?? 'Not specified' }}</p>
                        <p><span class="font-medium text-gray-900">Employment Type:</span> {{ $application->job->employment_type ?? 'N/A' }}</p>
                        <p><span class="font-medium text-gray-900">Salary:</span> {{ $application->job->salary ?? 'Negotiable' }}</p>
                    </div>
                    <div>
                        <p><span class="font-medium text-gray-900">Applied On:</span> {{ $application->created_at->format('M d, Y') }}</p>
                        <p><span class="font-medium text-gray-900">Last Updated:</span> {{ $application->updated_at->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Applicant Cover Letter -->
                <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-gray-900 flex items-center">
                        ✉️ Cover Letter
                    </h3>
                    @if($application->cover_letter)
                        <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                            {{ $application->cover_letter }}
                        </p>
                    @else
                        <p class="text-gray-400 italic mt-2">No cover letter provided.</p>
                    @endif
                </div>

                <!-- Resume -->
                <div class="mt-4 bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-indigo-900 flex items-center">
                        📄 Resume
                    </h3>
                    @if($application->resume)
                        <a href="{{ asset('storage/' . $application->resume) }}" 
                           target="_blank" 
                           class="inline-flex items-center mt-2 px-3 py-1.5 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                            View Resume
                        </a>
                    @else
                        <p class="text-gray-400 italic mt-2">No resume uploaded.</p>
                    @endif
                </div>

                <!-- Actions -->
                <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('jobs.show', $application->job_id) }}" 
                    class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                        View Job Details →
                    </a>

                    @if ($application->status != 'Withdrawn' && $application->status != 'Hired')
                        <button 
                            class="px-4 py-2 text-sm font-medium rounded-lg bg-red-100 text-red-600 hover:bg-red-200" 
                            @click="showWithdrawModal = true">
                            Withdraw Application
                        </button>
                    @endif
                    
                </div>
                <!-- Modal (still inside the same card, but overlay is fixed so layout unaffected) -->
                <div x-show="showWithdrawModal" x-cloak
                    x-transition
                    x-on:keydown.escape.window="showWithdrawModal = false"
                >
                    @livewire('user.applications.modals.withdraw', ['application_id' => $application->id], key('withdraw-'.$application->id))
                </div>

            </div>
        @empty
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-8 text-center">
                <h3 class="text-lg font-medium text-gray-900">No Applications Found</h3>
                <p class="text-gray-600 mt-2">You haven’t applied for any jobs yet. Start browsing and apply today!</p>
                <a href="/jobs" class="inline-block mt-4 px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Browse Jobs
                </a>
            </div>
        @endforelse
    </div>

</div>
