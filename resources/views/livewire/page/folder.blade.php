<div class="space-y-3 flex-1 flex flex-col">

    <div class="bg-slate-50 w-full rounded-lg flex justify-between items-center p-2 h-20">
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

    <div class="bg-slate-50/85 rounded-lg p-5 flex-1">
        <livewire:component.breadcrumb :courseSlug="$this->course->slug" :path="$this->path" />

        <div class="flex items-center justify-between mb-5 border-b border-slate-500 pb-3">
            <h1 class="text-2xl font-bold">{{ $folder->name }}</h1>
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



    @if ($isCreateFolderModalOpen)
        <livewire:component.create-folder :parentId="$this->folder->id" :parentIsFolder="true"
            wire:key="create-folder-modal-folder-{{ $this->folder->id }}" />
    @endif
</div>