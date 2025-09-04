<div 
    x-show="showAddReviewModal" 
    x-on:close-add-review-modal.window="showAddReviewModal = false"
    x-transition 
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 overflow-y-auto"
    style="display: none;"
>
    <div class="relative p-4 w-full max-w-4xl bg-white rounded-lg shadow dark:bg-gray-700 max-h-[90vh] overflow-y-auto"
         @click.away="showAddReviewModal = false">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Add Review
            </h3>
            <button type="button" @click="showAddReviewModal = false"
                class="text-gray-400 hover:text-gray-900 hover:bg-gray-200 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>

        {{-- Modal Form Body --}}
        <form wire:submit.prevent="add" class="p-4 md:p-5">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-7">
                    Share your experience working with this employer! Your review helps others understand the work environment, company culture, and what it’s like to collaborate with them.
                </p>
                <div class="grid gap-4 mb-4 grid-cols-2">

                    {{-- ----------------------------------------------------------------------------------------------------------- --}}
                    {{-- ----------------------------------------------------------------------------------------------------------- --}}
                    <input type="hidden" wire:model="employer_id">

                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rating</label>
                        <div class="flex items-center gap-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <button 
                                    type="button"
                                    wire:click="$set('rating', {{ $rating === $i ? 0 : $i }})"
                                    class="text-3xl transition-transform duration-150 ease-out transform hover:scale-125"
                                >
                                    <span 
                                        @class([
                                            'text-yellow-400' => $rating >= $i,
                                            'text-gray-300' => $rating < $i,
                                            'transition-colors duration-150' => true
                                        ])
                                    >
                                        ★
                                    </span>
                                </button>
                            @endfor

                            <span class="ml-2 text-gray-600 font-semibold">{{ $rating }}/5</span>
                        </div>

                        @error('rating')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                     <div class="col-span-2">
                        <label for="comment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comment</label>
                        <textarea id="comment" wire:model="comment" rows="7" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write comment here"></textarea>                    
                        @error('comment')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- ----------------------------------------------------------------------------------------------------------- --}}
                    {{-- ----------------------------------------------------------------------------------------------------------- --}}

                </div>
            </div>

            <x-forms.divider/>
            <p class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                Your review will be visible with your name and shared to help others understand your experience with this company. 
                <br/>
                Need help submitting your review? <a href="#" class="underline">Contact support</a> and we’ll assist you.
            </p>
            <div class="flex justify-end">
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Add Review
                </button>
            </div>
        </form>

    </div>
</div>

