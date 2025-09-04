<div class="max-w-[1200px] mx-auto pt-32 pb-16 px-4 md:px-0 space-y-16">

    {{-- USER PROFILE --}}
    <div class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
        <div class="flex flex-col md:flex-row items-center gap-8">
            <img src="{{ asset($user->avatar) }}" alt="Avatar" class="w-48 h-48 rounded-full object-cover shadow-md border border-gray-200">
            <div class="flex-1 space-y-3 text-center md:text-left">
                <x-page-heading class="text-gray-800">{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</x-page-heading>
                <p class="text-gray-600">{{ $user->bio }}</p>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                    <div class="p-3 rounded-lg border border-gray-100">
                        <p class="text-gray-400 font-semibold">Birthdate</p>
                        <p class="text-gray-800">{{ \Carbon\Carbon::parse($user->birthdate)->format('M. d, Y') }}</p>
                    </div>
                    <div class="p-3 rounded-lg border border-gray-100">
                        <p class="text-gray-400 font-semibold">Gender</p>
                        <p class="text-gray-800">Male</p>
                    </div>
                    <div class="p-3 rounded-lg border border-gray-100">
                        <p class="text-gray-400 font-semibold">Email</p>
                        <p class="text-gray-800">{{ $user->email }}</p>
                    </div>
                    <div class="p-3 rounded-lg border border-gray-100">
                        <p class="text-gray-400 font-semibold">Phone</p>
                        <p class="text-gray-800">{{ $user->phone_number }}</p>
                    </div>
                    <div class="md:col-span-2 p-3 rounded-lg border border-gray-100">
                        <p class="text-gray-400 font-semibold">Address</p>
                        <p class="text-gray-800">
                            {{ $address->street }}, {{ $address->barangay }}, {{ $address->city }}, {{ $address->province }}, {{ $address->zip_code }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex flex-wrap justify-center md:justify-end gap-4 mt-6">
            <div x-data="{ showEditInfoModal: false }">
                <x-forms.button class="bg-blue-500 hover:bg-blue-600 text-white" @click="showEditInfoModal = true">
                    <x-bi-pencil class="w-4 h-4 mr-1"/> Edit Info
                </x-forms.button>
                @livewire('user.account.modals.edit-account-info', ['user' => $user, 'address' => $address])
            </div>

            <div x-data="{ showUpdateAvatarModal: false }">
                <x-forms.button 
                    class="bg-blue-500 hover:bg-blue-600 text-white" 
                    @click="showUpdateAvatarModal = true; $dispatch('reload-avatar', { url: '{{ asset('storage/' . $user->avatar) }}' })"
                >
                    <x-bi-upload class="w-4 h-4 mr-1"/> Update Avatar
                </x-forms.button>
                @livewire('user.account.modals.update-avatar', ['user' => $user])
            </div>

            <div x-data="{ showChangePasswordModal: false }">
                <x-forms.button class="bg-blue-500 hover:bg-blue-600 text-white" @click="showChangePasswordModal = true">
                    <x-bi-key class="w-4 h-4 mr-1"/> Change Password
                </x-forms.button>
                @livewire('user.account.modals.change-password')
            </div>
        </div>
    </div>

    {{-- WORK EXPERIENCE --}}
    <div class="rounded-2xl shadow-lg p-8 space-y-6" x-data="{ showEditIcons: false }">
        <x-page-heading class="text-gray-800">Work Experiences</x-page-heading>
        <p class="text-gray-500 text-sm">Overview of your professional experience.</p>

        @if ($work_experiences->isEmpty())
            <div class="flex items-center gap-3 text-gray-400 font-semibold mt-4">
                <x-bi-slash-circle class="w-5 h-5"/> No work experiences added yet.
            </div>
        @else
            <div class="space-y-6 mt-6 border-l-2 border-gray-200 pl-6">
                @foreach ($work_experiences as $work_experience)
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <p class="text-lg font-bold text-gray-800">{{ $work_experience->job_title }}</p>
                                @if(empty($work_experience->end_date))
                                    <span class="bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded-full">Current</span>
                                @endif
                            </div>

                            <div x-data="{ showEditWorkExperienceModal: false, showDeleteWorkExperienceModal: false }"
                                 x-show="showEditIcons"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform translate-y-1"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform translate-y-1"
                                 class="flex gap-3">
                                <x-bi-pencil class="w-5 h-5 text-blue-500 cursor-pointer animate-scale-pulse" @click="showEditWorkExperienceModal = true"/>
                                <x-bi-x-lg class="w-5 h-5 text-red-500 cursor-pointer animate-scale-pulse" @click="showDeleteWorkExperienceModal = true"/>
                                
                                <div x-show="showEditWorkExperienceModal">
                                    @livewire('user.account.modals.edit-work-experience', ['work_experience_id' => $work_experience->id], key('edit-work-'.$work_experience->id))
                                </div>
                                <div x-show="showDeleteWorkExperienceModal">
                                    @livewire('user.account.modals.delete-work-experience', ['work_experience_id' => $work_experience->id], key('delete-work-'.$work_experience->id))
                                </div>
                            </div>
                        </div>

                        <p class="text-gray-600 font-medium">{{ $work_experience->company_name }}</p>
                        <p class="text-gray-500 text-sm">
                            {{ \Carbon\Carbon::parse($work_experience->start_date)->format('M. Y') }} - 
                            {{ $work_experience->end_date ? \Carbon\Carbon::parse($work_experience->end_date)->format('M. Y') : 'Present' }}
                        </p>
                        <p class="text-gray-500 text-sm">{{ $work_experience->location }}</p>
                        <p class="text-gray-700 text-sm mt-2">{{ $work_experience->description }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ADD NEW + EDIT BUTTONS --}}
        <div class="flex justify-end mt-4 gap-2 items-center">
            @if ($work_experiences->isNotEmpty())
                <x-forms.button class="bg-blue-500 text-white hover:bg-blue-600" @click="showEditIcons = !showEditIcons" size="sm">
                    <span x-text="showEditIcons ? 'Cancel' : 'Edit'"></span>
                </x-forms.button>
            @endif

            <div x-data="{ showAddWorkExperienceModal: false }">
                <x-forms.button class="bg-blue-500 text-white hover:bg-blue-600" @click="showAddWorkExperienceModal = true" size="sm">
                    <x-bi-plus class="w-4 h-4 mr-1"/> Add New
                </x-forms.button>
                <div x-show="showAddWorkExperienceModal">
                    @livewire('user.account.modals.add-work-experience')
                </div>
            </div>
        </div>
    </div>

    {{-- EDUCATION --}}
    <div class="rounded-2xl shadow-lg p-8 space-y-6" x-data="{ showEditIcons: false }">
        <x-page-heading class="text-gray-800">Education</x-page-heading>
        <p class="text-gray-500 text-sm">Academic background and qualifications.</p>

        @if ($educations->isEmpty())
            <div class="flex items-center gap-3 text-gray-400 font-semibold mt-4">
                <x-bi-slash-circle class="w-5 h-5"/> No education added yet.
            </div>
        @else
            <div class="space-y-6 mt-6 border-l-2 border-gray-200 pl-6">
                @foreach ($educations as $education)
                    <div class="relative mb-6">
                        @if($education->is_current)
                            <span class="absolute -left-3 top-1 bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded-full">Current</span>
                        @endif
                        <div class="flex justify-between items-center">
                            <p class="text-lg font-bold text-gray-800">{{ $education->school_name }}</p>
                            <div x-data="{ showEditEducationModal: false, showDeleteEducationModal: false }"
                                 x-show="showEditIcons"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform translate-y-1"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform translate-y-1"
                                 class="flex gap-3">
                                <x-bi-pencil class="w-5 h-5 text-blue-500 cursor-pointer animate-scale-pulse" @click="showEditEducationModal = true"/>
                                <x-bi-x-lg class="w-5 h-5 text-red-500 cursor-pointer animate-scale-pulse" @click="showDeleteEducationModal = true"/>
                                <div x-show="showEditEducationModal">
                                    @livewire('user.account.modals.edit-education', ['education_id' => $education->id], key('edit-education-'.$education->id))
                                </div>
                                <div x-show="showDeleteEducationModal">
                                    @livewire('user.account.modals.delete-education', ['education_id' => $education->id], key('delete-education-'.$education->id))
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 font-medium">{{ $education->degree }}</p>
                        <p class="text-gray-500 text-sm">
                            {{ $education->start_year }} - {{ $education->is_current ? 'Present' : $education->end_year }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ADD NEW + EDIT BUTTONS --}}
        <div class="flex justify-end mt-4 gap-2 items-center">
            @if ($educations->isNotEmpty())
                <x-forms.button class="bg-blue-500 text-white hover:bg-blue-600" @click="showEditIcons = !showEditIcons" size="sm">
                    <span x-text="showEditIcons ? 'Cancel' : 'Edit'"></span>
                </x-forms.button>
            @endif

            <div x-data="{ showAddEducationModal: false }">
                <x-forms.button class="bg-blue-500 text-white hover:bg-blue-600" @click="showAddEducationModal = true" size="sm">
                    <x-bi-plus class="w-4 h-4 mr-1"/> Add New
                </x-forms.button>
                @livewire('user.account.modals.add-education')
            </div>
        </div>
    </div>

</div>
