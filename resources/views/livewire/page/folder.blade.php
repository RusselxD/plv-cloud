<div class="space-y-3 flex-1 flex flex-col" x-data="{ detailPanelOpen: @entangle('detailPanelIsOpen') }">

    <div class="fixed right-3 left-3 lg:left-64 top-0 py-2 z-30 bg-white">
        <div class="bg-slate-100 sm:pl-12 lg:pl-3 w-full rounded-lg flex flex-col sm:flex-row justify-between items-stretch sm:items-center px-3 sm:px-4 py-3 sm:py-2 gap-3 sm:gap-0">
            <form wire:submit.prevent="clickSearch"
                class="border border-gray-600 rounded-md flex justify-center items-stretch bg-white overflow-hidden w-full sm:w-80 md:w-96 h-10 sm:h-12 order-2 sm:order-1">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search for folders or files..."
                    class="px-2 sm:px-3 flex-1 focus:outline-none focus:ring-0 border-none text-xs sm:text-sm" maxlength="100" />
                <button class="p-2 sm:p-3 h-full cursor-pointer hover:bg-gray-200" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-search-icon lucide-search sm:w-6 sm:h-6">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </button>
            </form>

            <div class="order-1 sm:order-2 ml-auto">
                <livewire:component.profile-with-notif />
            </div>
        </div>
    </div>

    <!-- Parent Container of contents and details pane -->
    <div class="flex flex-1 mt-[5.25rem] rounded-lg overflow-hidden">

        <!-- Contents Pane -->
        <div @class([
            'bg-slate-100 rounded-lg p-3 sm:p-4 md:p-5 flex-1 transition-all duration-300 ease-in-out flex flex-col',

        ])    :class="detailPanelOpen ? 'lg:mr-[22.5rem]' : 'mr-0'">
            <div class="flex flex-col  relative sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-0">

                <span class="mt-[7.5rem] sm:mt-[4.5rem] w-full">
                    <x-ui.general.breadcrumbs :breadcrumbs="$breadcrumbs" />
                </span>

                <div class="absolute top-12 right-1 sm:top-0 sm:right-0 flex items-center space-x-1 ml-auto">
                    @auth
                        @if ($isSaved)
                            <img src="{{ asset('assets/save-filled.svg') }}" class="w-5 sm:w-6 cursor-pointer" wire:click="unsaveFolder"/>

                        @else
                            <img src="{{ asset('assets/save.svg') }}" class="w-5 sm:w-6 cursor-pointer" wire:click="saveFolder"/>
                        @endif
                    @endauth
                    <img src="{{ asset('/assets/details.svg') }}" @click="detailPanelOpen = !detailPanelOpen"
                        class='w-8 sm:w-9 p-2 rounded-full cursor-pointer transition-colors duration-100 ease-in-out'
                        :class="detailPanelOpen ? 'bg-blue-100 hover:bg-blue-200' : 'hover:bg-gray-200'" />
                </div>

            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between my-3 sm:my-5 border-b border-slate-500 pb-3 gap-3 sm:gap-0">
                @if(auth()->id() === $folder->user_id)
                    <h1 class="text-xl sm:text-2xl font-bold truncate max-w-full sm:max-w-[38rem] rounded-md -ml-2 py-1 pl-2 pr-3 hover:bg-gray-200 cursor-pointer"
                        wire:click="openRenameModal">
                        {{ $folder->name }}
                    </h1>
                @else
                    <h1 class="text-xl sm:text-2xl font-bold truncate max-w-full sm:max-w-[38rem] rounded-md -ml-2 py-1 pl-2 pr-3">
                        {{ $folder->name }}
                    </h1>
                @endif

                @if ($currentUserIsEligibleToUpload)
                    <livewire:component.add-new-button :parentIsAFolder="true" :parentId="$folder->id" />
                @endif
            </div>

            @if ($search && $folders->isEmpty() && $files->isEmpty())
                <div class="flex flex-col items-center justify-center flex-1 px-4">
                    <!-- Empty result of search -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-search-icon lucide-search w-16 h-16 sm:w-20 sm:h-20">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                    <p class="text-lg sm:text-xl font-medium my-3 sm:my-4 text-center">No folders or files found</p>
                    <p class="text-sm sm:text-base text-gray-700 text-center break-all max-w-[90%] sm:max-w-[80%]">No folders or files found for
                        "<strong>{{ $search }}</strong>".</p>
                    <p class="text-sm sm:text-base text-gray-700 text-center mt-2 sm:mt-3"> Try searching with different keywords.</p>
                    <button wire:click="clearSearch"
                        class="py-2 sm:py-3 px-4 sm:px-5 mt-3 sm:mt-4 rounded-lg hover:bg-gray-200 border border-gray-400 transition-colors duration-150 ease-in-out cursor-pointer text-sm sm:text-base">Clear
                        Search</button>
                </div>
            @elseif(!$search && $folders->isEmpty() && $files->isEmpty())
                <div class="flex flex-col items-center justify-center mt-10 sm:mt-20 px-4">
                    <!-- No folders or files found in this folder. -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-folder-open-icon lucide-folder-open w-16 h-16 sm:w-20 sm:h-20">
                        <path
                            d="m6 14 1.5-2.9A2 2 0 0 1 9.24 10H20a2 2 0 0 1 1.94 2.5l-1.54 6a2 2 0 0 1-1.95 1.5H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H18a2 2 0 0 1 2 2v2" />
                    </svg>
                    <p class="text-lg sm:text-xl font-medium my-3 sm:my-4 text-center">This folder is empty</p>
                    <p class="text-sm sm:text-base text-gray-700 text-center">There are no contents in this folder yet.</p>
                </div>
            @else

                @if(!$folders->isEmpty()) <!-- Show folders if there are any -->
                    <p class="mb-2 text-sm sm:text-base">Folders</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-4 md:gap-5 lg:gap-7 xl:gap-9 mb-4 sm:mb-5">
                        @foreach ($folders as $folder)
                            <livewire:component.folder-card :folder="$folder" wire:key="{{ $folder->uuid }}" />
                        @endforeach
                    </div>
                @endif

                @if (!$files->isEmpty()) <!-- Show files if there are any -->
                    <p class="mb-2 text-sm sm:text-base">Files</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-5">
                        @foreach ($files as $file)
                            <livewire:component.file-card :file="$file" wire:key="file-{{ $file->id }}" />
                        @endforeach
                    </div>
                @endif

            @endif

        </div>

        <!-- Details Pane -->
        <div @close-details-pane.window="detailPanelOpen = false" x-cloak @class([
            ' bg-slate-100 fixed right-0 lg:right-3 px-1 top-[6rem] bottom-3 rounded-lg transition-all duration-300 ease-in-out overflow-x-hidden scrollbar-hide z-40',
        ])
            :class="detailPanelOpen ? 'w-full sm:w-[20rem] lg:w-[22rem]' : 'w-0 left-full '">
            <livewire:component.folder-details-pane :folder="$this->folder" />
        </div>

        <!-- Overlay for mobile when details pane is open -->
        <div x-show="detailPanelOpen" @click="detailPanelOpen = false" 
            class="lg:hidden fixed inset-0 bg-black/50 z-30" x-cloak
            x-transition:enter="transition-opacity ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
        </div>

    </div>

    <!-- Create Folder Modal -->
    @if ($createFolderModalIsOpen)
        <livewire:component.modal.create-folder :parentId="$this->folder->id" :parentIsFolder="true"
            wire:key="create-folder-modal-folder-{{ $this->folder->id }}" />
    @endif

    <!-- Rename Modal -->
    @if($renameModalIsOpen)
        <livewire:component.modal.rename-modal :targetId="$this->folder->id" :isAFolder="true"
            :oldName="$this->folder->name" />
    @endif
</div>