<div class="border border-gray-300 rounded-lg flex items-center justify-center px-3 py-3 relative">
    <img class="w-7 mr-3" src="{{ asset($icon) }}" />

    <div class="flex items-center justify-between flex-1 overflow-hidden">
        <div class="flex flex-col max-w-[80%] overflow-hidden gap">
            <p class="text-sm font-medium truncate">{{ $file->name }}</p>
            <span class="text-xs text-gray-600">
                <span>{{ $file->file_size }}</span>
                <span>&middot;</span>
                <span>{{ $file->download_count }}</span>
                @if ($file->download_count == 1)
                    <span>download</span>
                @else
                    <span>downloads</span>
                @endif
            </span>
        </div>
        <img src="{{ asset('assets/kebab.svg') }}" wire:click="clickKebab"
            class="w-8 rounded-full p-2 transition-colors cursor-pointer duration-100 ease-in-out hover:bg-gray-200" />
    </div>

    <div x-data="{ open: @entangle('optionsAreOpen') }" class="absolute bottom-4 right-12">
        <div x-show="open" x-collapse @click.away="$wire.closeOptions()" x-cloak
            class="w-40 bg-white rounded-sm border overflow-hidden shadow-md text-sm">
            <div class="hover:bg-gray-100 bg-white py-2 px-2 gap-3 flex items-center justify-start cursor-pointer"
                wire:click="downloadFile">
                <img src="{{ asset('/assets/download.svg') }}" class="w-4" />
                <p>Download</p>
            </div>
            <div class="hover:bg-gray-100 bg-white py-2 px-2 gap-3 flex items-center justify-start cursor-pointer">
                <img src="{{ asset('/assets/details.svg') }}" class="w-4" />
                <p>Details</p>
            </div>
            <div class="hover:bg-gray-100 bg-white py-2 px-2 gap-3 flex items-center justify-start cursor-pointer">
                <img src="{{ asset('/assets/report.svg') }}" class="w-4" />
                <p>Report</p>
            </div>
            <div class="hover:bg-gray-100 bg-white py-2 px-2 gap-3 flex items-center justify-start cursor-pointer"
            wire:click="openRenameModal">
                <img src="{{ asset('/assets/edit.svg') }}" class="w-4" />
                <p>Rename</p>
            </div>
            <div class="hover:bg-gray-100 bg-white py-2 px-2 gap-3 flex items-center justify-start cursor-pointer"
                wire:click="openConfirmDeleteModal">
                <img src="{{ asset('/assets/delete.svg') }}" class="w-4" />
                <p>Delete</p>
            </div>
        </div>
    </div>

    <!-- Rename Modal -->
    @if ($renameModalIsOpen)
        <div wire:click.stop>
            <livewire:component.modal.rename-modal :targetId="$file->id" :isAFolder="false" :oldName="$file->name"/>
        </div>
    @endif

    <!-- Confirm Delete Modal -->
    @if ($confirmDeleteModalIsOpen)
        <div wire:click.stop>
            <livewire:component.modal.confirm-delete-modal :targetId="$file->id" :isAFolder="false" />
        </div>
    @endif
</div>