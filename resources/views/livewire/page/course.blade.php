<div>
    <div class="border border-red-500 flex justify-between items-center text-wrap my-5">
        <h1 class="text-3xl font-medium">{{ $course->name }}</h1>
        <form wire:submit.prevent="clickSearch"
            class="border border-gray-600 rounded-md flex justify-center bg-white overflow-hidden w-fit items-stretch">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search for folders..."
                class="py-2 px-4 flex-1 focus:outline-none focus:ring-0 border-none" />
            <button class="p-3 h-full cursor-pointer hover:bg-gray-200" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-search-icon lucide-search">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </svg>
            </button>
        </form>

    </div>
    <div class="border border-green-700">
        @if ($folders->isEmpty())
            <p>No folder lol</p>
        @else
            <div class="grid md:grid-cols-2 xl:grid-cols-3 md:gap-5 lg:gap-9 xl:gap-5">
                @foreach ($folders as $folder)
                    <x-ui.course.folder-card :folder="$folder" />
                @endforeach
            </div>
        @endif
    </div>
</div>