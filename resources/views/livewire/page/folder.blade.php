<div class="space-y-3 flex-1 flex flex-col">

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
            'bg-slate-100 rounded-lg p-5 flex-1 transition-all duration-300 ease-in-out',
            'mr-[18.5rem]' => $detailPanelIsOpen,
            'mr-0' => !$detailPanelIsOpen,
        ])>
            <div class="flex justify-between items-center">
                <livewire:component.breadcrumb :courseSlug="$this->course->slug" :path="$this->path" />
                <img src="{{ asset('/assets/details.svg') }}" wire:click="clickInfoIcon" @class([
                    'w-9 p-2 rounded-full cursor-pointer transition-colors duration-100 ease-in-out',
                    'bg-blue-100 hover:bg-blue-200' => $detailPanelIsOpen,
                    'hover:bg-gray-200' => !$detailPanelIsOpen,
                ]) />
            </div>

            <div class="flex items-start justify-between my-5 border-b border-slate-500 pb-3">
                <h1 class="text-2xl font-bold truncate max-w-[38rem]">{{ $folder->name }}</h1>
                @if ($currentUserIsEligibleToUpload)
                    <livewire:component.add-new-button :parentIsAFolder="true" :parentId="$folder->id" />
                @endif
            </div>

            @if ($search && $folders->isEmpty() && $files->isEmpty())
                <div class="flex items-center justify-center border border-green-700">
                    <!-- Empty result of search -->
                    <p class="">No folders or files found for "{{ $search }}"</p>
                </div>
            @elseif(!$search && $folders->isEmpty() && $files->isEmpty())
                <div class="flex items-center justify-center border border-green-700">
                    <!-- No folders or files found in this folder. -->
                    <p>No folders or files found.</p>
                </div>
            @else

                @if(!$folders->isEmpty()) <!-- Show folders if there are any -->
                    <p class="mb-2">Folders</p>
                    <div class="grid md:grid-cols-2 xl:grid-cols-3 md:gap-5 lg:gap-9 xl:gap-9 mb-5">
                        @foreach ($folders as $folder)
                            <livewire:component.folder-card :folder="$folder" :courseSlug="$course->slug" :path="$this->path"
                                wire:key="course-folder-{{ $folder->id }}" />
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
        <div @class([
            'bg-slate-100 fixed right-3 top-[6rem] bottom-3 rounded-lg transition-all duration-300 ease-in-out overflow-x-hidden scrollbar-hide',
            'w-72 ' => $detailPanelIsOpen,
            'w-0' => !$detailPanelIsOpen,
        ])>
            <livewire:component.folder-details-pane :folder="$this->folder" />
        </div>

    </div>

    @if ($isCreateFolderModalOpen)
        <livewire:component.create-folder :parentId="$this->folder->id" :parentIsFolder="true"
            wire:key="create-folder-modal-folder-{{ $this->folder->id }}" />
    @endif
</div>