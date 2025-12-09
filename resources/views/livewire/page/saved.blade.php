<div class="space-y-3 flex-1 flex flex-col">
    <div class="bg-slate-50 w-full rounded-lg flex flex-col sm:flex-row justify-between items-stretch sm:items-center px-3 sm:px-4 py-3 sm:py-2 gap-3 sm:gap-0">
        <form wire:submit.prevent="submitSearch"
            class="border sm:ml-10 lg:ml-0 border-gray-600 rounded-md flex justify-center items-stretch bg-white overflow-hidden w-full sm:w-80 md:w-96 h-10 sm:h-12 order-2 sm:order-1">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Start typing to search saved items..."
                class="px-2 sm:px-3 flex-1 focus:outline-none focus:ring-0 border-none text-xs sm:text-sm" />
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

    <div class="bg-slate-50/85 rounded-lg py-4 px-3 sm:py-6 sm:px-6 md:py-8 md:px-10 flex-1 flex flex-col" x-data="{ activeCategory: @entangle('chosenCategory') }">
        <h1 class="text-2xl sm:text-3xl font-bold">Saved Items</h1>
        <p class="text-gray-800 mt-1 sm:mt-2 text-sm sm:text-base">Quick access to your bookmarked folders and files.</p>

        <div class="flex flex-wrap justify-start items-center my-4 sm:my-6 text-xs sm:text-sm gap-2 z-1">
            <button @class([
                'py-1.5 sm:py-2 px-3 sm:px-5 rounded-lg border transition-colors',
            ])    :class="activeCategory === 0 ? 'bg-blue-600 text-white border-blue-500' : 'border-gray-400 cursor-pointer hover:bg-gray-200 transition-colors duration-100 ease-in-out'"
                @click="activeCategory = 0; $wire.changeCategory(0)">All ({{ $foldersCount + $filesCount }})</button>
            <button @class([
                'py-1.5 sm:py-2 px-3 sm:px-5 rounded-lg border transition-colors',
            ])    :class="activeCategory === 1 ? 'bg-blue-600 text-white border-blue-500' : 'border-gray-400 cursor-pointer hover:bg-gray-200 transition-colors duration-100 ease-in-out'"
                @click="activeCategory = 1; $wire.changeCategory(1);">Folders ({{ $foldersCount }})</button>
            <button @class([
                'py-1.5 sm:py-2 px-3 sm:px-5 rounded-lg border transition-colors',
            ])    :class="activeCategory === 2 ? 'bg-blue-600 text-white border-blue-500' : 'border-gray-400 cursor-pointer hover:bg-gray-200 transition-colors duration-100 ease-in-out'"
                @click="activeCategory = 2; $wire.changeCategory(2);">Files ({{ $filesCount }})</button>
        </div>

        @if ($search && $foldersCount <= 0 && $filesCount <= 0)
            <div class="flex flex-col items-center justify-center flex-1 -mt-6 sm:-mt-10 z-10 px-4">
                <!-- Empty result of search -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-search-icon lucide-search w-16 h-16 sm:w-20 sm:h-20">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </svg>
                <p class="text-lg sm:text-xl font-medium my-3 sm:my-4 text-center">No saved items found</p>
                <p class="text-sm sm:text-base text-gray-700 text-center break-all max-w-[90%] sm:max-w-[80%]">No saved items found for
                    "<strong>{{ $search }}</strong>".</p>
                <p class="text-sm sm:text-base text-gray-700 text-center mt-2 sm:mt-3">Try searching with different keywords.</p>
                <button wire:click="clearSearch"
                    class="py-2 sm:py-3 px-4 sm:px-5 mt-3 sm:mt-4 rounded-lg hover:bg-gray-200 border border-gray-400 transition-colors duration-150 ease-in-out cursor-pointer text-sm sm:text-base">Clear
                    Search</button>
            </div>
        @elseif(!$search && $foldersCount <= 0 && $filesCount <= 0 && $chosenCategory == 0)
            <div class="flex flex-col items-center justify-center flex-1 -mt-6 sm:-mt-10 z-10 px-4">
                <!-- No folders or files saved. -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-bookmark-icon lucide-bookmark h-16 w-16 sm:h-20 sm:w-20">
                    <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                </svg>
                <p class="text-lg sm:text-xl font-medium my-3 sm:my-4 text-center">No saved items yet</p>
                <p class="text-gray-700 text-sm sm:text-base text-center">Bookmark folders and files to find them here.</p>
            </div>
        @endif

        @if ($foldersCount <= 0 && $chosenCategory == 1)
            <div class="flex flex-col items-center justify-center flex-1 -mt-6 sm:-mt-10 z-10 px-4">
                <!-- No folders saved. -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-bookmark-icon lucide-bookmark h-16 w-16 sm:h-20 sm:w-20">
                    <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                </svg>
                <p class="text-lg sm:text-xl font-medium my-3 sm:my-4 text-center">No saved folders yet</p>
                <p class="text-gray-700 text-sm sm:text-base text-center">Bookmark folders to find them here.</p>
            </div>
        @endif

        @if ($filesCount <= 0 && $chosenCategory == 2)
            <div class="flex flex-col items-center justify-center flex-1 -mt-6 sm:-mt-10 z-10 px-4">
                <!-- No files saved. -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-bookmark-icon lucide-bookmark h-16 w-16 sm:h-20 sm:w-20">
                    <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                </svg>
                <p class="text-lg sm:text-xl font-medium my-3 sm:my-4 text-center">No saved files yet</p>
                <p class="text-gray-700 text-sm sm:text-base text-center">Bookmark files to find them here.</p>
            </div>
        @endif


        @if ($chosenCategory != 2 && $foldersCount > 0)
            <p class="mb-2 text-sm sm:text-base">Folders</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-4 md:gap-5 lg:gap-7 xl:gap-9 mb-4 sm:mb-5">
                @foreach ($savedFolders as $folder)
                    <livewire:component.folder-card :folder="$folder" wire:key="{{ $folder->uuid }}" />
                @endforeach
            </div>
        @endif

        @if ($chosenCategory != 1 && $filesCount > 0)
            <p class="mb-2 text-sm sm:text-base">Files</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-5">
                @foreach ($savedFiles as $file)
                    <livewire:component.file-card :file="$file" wire:key="file-{{ $file->id }}" />
                @endforeach
            </div>
        @endif

    </div>
</div>