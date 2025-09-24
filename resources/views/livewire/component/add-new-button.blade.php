<div class="relative" x-data="{ openOptions: @entangle('openOptions') }">
    <div @click="openOptions = !openOptions"
        class="text-sm rounded-lg flex items-center justify-center gap-2 bg-blue-600 text-white py-2 pl-3 pr-4 cursor-pointer hover:bg-blue-700 transition-colors duration-100 ease-in-out">
        <img src="{{ asset('/assets/plus.svg') }}" />
        Add New
    </div>

    <div x-show="openOptions" @click.away="openOptions = false" x-collapse
        class="text-sm absolute bg-white right-0 top-full mt-1 rounded-md shadow-lg border border-gray-200 z-50 text-black w-44 whitespace-nowrap">

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

    <div wire:loading wire:target="files,updatedFiles"
        class="fixed inset-0 bg-black/10 flex justify-center items-center z-150">
        Uploading....
    </div>

    @if ($openCreateFolderModal)
        <livewire:component.create-folder :parentIsFolder="$parentIsAFolder" :parentId="$parentId" />
    @endif
</div>