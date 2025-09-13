<div class="relative border border-red-800">



    <livewire:component.breadcrumb :courseSlug="$this->course->slug" />

    <div class="flex justify-between items-center text-wrap mb-5">
        <h1 class="text-2xl font-bold">{{ $course->name }}</h1>
        <form wire:submit.prevent="clickSearch"
            class="border border-gray-600 rounded-md flex justify-center bg-white overflow-hidden w-fit items-stretch">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search for folders or files..."
                class="text-sm px-3 flex-1 focus:outline-none focus:ring-0 border-none" />
            <button class="p-2 h-full cursor-pointer hover:bg-gray-200" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-search-icon lucide-search">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </svg>
            </button>
        </form>
    </div>
    <div>
        @if ($folders->isEmpty() && $search)
            <div class="flex flex-col items-center justify-center text-center border border-green-700">
                <!-- Empty result of search -->
                <p class="">No folders or files found for "{{ $search }}"</p>
            </div>
        @elseif(!$search && $folders->isEmpty())
            <div class="flex flex-col items-center justify-center text-center border border-green-700 py-48">
                <!-- No folders found in this course. -->
                <p>No folders found in this course.</p>
            </div>
        @else
            <div class="grid md:grid-cols-2 xl:grid-cols-3 md:gap-5 lg:gap-9 xl:gap-9">
                @foreach ($folders as $folder)
                    <livewire:component.folder-card :folder="$folder" :courseSlug="$course->slug"
                        wire:key="course-folder-{{ $folder->id }}" />
                @endforeach
            </div>
        @endif
    </div>

    <!-- Circle plus button to create a new folder -->
    <div wire:click="openCreateFolderModal"
        class="absolute bottom-5 right-5 w-fit p-3 rounded-full bg-black hover:bg-gray-900 cursor-pointer shadow:lg">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus">
            <path d="M5 12h14" />
            <path d="M12 5v14" />
        </svg>
    </div>

    @if ($isCreateFolderModalOpen)
        <livewire:component.create-folder :parentId="$course->id" :parentIsFolder="false"
            wire:key="create-folder-modal-course-{{ $course->id }}" />
    @endif
</div>