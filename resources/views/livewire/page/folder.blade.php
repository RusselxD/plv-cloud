<div class="space-y-3 flex-1 flex flex-col" x-data="{ detailPanelOpen: @entangle('detailPanelIsOpen') }">

    <div class="fixed right-3 left-64 top-0 py-2 z-100 bg-white  ">
        <div class="bg-slate-100 w-full rounded-lg flex justify-between items-center py-2 px-4">
            <form wire:submit.prevent="clickSearch"
                class="border border-gray-600 rounded-md flex justify-center items-stretch bg-white overflow-hidden w-96 h-12">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search for folders or files..."
                    class="px-3 flex-1 focus:outline-none focus:ring-0 border-none text-sm" />
                <button class="p-3 h-full cursor-pointer hover:bg-gray-200" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-search-icon lucide-search">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </button>
            </form>

            <livewire:component.profile-with-notif />
        </div>
    </div>

    <!-- Parent Container of contents and details pane -->
    <div class="flex flex-1 mt-[5.25rem] rounded-lg overflow-hidden">

        <!-- Contents Pane -->
        <div @class([
            'bg-slate-100 rounded-lg p-5 flex-1 transition-all duration-300 ease-in-out flex flex-col',

        ])    :class="detailPanelOpen ? 'mr-[22.5rem]' : 'mr-0'">
            <div class="flex justify-between items-center">

                <x-ui.general.breadcrumbs :breadcrumbs="$breadcrumbs" />

                <img src="{{ asset('/assets/details.svg') }}" @click="detailPanelOpen = !detailPanelOpen" @class([
                    'w-9 p-2 rounded-full cursor-pointer transition-colors duration-100 ease-in-out',
                    'bg-blue-100 hover:bg-blue-200' => $detailPanelIsOpen,
                    'hover:bg-gray-200' => !$detailPanelIsOpen,
                ])
                    :class="detailPanelOpen ? 'bg-blue-100 hover:bg-blue-200' : 'hover:bg-gray-200'" />
            </div>

            <div class="flex items-start justify-between my-5 border-b border-slate-500 pb-3">
                <h1 @class([
                    'text-2xl font-bold truncate max-w-[38rem] rounded-md -ml-2 py-1 pl-2 pr-3',
                    'hover:bg-gray-200 cursor-pointer' => auth()->id() == $folder->user_id,
                ])    wire:click="openRenameModal">{{ $folder->name }}</h1>
                @if ($currentUserIsEligibleToUpload)
                    <livewire:component.add-new-button :parentIsAFolder="true" :parentId="$folder->id" />
                @endif
            </div>

            @if ($search && $folders->isEmpty() && $files->isEmpty())
                <div class="flex flex-col items-center justify-center flex-1">
                    <!-- Empty result of search -->
                    <div class="w-20 h-20 flex items-center justify-center rounded-full bg-gray-200 -mt-8">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-search-icon lucide-search w-12 h-12">
                            <path d="m21 21-4.34-4.34" />
                            <circle cx="11" cy="11" r="8" />
                        </svg>
                    </div>
                    <p class="text-xl font-medium my-4">No folders or files found</p>
                    <p class="text-gray-700">No folders or files found for "<strong>{{ $search }}</strong>". Try searching
                        with different keywords.</p>
                    <button wire:click="clearSearch"
                        class="py-3 px-5 mt-4 rounded-lg hover:bg-gray-200 border border-gray-400 transition-colors duration-150 ease-in-out cursor-pointer">Clear
                        Search</button>
                </div>
            @elseif(!$search && $folders->isEmpty() && $files->isEmpty())
                <div class="flex flex-col items-center justify-center flex-1">
                    <!-- No folders or files found in this folder. -->
                    <div class="w-20 h-20 flex items-center justify-center rounded-full bg-gray-200 -mt-8">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-folder-icon lucide-folder w-12 h-12">
                            <path
                                d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z" />
                        </svg>
                    </div>
                    <p class="text-xl font-medium my-4">This folder is empty</p>
                    <p class="text-gray-700">There are no contents in this folder yet.</p>
                </div>
            @else

                @if(!$folders->isEmpty()) <!-- Show folders if there are any -->
                    <p class="mb-2">Folders</p>
                    <div class="grid md:grid-cols-2 xl:grid-cols-3 md:gap-5 lg:gap-9 xl:gap-9 mb-5">
                        @foreach ($folders as $folder)
                            <livewire:component.folder-card :folder="$folder" wire:key="{{ $folder->uuid }}" />
                        @endforeach
                    </div>
                @endif

                @if (!$files->isEmpty()) <!-- Show files if there are any -->
                    <p class="mb-2">Files</p>
                    <div class="grid grid-cols-3 gap-5">
                        @foreach ($files as $file)
                            <livewire:component.file-card :file="$file" wire:key="file-{{ $file->id }}" />
                        @endforeach
                    </div>
                @endif

            @endif

        </div>

        <!-- Details Pane -->
        <div @close-details-pane.window="detailPanelOpen = false" x-cloak @class([
            'bg-slate-100 fixed right-3 top-[6rem] bottom-3 rounded-lg transition-all duration-300 ease-in-out overflow-x-hidden scrollbar-hide',
        ])
            :class="detailPanelOpen ? 'w-[22rem]' : 'w-0'">
            <livewire:component.folder-details-pane :uuid="$this->folder->uuid" />
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