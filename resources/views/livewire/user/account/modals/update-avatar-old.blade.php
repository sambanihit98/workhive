<div 
    x-show="showUpdateAvatarModal" 
    x-on:close-education-modal.window="showUpdateAvatarModal = false"
    x-transition 
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 overflow-y-auto"
    style="display: none;"
>
    <div class="relative p-4 w-full max-w-md bg-white rounded-lg shadow dark:bg-gray-700 max-h-[90vh] overflow-y-auto"
         @click.away="showUpdateAvatarModal = false">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Update Avatar
            </h3>
            <button type="button" @click="showUpdateAvatarModal = false"
                class="text-gray-400 hover:text-gray-900 hover:bg-gray-200 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>

        {{-- Modal Form Body --}}
        <form class="p-4 md:p-5" wire:submit.prevent="update" enctype="multipart/form-data">

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-7">
                    Every bit of learning counts. Share your education history to showcase your dedication and achievements over the years.
                </p>
                
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="flex justify-center col-span-2">
                        <img 
                            src="{{ $avatar ? $avatar->temporaryUrl() : asset($user->avatar) }}" 
                            alt="Avatar Preview" 
                            class="w-[250px] h-[250px] rounded-full object-cover"
                        />
                    </div>

                    <div class="col-span-2 mt-5">
                        <label for="avatar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload Avatar</label>
                        <input type="file" id="avatar" wire:model="avatar" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        @error('avatar')
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
