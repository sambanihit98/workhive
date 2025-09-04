<div class="bg-gray-50 py-12 pt-30">
    <div class="px-4 md:px-0 max-w-[1200px] mx-auto">
        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 mb-2 flex items-center gap-2">
            <span>Reviews for</span> 
            <a href="/employers/{{ $employer->id }}"> <span class="text-blue-600 hover:underline">{{ $employer->name }} </span></a>
        </h2>
        <p class="text-gray-600 text-base md:text-sm mb-10 flex items-center gap-2">
            Hear what people are saying about working with <span class="font-semibold text-gray-800">{{$employer->name}}</span>.
        </p>

        <!-- Overall Rating + My Review -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            
            <!-- Overall Rating (1 col) -->
            <div class="col-span-1 flex">
                <div class="p-6 h-full flex flex-1 flex-col justify-center bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-2xl shadow-md">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">🌟 Overall Rating</h3>
                    
                    @if($totalReviews > 0)
                        <div class="flex flex-col items-center">
                            <div class="flex items-center text-yellow-400 text-2xl mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= round($overallRating) ? 'text-yellow-400' : 'text-gray-300' }}">
                                        ★
                                    </span>
                                @endfor
                            </div>
                            <p class="mt-1 text-3xl font-bold text-gray-900">
                                {{ number_format($overallRating, 1) }}
                                <span class="text-lg text-gray-600">/ 5</span>
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                Based on <span class="font-semibold">{{ $totalReviews }}</span>
                                review{{ $totalReviews > 1 ? 's' : '' }}
                            </p>
                        </div>
                    @else
                        <div class="text-center text-gray-500">
                            <p>No ratings yet. Be the first to review!</p>
                        </div>
                    @endif

                </div>
            </div>

            <!-- My Review Section (3 cols) -->
            <div class="col-span-3 flex" x-data="{ showAddReviewModal: false }" >
                @auth
                    @php
                        $myReview = $reviews->firstWhere('user_id', auth()->id());
                    @endphp

                    @if($myReview)
                        <div class="flex-1 p-6 bg-blue-50 border border-blue-200 rounded-2xl shadow-sm h-full">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold text-blue-700 flex items-center gap-2">
                                    <span>✨ Your Review</span>
                                </h3>
                               <!-- Edit & Delete Actions (Icons Only) -->
                                <div class="flex gap-2" x-data="{ showEditReviewModal: false, showDeleteReviewModal: false }">
                                    {{-- --------------------------------- --}}
                                    <!-- Edit Icon -->
                                    <button 
                                        @click="showEditReviewModal = true"
                                        class="p-2 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition"
                                        title="Edit Review"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M16.5 3.75a2.121 2.121 0 113 3L7 19.25H4v-3L16.5 3.75z" />
                                        </svg>
                                    </button>
                                    <div x-show="showEditReviewModal">
                                        @livewire('employers.modals.edit-review', ['review_id' => $myReview->id], key('edit-review-'.$myReview->id))
                                    </div>
                                    {{-- --------------------------------- --}}
                                    <!-- Delete Icon -->
                                    <button 
                                        @click="showDeleteReviewModal = true"
                                        class="p-2 bg-red-500 text-white rounded hover:bg-red-600 transition"
                                        title="Delete Review"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                        </svg>
                                    </button>
                                    <div x-show="showDeleteReviewModal">
                                        @livewire('employers.modals.delete-review', ['review_id' => $myReview->id], key('delete-review-'.$myReview->id))
                                    </div>
                                    {{-- --------------------------------- --}}
                                    {{-- --------------------------------- --}}
                                </div>

                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img 
                                        src="{{ asset(auth()->user()->avatar) }}" 
                                        alt="{{ auth()->user()->full_name }}" 
                                        class="w-12 h-12 rounded-full object-cover border border-gray-200"
                                    >
                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            {{ auth()->user()->full_name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            Posted on {{ $myReview->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center text-yellow-400 text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span>{{ $i <= $myReview->rating ? '★' : '☆' }}</span>
                                    @endfor
                                    <span class="ml-2 text-gray-600 text-xs">({{ $myReview->rating }}/5)</span>
                                </div>
                            </div>

                            <p class="mt-4 text-gray-700 leading-relaxed">
                                {{ !empty($myReview->comment) ? $myReview->comment : 'No comment provided.' }}
                            </p>
                        </div>
                    @else

                    <div class="flex-1">
                        <div class="p-6 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-2xl shadow-sm h-full">
                            <h3 class="text-lg font-bold text-blue-700 mb-2 text-center">✨ Share Your Experience</h3>
                            <p class="text-gray-600 mb-4 text-center">You haven’t left a review yet. Let others know what it’s like working with <strong>{{ $employer->name }}</strong>!</p>
                            <div class="flex justify-center">
                                <button
                                class="inline-block px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition"
                                @click="showAddReviewModal = true">
                                    + Add Your Review
                                </button>
                            </div>
                            <div x-show="showAddReviewModal">
                                @livewire('employers.modals.add-review', ['employer_id' => $employer->id])
                            </div>
                        </div>
                    </div>

                    @endif
                @else
                    <div class="flex-1 p-6 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-2xl shadow-sm h-full text-center">
                        <h3 class="text-lg font-bold text-gray-700 mb-2">✨ Want to leave a review?</h3>
                        <p class="text-gray-600 mb-4">Please <a href="{{ route('login') }}" class="text-blue-600 underline">log in</a> to share your experience with <strong>{{ $employer->name }}</strong>.</p>
                    </div>
                @endauth
            </div>
        </div>
        <!-- End Overall + My Review -->

        <!-- Separator -->
        <div class="border-t border-gray-200 my-10"></div>

        @if($reviews->count() > 0)
            <div class="grid gap-6 md:grid-cols-2">
                @foreach($reviews as $review)
                    @if(!auth()->check() || $review->user_id !== auth()->id())
                        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition duration-200 relative overflow-hidden">
                            <!-- Accent border (left side) -->
                            <div class="absolute left-0 top-0 h-full w-1 bg-gradient-to-b from-blue-500 to-blue-300 rounded-l-2xl"></div>

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
                                        <p class="font-semibold text-gray-800">
                                            {{ $review->user->full_name ?? 'Anonymous User' }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            Posted on {{ $review->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center text-yellow-400 text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span>
                                            {{ $i <= $review->rating ? '★' : '☆' }}
                                        </span>
                                    @endfor
                                    <span class="ml-2 text-gray-600 text-xs">({{ $review->rating }}/5)</span>
                                </div>
                            </div>

                            <!-- Comment -->
                            <p class="mt-4 text-gray-700 leading-relaxed">
                                {{ $review->comment ?? 'No comment provided.' }}
                            </p>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="mt-8">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-2xl shadow-sm">
                <p class="text-gray-500 text-lg">No reviews yet for this employer.</p>
                <p class="text-sm text-gray-400 mt-1">Be the first to leave a review!</p>
            </div>
        @endif
    </div>
</div>
