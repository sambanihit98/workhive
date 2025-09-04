<div 
    x-show="showAddEducationModal" 
    x-on:close-education-modal.window="showAddEducationModal = false"
    x-transition 
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 overflow-y-auto"
    style="display: none;"
>
    <div class="relative p-4 w-full max-w-4xl bg-white rounded-lg shadow dark:bg-gray-700 max-h-[90vh] overflow-y-auto"
         @click.away="showAddEducationModal = false">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Add Education
            </h3>
            <button type="button" @click="showAddEducationModal = false"
                class="text-gray-400 hover:text-gray-900 hover:bg-gray-200 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>

        {{-- Modal Form Body --}}
        <form class="p-4 md:p-5" wire:submit.prevent="save">

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-7">
                    Every bit of learning counts. Share your education history to showcase your dedication and achievements over the years.
                </p>
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-1">
                        <label for="school_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">School Name</label>
                        <input type="text" id="school_name" wire:model="school_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        @error('school_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1">
                        <label for="degree" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Degree</label>
                        <input type="text" id="degree" wire:model="degree" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        @error('degree')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-span-1">
                        <label for="field_of_study" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Field of Study (Major)</label>
                        <input type="text" id="field_of_study" wire:model="field_of_study" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        @error('field_of_study')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1">
                        <label for="academic_level" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Academic Level</label>
                        <input type="text" id="academic_level" wire:model="academic_level" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"> 
                        @error('academic_level')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- ----------------------------------------------------------------------------------------------------- --}}
                    {{-- ----------------------------------------------------------------------------------------------------- --}}
                    <div x-data="{ current: @entangle('is_current'), 
                                    endYear: @entangle('end_year'),
                                        watchCurrent() {
                                            this.$watch('current', (val) => {
                                                if (val) this.endYear = null;
                                            });
                                        } 
                                }" 
                        x-init="watchCurrent()"
                        class="col-span-2">
                        <div class="grid gap-4 mb-4 grid-cols-2">

                            <div class="col-span-1">
                                <label for="start_year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Year</label>
                                <input type="number" id="start_year" wire:model="start_year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('start_year')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-1">
                                <label for="end_year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Year</label>
                                <input type="number" 
                                        id="end_year" 
                                        wire:model="end_year" 
                                        x-model="endYear" 
                                        :disabled="current" 
                                        :class="current 
                                            ? 'bg-gray-500 text-gray-500 cursor-not-allowed' 
                                            : 'bg-gray-600 text-gray-900 cursor-text'
                                        "
                                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('end_year')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="col-span-1">
                                <input id="is_current_education" wire:model="is_current" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="is_current_education" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Currently studying here?</label>
                            </div>

                        </div>
                    </div>
                    {{-- ----------------------------------------------------------------------------------------------------- --}}
                    {{-- ----------------------------------------------------------------------------------------------------- --}}

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
                    Add
                </button>
            </div>
        </form>

    </div>
</div>
