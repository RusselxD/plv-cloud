<div class="bg-gray-50 flex-1 flex flex-col items-center -my-3 lg:-mr-3 lg:pb-5">
    <div class=" p-3 sm:p-5 md:p-7 w-full">
        <div class="flex flex-col lg:flex-row items-center lg:items-start">
            <div class="mb-3 lg:mb-0 lg:mr-5">
                <img src="{{ $user->profile_picture ? $user->profile_picture : asset('assets/profile_picture/default.jpg') }}"
                    alt="{{ $user->username }}'s profile picture" class="rounded-full w-16 h-16 sm:w-20 sm:h-20 object-cover" />
            </div>
            <div class="text-center lg:text-left">
                <p class="font-medium text-base sm:text-lg">{{ $user->first_name }} {{ $user->last_name }}</p>
                <p class="mb-2 text-sm sm:text-base">&#64;{{ $user->username }}</p>
                <p class="px-3 sm:px-4 py-1 rounded-full bg-gray-100 w-fit text-xs sm:text-sm mx-auto lg:mx-0">{{ $user->course->abbreviation }}</p>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row items-center justify-between mt-4 sm:mt-6 gap-3 sm:gap-4 md:gap-6 lg:space-x-10 lg:gap-0">
            <div
                class="bg-white flex flex-1 w-full sm:w-auto items-center justify-start border-l-4 border-red-600 border-2 rounded-md p-2 sm:p-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-folder-open-icon lucide-folder-open w-8 h-8 sm:w-10 sm:h-10 p-1.5 sm:p-2 bg-red-100 rounded-md mr-3 sm:mr-4">
                    <path
                        d="m6 14 1.5-2.9A2 2 0 0 1 9.24 10H20a2 2 0 0 1 1.94 2.5l-1.54 6a2 2 0 0 1-1.95 1.5H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H18a2 2 0 0 1 2 2v2" />
                </svg>
                <div>
                    <p class="font-bold text-base sm:text-lg">{{ $user->folders_count }}</p>
                    <p class="text-gray-700 text-xs sm:text-sm">Folders</p>
                </div>
            </div>
            <div
                class="bg-white flex flex-1 w-full sm:w-auto items-center justify-start border-l-4 border-green-600 border-2 rounded-md p-2 sm:p-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#007a14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-file-text-icon lucide-file-text w-8 h-8 sm:w-10 sm:h-10 p-1.5 sm:p-2 bg-green-100 rounded-md mr-3 sm:mr-4">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                    <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                    <path d="M10 9H8" />
                    <path d="M16 13H8" />
                    <path d="M16 17H8" />
                </svg>
                <div>
                    <p class="font-bold text-base sm:text-lg">{{ $user->files_count }}</p>
                    <p class="text-gray-700 text-xs sm:text-sm">Files</p>
                </div>
            </div>
            <div
                class="bg-white flex flex-1 w-full sm:w-auto items-center justify-start border-l-4 border-blue-600 border-2 rounded-md p-2 sm:p-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#3c00c7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-upload-icon lucide-upload w-8 h-8 sm:w-10 sm:h-10 p-1.5 sm:p-2 bg-blue-100 rounded-md mr-3 sm:mr-4">
                    <path d="M12 3v12" />
                    <path d="m17 8-5-5-5 5" />
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                </svg>
                <div>
                    <p class="font-bold text-base sm:text-lg">{{ $user->files_count + $user->folders_count }}</p>
                    <p class="text-gray-700 text-xs sm:text-sm">Total Uploads</p>
                </div>
            </div>
        </div>
    </div>

    @if (auth()->id() == $user->id)

        <div class="shadow-[0_0px_10px_rgba(0,0,0,0.15)] w-[95%] p-3 sm:p-4 md:p-5 rounded-lg relative mb-5 overflow-hidden">

            <div class="absolute inset-0 bg-black/20" wire:loading wire:target="saveChanges">
                <x-ui.general.spinner />
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-b-2 border-gray-300 pb-3 sm:pb-4 mb-3 sm:mb-4 gap-3 sm:gap-0">
                <div>
                    @if ($isEditing)
                        <p class="font-semibold text-lg sm:text-xl">Edit Profile</p>
                        <span class="flex items-center justify-start text-slate-500 text-xs mt-1">
                            <span>Update your account information</span>
                        </span>
                    @else
                        <p class="font-semibold text-lg sm:text-xl">Account Details</p>
                        <span class="flex items-center justify-start text-slate-500 text-xs mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-lock-icon lucide-lock w-5 h-5 mr-1">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            <span class="">Only visible to you</span>
                        </span>
                    @endif

                </div>
                @if ($isEditing)
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button wire:click="closeEditing"
                            class="flex items-center justify-center border-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-md space-x-1 sm:space-x-2 text-xs sm:text-sm text-primary border-primary hover:bg-primary hover:text-white transition-colors duration-150 ease-in-out cursor-pointer flex-1 sm:flex-none">
                            <span>Cancel</span>
                        </button>
                        <button wire:click="saveChanges"
                            class="flex items-center justify-center border-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-md space-x-1 sm:space-x-2 text-xs sm:text-sm border-primary bg-primary text-white hover:bg-primary/90 transition-colors duration-150 ease-in-out cursor-pointer flex-1 sm:flex-none">
                            Save Changes
                        </button>
                    </div>

                @else
                    <button wire:click="openEditing"
                        class="flex items-center justify-center border-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-md space-x-1 sm:space-x-2 text-xs sm:text-sm text-primary border-primary hover:bg-primary hover:text-white transition-colors duration-150 ease-in-out cursor-pointer w-full sm:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-pencil-icon lucide-pencil w-4 h-4 sm:w-5 sm:h-5">
                            <path
                                d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                            <path d="m15 5 4 4" />
                        </svg>
                        <span>Edit Details</span>
                    </button>
                @endif

            </div>

            @if ($isEditing)
                <div class="bg-gray-100 p-2 sm:p-3 rounded-xl flex flex-col sm:flex-row items-center gap-3 sm:gap-0">
                    <!-- Profile Picture -->
                    <div class="rounded-full w-16 h-16 sm:w-20 sm:h-20 relative">
                        @if ($newProfilePicture && is_object($newProfilePicture))
                            {{-- Show preview of newly uploaded image --}}
                            <img src="{{ $newProfilePicture->temporaryUrl() }}" alt="Profile Picture"
                                class="rounded-full w-full h-full object-cover" />
                        @elseif ($newProfilePicture && is_string($newProfilePicture))
                            {{-- Show existing profile picture from database --}}
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture"
                                class="rounded-full w-full h-full object-cover" />
                        @else
                            {{-- Show default image --}}
                            <img src="{{ asset('assets/profile_picture/default.jpg') }}" alt="Profile Picture"
                                class="rounded-full w-full h-full object-cover" />
                        @endif

                        <!-- Loading Spinner Overlay -->
                        <div class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center" wire:loading wire:target="newProfilePicture">
                            <x-ui.general.spinner />
                        </div>

                        <label
                            class="absolute bottom-0 right-0 cursor-pointer rounded-full p-1.5 sm:p-2 bg-blue-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-camera-icon lucide-camera text-white w-4 h-4 sm:w-5 sm:h-5">
                                <path
                                    d="M13.997 4a2 2 0 0 1 1.76 1.05l.486.9A2 2 0 0 0 18.003 7H20a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1.997a2 2 0 0 0 1.759-1.048l.489-.904A2 2 0 0 1 10.004 4z" />
                                <circle cx="12" cy="13" r="3" />
                            </svg>
                            <input type="file" accept="image/*" class="hidden" wire:model="newProfilePicture" />
                        </label>
                    </div>
                    <div class="sm:ml-4 text-center sm:text-left">
                        <p class="font-medium text-sm sm:text-base">Profile Picture</p>
                        <p class="text-xs text-gray-500">Click the camera icon to upload a new photo.</p>
                        @error('newProfilePicture')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        @if ($user->profile_picture !== null && !$removeProfilePicture)
                            <p class="text-sm font-medium text-red-500 mt-2 cursor-pointer hover:text-red-700 transition-colors duration-150" wire:click="removePhoto">Remove Photo</p>
                        @elseif ($removeProfilePicture)
                            <p class="text-sm font-medium text-gray-500 mt-2">Photo will be removed when you save</p>
                        @endif
                    </div>
                </div>

                <div class="mt-3 sm:mt-4">
                    <div class="w-full ">
                        <p class="text-gray-700 text-xs sm:text-sm ">Email</p>
                        <p class="font-semibold text-sm sm:text-base break-all">{{ $user->email }}</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 border-b-2 border-gray-300 pb-3 sm:pb-4 mt-3">
                        <div class="">
                            <p class="text-gray-700 text-xs sm:text-sm ">First Name</p>
                            <input type="text" value="{{ $user->first_name }}" wire:model="newFirstName"
                                oninput="this.value = this.value.replace(/[^a-zA-Z\s'-]/g, '')"
                                class="border rounded-lg px-3 w-full sm:w-[70%] md:w-[50%] py-2 text-sm sm:text-base @error('newFirstName') border-red-500 @enderror" />
                            @error('newFirstName')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="">
                            <p class="text-gray-700 text-xs sm:text-sm ">Last Name</p>
                            <input type="text" wire:model="newLastName"
                                oninput="this.value = this.value.replace(/[^a-zA-Z\s'-]/g, '')"
                                class="border rounded-lg px-3 w-full sm:w-[70%] md:w-[50%] py-2 text-sm sm:text-base @error('newLastName') border-red-500 @enderror" />
                            @error('newLastName')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="">
                            <p class="text-gray-700 text-xs sm:text-sm ">Username</p>
                            <input type="text" wire:model="newUsername"
                                oninput="this.value = this.value.replace(/[^a-zA-Z0-9._-]/g, '')"
                                class="border rounded-lg px-3 w-full sm:w-[70%] md:w-[50%] py-2 text-sm sm:text-base @error('newUsername') border-red-500 @enderror" />
                            @error('newUsername')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="">
                            <p class="text-gray-700 text-xs sm:text-sm ">Course</p>
                            <select wire:model="newCourseId"
                                class="w-full sm:w-[70%] md:w-[50%] px-3 py-2 text-xs sm:text-sm rounded-lg border-2 border-primary focus:ring-1 focus:ring-primary focus:border-primary focus:outline-none @error('newCourseId') border-red-500 @enderror">
                                <option value="" selected>Select Course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->abbreviation }}</option>
                                @endforeach
                            </select>
                            @error('newCourseId')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3 sm:mt-4 pb-3 sm:pb-4 border-b-2 border-gray-300">
                        <div class="flex items-center cursor-pointer w-fit" wire:click="toggleChangePassword">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-lock-icon lucide-lock w-7 h-7 sm:w-8 sm:h-8 bg-blue-200 text-blue-700 rounded-sm p-1.5 sm:p-2">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            <p class="ml-2 text-blue-700 text-sm sm:text-base">Change Password</p>
                        </div>

                        @if ($changePasswordIsShown)
                            <div class="border-l-2 pl-3 sm:pl-5 mt-3 border-blue-400">
                                <p class="text-gray-700 text-xs sm:text-sm ">Current Password</p>
                                <div class="relative w-full sm:w-[70%] md:w-[50%]" x-data="{ showCurrentPassword: false }">
                                    <input :type="showCurrentPassword ? 'text' : 'password'" wire:model="currentPasswordInput"
                                        class="border rounded-lg px-3 pr-10 w-full py-2 text-sm sm:text-base @error('currentPasswordInput') border-red-500 @enderror" />
                                    <div @click="showCurrentPassword = !showCurrentPassword"
                                        class="absolute cursor-pointer inset-y-0 right-0 flex items-center pr-3 text-gray-600 hover:text-gray-800">
                                        <svg x-show="!showCurrentPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <svg x-show="showCurrentPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                @error('currentPasswordInput')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror

                                <p class="text-gray-700 text-xs sm:text-sm mt-3">New Password</p>
                                <div class="relative w-full sm:w-[70%] md:w-[50%]" x-data="{ showNewPassword: false }">
                                    <input :type="showNewPassword ? 'text' : 'password'" wire:model="newPassword"
                                        class="border rounded-lg px-3 pr-10 w-full py-2 text-sm sm:text-base @error('newPassword') border-red-500 @enderror" />
                                    <div @click="showNewPassword = !showNewPassword"
                                        class="absolute cursor-pointer inset-y-0 right-0 flex items-center pr-3 text-gray-600 hover:text-gray-800">
                                        <svg x-show="!showNewPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <svg x-show="showNewPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                @error('newPassword')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror

                                <p class="text-gray-700 text-xs sm:text-sm mt-3">Confirm New Password</p>
                                <div class="relative w-full sm:w-[70%] md:w-[50%]" x-data="{ showConfirmPassword: false }">
                                    <input :type="showConfirmPassword ? 'text' : 'password'" wire:model="confirmNewPassword"
                                        class="border rounded-lg px-3 pr-10 w-full py-2 text-sm sm:text-base @error('confirmNewPassword') border-red-500 @enderror" />
                                    <div @click="showConfirmPassword = !showConfirmPassword"
                                        class="absolute cursor-pointer inset-y-0 right-0 flex items-center pr-3 text-gray-600 hover:text-gray-800">
                                        <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                @error('confirmNewPassword')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>

                    <div class="mt-3 sm:mt-4 pb-3 sm:pb-4 border-b-2 border-gray-300" x-data="{ isPublic: @entangle('updateProfileToPublic') }">
                        <p class="text-gray-700 text-xs sm:text-sm mb-2 sm:mb-1">Profile Visibility</p>
                        <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-5">
                            <div :class="{
                                                                                                                                                                                                                    'border-green-500 bg-green-50': isPublic,
                                                                                                                                                                                                                    'border-gray-300 cursor-pointer hover:bg-gray-100': !isPublic
                                                                                                                                                                                                                }"
                                class="p-2 sm:p-3 rounded-lg border-2 flex items-center justify-start"
                                @click="isPublic = true; $wire.setProfileToPublic()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    :class="{
                                                                                                                                                                                                                            'bg-green-200 text-green-700': isPublic,
                                                                                                                                                                                                                            'bg-gray-200 text-gray-700': !isPublic
                                                                                                                                                                                                                        }"
                                    class="lucide lucide-eye-icon lucide-eye p-1.5 sm:p-2 w-8 h-8 sm:w-10 sm:h-10 rounded-md">
                                    <path
                                        d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                <div class="ml-2 sm:ml-3">
                                    <p class="text-xs sm:text-sm font-semibold">Public</p>
                                    <p class="text-[10px] sm:text-xs text-gray-600">Everyone can see your uploaded contents on your profile</p>
                                </div>
                            </div>

                            <div :class="{
                                                                                                                                                                                                                    'border-gray-700 bg-gray-50': !isPublic,
                                                                                                                                                                                                                    'border-gray-300 cursor-pointer hover:bg-gray-100': isPublic
                                                                                                                                                                                                                }"
                                class="p-2 sm:p-3 rounded-lg border-2 flex items-center justify-start"
                                @click="isPublic = false; $wire.setProfileToPrivate()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    :class="{
                                                                                                                                                                                                                            'bg-gray-200 text-gray-700': !isPublic,
                                                                                                                                                                                                                            'bg-gray-200 text-gray-700': isPublic
                                                                                                                                                                                                                        }"
                                    class="lucide lucide-eye-off-icon lucide-eye-off p-1.5 sm:p-2 w-8 h-8 sm:w-10 sm:h-10 rounded-md">
                                    <path
                                        d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49" />
                                    <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                                    <path
                                        d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143" />
                                    <path d="m2 2 20 20" />
                                </svg>
                                <div class="ml-2 sm:ml-3">
                                    <p class="text-xs sm:text-sm font-semibold">Private</p>
                                    <p class="text-[10px] sm:text-xs text-gray-600">Only you can see your uploaded contents on your profile</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Delete Account Section -->
                    <div class="mt-3 sm:mt-4">
                        <button wire:click="openDeleteAccountModal"
                            class="flex items-center justify-center border-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-md space-x-1 sm:space-x-2 text-xs sm:text-sm text-red-600 border-red-600 hover:bg-red-600 hover:text-white transition-colors duration-150 ease-in-out cursor-pointer w-full sm:w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-trash-2 w-4 h-4 sm:w-5 sm:h-5">
                                <path d="M3 6h18" />
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                <line x1="10" x2="10" y1="11" y2="17" />
                                <line x1="14" x2="14" y1="11" y2="17" />
                            </svg>
                            <span>Delete Account</span>
                        </button>
                    </div>
                </div>
            @else
                <div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3 border-b-2 border-gray-300 pb-3 sm:pb-4">
                        <div class="">
                            <p class="text-gray-700 text-xs sm:text-sm ">Email</p>
                            <p class="font-semibold text-sm sm:text-base break-all">{{ $user->email }}</p>
                        </div>
                        <div class="">
                            <p class="text-gray-700 text-xs sm:text-sm ">Username</p>
                            <p class="font-semibold text-sm sm:text-base">{{ $user->username }}</p>
                        </div>
                        <div class="">
                            <p class="text-gray-700 text-xs sm:text-sm ">First Name</p>
                            <p class="font-semibold text-sm sm:text-base">{{ $user->first_name }}</p>
                        </div>
                        <div class="">
                            <p class="text-gray-700 text-xs sm:text-sm ">Last Name</p>
                            <p class="font-semibold text-sm sm:text-base">{{ $user->last_name }}</p>
                        </div>
                        <div class="">
                            <p class="text-gray-700 text-xs sm:text-sm ">Course</p>
                            <p class="font-semibold text-sm sm:text-base">{{ $user->course->name }}</p>
                        </div>
                    </div>
                    <div>
                        <div class="bg-slate-50 p-2 sm:p-3 rounded-xl mt-3 sm:mt-4 flex items-stretch">

                            @if ($user->is_public)
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="#009903" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-eye-icon lucide-eye p-2 sm:p-3 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-green-200">
                                    <path
                                        d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-eye-off-icon lucide-eye-off p-2 sm:p-3 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gray-200">
                                    <path
                                        d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49" />
                                    <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                                    <path
                                        d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143" />
                                    <path d="m2 2 20 20" />
                                </svg>
                            @endif

                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center flex-1 ml-3 sm:ml-4 gap-2 sm:gap-0">
                                <div>
                                    <p class="font-medium text-sm sm:text-base">Profile visibility</p>
                                    <p class="text-xs sm:text-sm text-gray-500">
                                        @if ($user->is_public)
                                            <span>Everyone can see you uploaded contents on your profile</span>
                                        @else
                                            <span>Only you can see your uploaded contents on your profile</span>
                                        @endif
                                    </p>
                                </div>
                                <p @class([
                                    'px-3 sm:px-4 py-1 sm:py-2 rounded-full font-medium text-xs sm:text-sm',
                                    'bg-green-200 text-green-700' => $user->is_public,
                                    'bg-gray-200 text-gray-700' => !$user->is_public,
                                ])>{{ $user->is_public ? 'Public' : 'Private' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            @endif

        </div>
    @endif

    @if ($user->is_public || $user->id == auth()->id())

        <div class="shadow-[0_0px_10px_rgba(0,0,0,0.15)] w-[95%] p-3 sm:p-4 md:p-5 rounded-lg">
            @if ($user->files_count + $user->folders_count > 0)

                <h1 class="text-base sm:text-lg font-semibold mb-2 sm:mb-3">Uploaded Content</h1>
                @if ($user->folders_count > 0)
                    <p class="mb-2 font-medium text-sm sm:text-base">
                        <span>Folders</span>
                        <span>({{ $user->folders_count }})</span>
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-5 lg:gap-7">
                        @foreach ($user->folders as $folder)
                            <livewire:component.folder-card :folder="$folder" :key="'user-folder-' . $folder->id" :showParent="true" />
                        @endforeach
                    </div>
                @endif
                @if ($user->files_count > 0)
                    <p class="mb-2 mt-3 font-medium text-sm sm:text-base">
                        <span>Files</span>
                        <span>({{ $user->files_count }})</span>
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-5 lg:gap-7">
                        @foreach ($user->files as $file)
                            <livewire:component.file-card :file="$file" :key="'user-file-' . $file->id" />
                        @endforeach
                    </div>
                @endif

            @else
                <div class="flex flex-col items-center justify-center flex-1 my-6 sm:my-8 md:my-10 px-4">
                    <!-- No folders or files found in this folder. -->

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-folder-open-icon lucide-folder-open w-16 h-16 sm:w-20 sm:h-20">
                        <path
                            d="m6 14 1.5-2.9A2 2 0 0 1 9.24 10H20a2 2 0 0 1 1.94 2.5l-1.54 6a2 2 0 0 1-1.95 1.5H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H18a2 2 0 0 1 2 2v2" />
                    </svg>

                    <p class="text-lg sm:text-xl font-medium my-3 sm:my-4 text-center">No uploads yet</p>

                    <p class="text-gray-700 text-sm sm:text-base text-center">
                        @if (auth()->id() == $user->id)
                            <span>You haven't uploaded any files or folders. Start uploading to see your content here.</span>
                        @else
                            <span>This user hasn't uploaded any files or folders.</span>
                        @endif
                    </p>
                </div>
            @endif
        </div>

    @else

        <div
            class="shadow-[0_0px_10px_rgba(0,0,0,0.15)] w-[95%] px-4 sm:px-5 py-8 sm:py-10 md:py-14 rounded-lg text-center flex flex-col items-center justify-center space-y-3 sm:space-y-4">
            <div class="rounded-full w-16 h-16 sm:w-20 sm:h-20 bg-gray-200 flex justify-center items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-lock-icon lucide-lock w-8 h-8 sm:w-10 sm:h-10 text-gray-500">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
            </div>
            <p class="text-xl sm:text-2xl font-semibold">This Account is Private</p>
            <p class="text-gray-700 text-sm sm:text-base">This user has set their account to private. Only they can view their uploaded content
                on their profile.</p>
        </div>
    @endif

    @if (auth()->id() == $user->id && $user->userActivities->count() > 0)
        <div class="shadow-[0_0px_10px_rgba(0,0,0,0.15)] w-[95%] p-3 sm:p-4 md:p-5 rounded-lg mt-4 sm:mt-5" x-data="{ showAllActivities: false }">
            <h1 class="text-base sm:text-lg font-semibold mb-2 sm:mb-3">Activity Log</h1>
            <div class="space-y-1 flex flex-col items-center">
                @foreach ($user->userActivities->take(5) as $activity)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-xs sm:text-sm py-2 w-full gap-1 sm:gap-0">
                        <p class="break-words">{{ $activity->details }}</p>
                        <p class="text-gray-600 sm:text-gray-900 whitespace-nowrap text-[10px] sm:text-xs">{{ $activity->created_at->format('F j, Y h:i A') }}</p>
                    </div>
                @endforeach

                <template x-if="showAllActivities">
                    <div class="w-full space-y-1">
                        @foreach ($user->userActivities->skip(5) as $activity)
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-xs sm:text-sm py-2 w-full gap-1 sm:gap-0">
                                <p class="break-words">{{ $activity->details }}</p>
                                <p class="text-gray-600 sm:text-gray-900 whitespace-nowrap text-[10px] sm:text-xs">{{ $activity->created_at->format('F j, Y h:i A') }}</p>
                            </div>
                        @endforeach
                    </div>
                </template>
            </div>

            @if ($user->userActivities->count() > 5)
                <div class="flex justify-center mt-2 sm:mt-3">
                    <button @click="showAllActivities = !showAllActivities"
                        class="flex items-center gap-1 sm:gap-2 cursor-pointer text-xs sm:text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors duration-150">
                        <span x-text="showAllActivities ? 'Show Less' : 'Show All Activities'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-3 h-3 sm:w-4 sm:h-4 transition-transform duration-200" :class="{ 'rotate-180': showAllActivities }">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    @endif

    <!-- Delete Account Modal -->
    @if ($deleteAccountModalIsOpen)
        <div wire:click.stop>
            <livewire:component.modal.delete-account />
        </div>
    @endif
</div>