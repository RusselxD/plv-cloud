<div class="space-y-3 flex-1 flex flex-col">

    <div class="fixed right-3 left-64 top-0 py-2 z-100 bg-white">
        <div class="bg-slate-100 w-full rounded-lg flex justify-between items-center px-4 py-2">
            <form wire:submit.prevent="clickSearch"
                class="border border-gray-600 rounded-md flex justify-center items-stretch bg-white overflow-hidden w-96 h-12">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search for folders or files..."
                    class="px-3 flex-1 focus:outline-none focus:ring-0 border-none text-sm" maxlength="100"/>
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

    <div class="bg-slate-100 rounded-lg p-5 flex-1 mt-[5.25rem] flex flex-col">

        <x-ui.general.breadcrumbs :breadcrumbs="$breadcrumbs" />

        <div class="flex flex-col flex-1">
            <div class="flex items-start justify-between my-5 border-b border-slate-500 pb-3">
                <h1 class="text-2xl font-bold">{{ $course->name }}</h1>
                @if (auth()->check())
                    <livewire:component.add-new-button :parentIsAFolder="false" :parentId="$course->id" />
                @endif
            </div>

            @if ($search && $folders->isEmpty() && $files->isEmpty())
                <div class="flex flex-col items-center justify-center flex-1 -mt-10">
                    <!-- Empty result of search -->

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-search-icon lucide-search w-20 h-20">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>

                    <p class="text-xl font-medium my-4">No folders or files found</p>
                    <p class="text-gray-700 text-center break-all max-w-[80%] ">No folders or files found for
                        "<strong>{{ $search }}</strong>".</p>
                    <p class="text-gray-700 text-center mt-3"> Try searching with different keywords.</p>
                    <button wire:click="clearSearch"
                        class="py-3 px-5 mt-4 rounded-lg hover:bg-gray-200 border border-gray-400 transition-colors duration-150 ease-in-out cursor-pointer">Clear
                        Search</button>
                </div>
            @elseif(!$search && $folders->isEmpty() && $files->isEmpty())
                <div class="flex flex-col items-center justify-center flex-1 -mt-20">
                    <!-- No folders or files found in this folder. -->

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-folder-open-icon lucide-folder-open w-20 h-20">
                        <path
                            d="m6 14 1.5-2.9A2 2 0 0 1 9.24 10H20a2 2 0 0 1 1.94 2.5l-1.54 6a2 2 0 0 1-1.95 1.5H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H18a2 2 0 0 1 2 2v2" />
                    </svg>

                    <p class="text-xl font-medium my-4">No contents in this course</p>
                    <p class="text-gray-700">Start by adding files or creating new folders.</p>
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
    </div>

    <!-- Create Folder Modal -->
    @if ($createFolderModalIsOpen)
        <livewire:component.modal.create-folder :parentId="$course->id" :parentIsFolder="false"
            wire:key="create-folder-modal-course-{{ $course->id }}" />
    @endif
</div>