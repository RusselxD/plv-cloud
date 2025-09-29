<div class="border border-gray-600 w-full rounded-lg cursor-pointer hover:shadow-md relative" wire:click="goToFolder">
    <div class="grid grid-cols-[0.5fr_2fr]">
        <!-- Folder Icon -->
        <div class="flex items-center justify-center aspect-square h-full border-r border-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="gray"
                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-icon lucide-folder">
                <path
                    d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z" />
            </svg>
        </div>

        <!-- Folder name + kebab -->
        <div class="flex items-start justify-between p-3 overflow-hidden">
            <div class="max-w-[80%]">
                <p class="font-semibold truncate w-full overflow-ellipsis">{{ $folder->name }}</p>
                <p class="text-slate-600 text-xs mt-1">{{ $totalContents }} contents</p>
            </div>
            <button class="p-2 cursor-pointer hover:bg-gray-200 rounded-full" wire:click.stop="clickKebab">
                <img src="{{ asset('/assets/kebab.svg') }}" class="w-4" />
            </button>
        </div>
    </div>

    <!-- Bottom -->
    <div class="flex items-center justify-between pr-2 border-t border-gray-600">
        <div class="flex items-center justify-start gap-2 group py-[0.40rem] px-2 relative group"
            wire:click.stop.self="goToProfile">
            <div class="w-5 h-5 bg-gray-500 rounded-full">
                <!-- Profile Picture -->
            </div>
            <p class="max-w-22 text-xs truncate group-hover:underline">{{ $folder->user->username }}</p>

            <!-- Profile Preview -->
            <div wire:click.stop class="hidden group-hover:block hover:block absolute top-[2.1rem] left-0 w-fit z-100">
                <x-ui.general.profile-preview-card :user="$user" />
            </div>
        </div>
    </div>

    <!-- Kebab Menu -->
    <div x-data="{ open: @entangle('openKebabMenu') }" class="absolute top-3 right-12">
        <div x-show="open" x-collapse @click.away="$wire.closeKebabMenu()"
            class="w-40 h-fit bg-white rounded-sm border overflow-hidden shadow-md text-sm">
            <div class="flex items-center justify-start hover:bg-gray-100 p-2 gap-3" wire:click.stop="openRenameModal">
                <img src="{{ asset('assets/edit.svg') }}" class="w-4" />
                <p>Rename</p>
            </div>
            <div class="flex items-center justify-start hover:bg-gray-100 p-2 gap-3"
                wire:click.stop="openConfirmDeleteModal">
                <img src="{{ asset('assets/delete.svg') }}" class="w-4" />
                <p>Delete</p>
            </div>
        </div>
    </div>

    <!-- Rename Modal -->
    @if($renameModalIsOpen)
        <div wire:click.stop="closeKebabMenu">
            <livewire:component.modal.rename-modal :targetId="$folder->id" :isAFolder="true" :oldName="$folder->name" />
        </div>
    @endif

    <!-- Confirm Delete Modal -->
    @if ($confirmDeleteModalIsOpen)
        <div wire:click.stop>
            <livewire:component.modal.confirm-delete-modal :targetId="$folder->id" :isAFolder="true" />
        </div>
    @endif
</div>