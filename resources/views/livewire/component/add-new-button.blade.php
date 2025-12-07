<div class="relative" x-data="{ openOptions: @entangle('openOptions') }">
    <div @click="openOptions = !openOptions"
        class="text-xs md:text-sm rounded-lg flex items-center justify-center gap-2 whitespace-nowrap flex-1 bg-blue-600 text-white py-2 pl-2 md:pl-3 pr-4 cursor-pointer hover:bg-blue-700 transition-colors duration-100 ease-in-out">
        <img src="{{ asset('/assets/plus.svg') }}"  class="w-5 sm:w-6"/>
        Add New
    </div>

    <div x-show="openOptions" @click.away="openOptions = false" x-collapse x-cloak
        class="text-xs md:text-sm absolute bg-white left-0 sm:left-auto sm:right-0 top-full mt-1 rounded-md shadow-lg border border-gray-200 z-50 text-black w-44 whitespace-nowrap">

        <div class="absolute inset-0 bg-black/20" wire:loading wire:target="uploads">
            <x-ui.general.spinner />
        </div>

        <div class="flex items-center justify-start p-3 gap-2 hover:bg-gray-200 cursor-pointer"
            wire:click="openNewFolder">
            <img src="{{ asset('/assets/folder.svg') }}" class="w-5" />
            <p>New folder</p>
        </div>
        <label class="flex items-center justify-start p-3 gap-2 hover:bg-gray-200 cursor-pointer">
            <img src="{{ asset('/assets/file.svg') }}" class="w-5" />
            <p>New file</p>
            <input class="hidden" type="file" multiple wire:model="uploads" />
        </label>
    </div>

    @if ($openCreateFolderModal)
        <livewire:component.modal.create-folder :parentIsFolder="$parentIsAFolder" :parentId="$parentId" />
    @endif
</div>