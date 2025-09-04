<div 
    x-data="{ 
        imagePreview: '', 
        defaultAvatar: '' 
    }"
    x-show="showUpdateAvatarModal"
    x-on:close-avatar-modal.window="showUpdateAvatarModal = false"
    x-on:reload-avatar.window="
        imagePreview = $event.detail.url;
        defaultAvatar = $event.detail.url;
    "
    x-transition
    @close-modal.window="imagePreview = defaultAvatar" 
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 overflow-y-auto"
    style="display: none;"
>

    <div class="relative p-4 w-full max-w-lg bg-white rounded-lg shadow dark:bg-gray-700 max-h-[90vh] overflow-y-auto"
         @click.away="showUpdateAvatarModal = false; imagePreview = defaultAvatar">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-200 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Update Avatar</h3>
            <button @click="showUpdateAvatarModal = false; imagePreview = defaultAvatar"
                class="text-gray-400 hover:text-gray-900 hover:bg-gray-200 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                </svg>
            </button>
        </div>

        {{-- Modal Form --}}
        <form class="p-4 md:p-5" wire:submit.prevent="update" enctype="multipart/form-data">

            <p class="text-sm text-gray-500 dark:text-gray-400 mb-7">
                Upload a clear, recent photo of yourself.
            </p>

            {{-- Preview --}}
            <div class="flex justify-center mb-4">
                <img :src="imagePreview" alt="Avatar Preview" class="w-[250px] h-[250px] rounded-full object-cover">
            </div>

            {{-- File Upload --}}
            <div class="mb-4">
                <label for="avatar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload Image</label>
                <input 
                    type="file" 
                    id="avatar" 
                    wire:model="avatar"
                    
                    @change="imagePreview = URL.createObjectURL($event.target.files[0])"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" 
                    required
                >
                @error('avatar')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <x-forms.divider />
            <p class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                Your personal information is confidential and used only in accordance with our <a href="#" class="underline">privacy policy</a>.
            </p>

            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700">
                    Update
                </button>
            </div>

        </form>
    </div>
</div>
