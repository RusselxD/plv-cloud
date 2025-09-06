<div class="relative">
    <x-ui.general.breadcrumb :breadcrumbs="[
        ['Home', '/'],
        [$course->abbreviation, route('course', ['courseSlug' => $course->slug])]
    ]" />
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
            <!-- Empty result of search -->
            <p>No folders or files found for "{{ $search }}"</p>
        @elseif($search && $folders->isEmpty())
            <!-- No folders found in this course. -->
            <p>No folders found in this course.</p>
        @else
            <div class="grid md:grid-cols-2 xl:grid-cols-3 md:gap-5 lg:gap-9 xl:gap-9">
                @foreach ($folders as $folder)
                    <div wire:click="goToFolder('{{ $folder->slug }}')">
                        <x-ui.course.folder-card :folder="$folder" />
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div wire:click="openCreateFolderModal"
     class="absolute bottom-16 right-16 w-fit p-3 rounded-full bg-black hover:bg-gray-900 cursor-pointer shadow:lg">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none"
            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-plus-icon lucide-plus">
            <path d="M5 12h14" />
            <path d="M12 5v14" />
        </svg>
    </div>
</div>