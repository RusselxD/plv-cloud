<div class="fixed inset-0 bg-black/20 flex justify-center items-center z-150" wire:click.self="closeModal">
    <div class="w-96 h-fit border-2 bg-white rounded p-4">
        <div class="flex justify-between items-center text-xl mb-3">
            <span>
                <span>Rename</span>
                @if ($isAFolder)
                    <span>folder</span>
                @else
                    <span>file</span>
                @endif
            </span>
            <img src="{{ asset('/assets/x.svg') }}" class="w-9 p-2 cursor-pointer hover:bg-gray-200 rounded-full"
                wire:click="closeModal" />
        </div>

        <form wire:submit.prevent="submitRename">
            <input type="text" wire:model="name" placeholder="New Name" value="$name"
                class="border border-gray-300 rounded p-2 w-full" id="folderInput" x-init="$el.focus()" />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <div class="flex items-center justify-end gap-2 text-sm mt-4">
                <button type="button" class="border-2 text-primary border-primary py-2 px-4 rounded-full transition-colors duration-100 ease-in-out
                            hover:bg-primary hover:text-white cursor-pointer" wire:click="closeModal">Cancel</button>
                <button type="submit" class="bg-primary text-white border-2 border-primary py-2 px-4 rounded-full cursor-pointer transition-colors duration-100 
                    ease-in-out hover:bg-primary/90">Rename</button>
            </div>
        </form>

    </div>
</div>