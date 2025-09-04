<div 
    x-show="showEditWorkExperienceModal" 
    x-on:close-work-modal.window="showEditWorkExperienceModal = false"
    x-transition 
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 overflow-y-auto"
    style="display: none;"
>
    <div class="relative p-4 w-full max-w-4xl bg-white rounded-lg shadow dark:bg-gray-700 max-h-[90vh] overflow-y-auto"
         @click.away="showEditWorkExperienceModal = false">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Edit Work Experience
            </h3>
            <button type="button" @click="showEditWorkExperienceModal = false"
                class="text-gray-400 hover:text-gray-900 hover:bg-gray-200 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>

        {{-- Modal Form Body --}}
        <form wire:submit.prevent="update" class="p-4 md:p-5">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-7">
                    Share where you've worked before! Adding your past experiences gives others a better idea of your skills and journey.
                </p>
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="company_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employer | Company</label>
                        <input type="text" 
                                id="company_name" 
                                wire:model="company_name" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1">
                        <label for="job_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Job Title</label>
                        <input type="text" id="job_title" wire:model="job_title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        @error('job_title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-span-1">
                        <label for="location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                        <input type="text" id="location" wire:model="location" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        @error('location')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ----------------------------------------------------------------------------------------------------------- --}}
                    {{-- ----------------------------------------------------------------------------------------------------------- --}}
                    <div x-data="{ current: @entangle('is_current'), 
                                    endDate: @entangle('end_date'),
                                        watchCurrent() {
                                            this.$watch('current', (val) => {
                                                if (val) this.endDate = null;
                                            });
                                        } 
                                }" 
                        x-init="watchCurrent()"
                        class="col-span-2">

                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-1">
                                <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
                                <input type="date" id="start_date" wire:model="start_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Date</label>
                                <input type="date" 
                                        id="end_date" 
                                        wire:model="end_date" 
                                        x-model="endDate" 
                                        :disabled="current" 
                                        :class="current 
                                            ? 'bg-gray-500 text-gray-500 cursor-not-allowed' 
                                            : 'bg-gray-600 text-gray-900 cursor-text'
                                        "
                                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-1">
                                <input id="is_current_work" 
                                        wire:model="is_current" 
                                        type="checkbox" 
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="is_current_work" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    Currently working here?
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- ----------------------------------------------------------------------------------------------------------- --}}
                    {{-- ----------------------------------------------------------------------------------------------------------- --}}

                     <div class="col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea id="description" wire:model="description" rows="7" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write description here"></textarea>                    
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <x-forms.divider/>
            <p class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                Your personal information is confidential and used only in accordance with our <a href="#" class="underline">privacy policy</a>. 
                <br/>
                Having trouble updating your info? <a href="#" class="underline">Contact support</a> and we’ll help you out.
            </p>

            <div class="flex justify-end">
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Update
                </button>
            </div>
        </form>

    </div>
</div>

