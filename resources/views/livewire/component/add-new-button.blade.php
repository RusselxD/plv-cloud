<div class="relative" x-data="{ openOptions: @entangle('openOptions') }">
    <div @click="openOptions = !openOptions"
        class="text-sm rounded-lg flex items-center justify-center gap-2 whitespace-nowrap flex-1 bg-blue-600 text-white py-2 pl-3 pr-4 cursor-pointer hover:bg-blue-700 transition-colors duration-100 ease-in-out">
        <img src="{{ asset('/assets/plus.svg') }}" />
        Add New
    </div>

    <div x-show="openOptions" @click.away="openOptions = false" x-collapse x-cloak
        class="text-sm absolute bg-white right-0 top-full mt-1 rounded-md shadow-lg border border-gray-200 z-50 text-black w-44 whitespace-nowrap">

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

    <!-- Loading indicator for file uploads -->
    <!-- <div wire:loading wire:target="uploads" class="fixed inset-0 bg-black/50 flex justify-center items-center z-[999]">
        <div class="bg-white rounded-lg p-6 shadow-xl flex flex-col items-center gap-4">
            <x-ui.general.spinner/>
            <p class="text-lg font-semibold text-gray-800">Uploading files...</p>
            <p class="text-sm text-gray-600">Please wait while your files are being uploaded</p>
        </div>
    </div> -->

    @if ($openCreateFolderModal)
        <livewire:component.modal.create-folder :parentIsFolder="$parentIsAFolder" :parentId="$parentId" />
    @endif
</div>