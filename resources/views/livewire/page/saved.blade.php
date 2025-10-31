<div class="space-y-3 flex-1 flex flex-col">
    <div class="bg-slate-50 w-full rounded-lg flex justify-between items-center py-2 px-4">
        <form wire:submit.prevent="submitSearch"
            class="border border-gray-600 rounded-md flex justify-center items-stretch bg-white overflow-hidden w-96 h-12">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Start typing to search saved items..."
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

    <div class="bg-slate-50/85 rounded-lg py-8 px-10 flex-1 flex flex-col" x-data="{ activeCategory: @entangle('chosenCategory') }">
        <h1 class="text-3xl font-bold">Saved Items</h1>
        <p class="text-gray-800 mt-2">Quick access to your bookmarked folders and files.</p>

        <div class="flex justify-start items-center my-6 text-sm space-x-2 z-1">
            <button @class([
                'py-2 px-5 rounded-lg border transition-colors',
            ])    :class="activeCategory === 0 ? 'bg-blue-600 text-white border-blue-500' : 'border-gray-400 cursor-pointer hover:bg-gray-200 transition-colors duration-100 ease-in-out'"
                @click="activeCategory = 0; $wire.changeCategory(0)">All ({{ $foldersCount + $filesCount }})</button>
            <button @class([
                'py-2 px-5 rounded-lg border transition-colors',
            ])    :class="activeCategory === 1 ? 'bg-blue-600 text-white border-blue-500' : 'border-gray-400 cursor-pointer hover:bg-gray-200 transition-colors duration-100 ease-in-out'"
                @click="activeCategory = 1; $wire.changeCategory(1);">Folders ({{ $foldersCount }})</button>
            <button @class([
                'py-2 px-5 rounded-lg border transition-colors',
            ])    :class="activeCategory === 2 ? 'bg-blue-600 text-white border-blue-500' : 'border-gray-400 cursor-pointer hover:bg-gray-200 transition-colors duration-100 ease-in-out'"
                @click="activeCategory = 2; $wire.changeCategory(2);">Files ({{ $filesCount }})</button>
        </div>

        @if ($foldersCount <= 0 && $filesCount <= 0 && $chosenCategory == 0)
            <div class="flex flex-col items-center justify-center flex-1 -mt-10 z-10">
                <!-- No folders or files saved. -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-bookmark-icon lucide-bookmark h-20 w-20">
                    <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                </svg>
                <p class="text-xl font-medium my-4">No saved items yet</p>
                <p class="text-gray-700">Bookmark folders and files to find them here.</p>
            </div>
        @endif

        @if ($foldersCount <= 0 && $chosenCategory == 1)
            <div class="flex flex-col items-center justify-center flex-1 -mt-10 z-10">
                <!-- No folders saved. -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-bookmark-icon lucide-bookmark h-20 w-20">
                    <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                </svg>
                <p class="text-xl font-medium my-4">No saved folders yet</p>
                <p class="text-gray-700">Bookmark folders to find them here.</p>
            </div>
        @endif

        @if ($filesCount <= 0 && $chosenCategory == 2)
            <div class="flex flex-col items-center justify-center flex-1 -mt-10 z-10">
                <!-- No files saved. -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-bookmark-icon lucide-bookmark h-20 w-20">
                    <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                </svg>
                <p class="text-xl font-medium my-4">No saved files yet</p>
                <p class="text-gray-700">Bookmark files to find them here.</p>
            </div>
        @endif


        @if ($chosenCategory != 2 && $foldersCount > 0)
            <p class="mb-2">Folders</p>
            <div class="grid md:grid-cols-2 xl:grid-cols-3 md:gap-5 lg:gap-9 xl:gap-9 mb-5">
                @foreach ($savedFolders as $folder)
                    <livewire:component.folder-card :folder="$folder" wire:key="{{ $folder->uuid }}" />
                @endforeach
            </div>
        @endif

        @if ($chosenCategory != 1 && $filesCount > 0)
            <p class="mb-2">Files</p>
            <div class="grid grid-cols-3 gap-5">
                @foreach ($savedFiles as $file)
                    <livewire:component.file-card :file="$file" wire:key="file-{{ $file->id }}" />
                @endforeach
            </div>
        @endif

    </div>
</div>