<div class="fixed inset-0 bg-black/10 flex justify-center items-center z-150" wire:click.self="closeModal">
    <div class="w-96 h-fit border-2 bg-white rounded p-4 relative">
        <div class="flex justify-between items-center text-xl mb-3">
            <h1>New Folder</h1>
            <img src="{{ asset('/assets/x.svg') }}" class="w-9 p-2 cursor-pointer hover:bg-gray-200 rounded-full"
                wire:click="closeModal" />
        </div>

        <form wire:submit.prevent="createFolder">
            <input type="text" wire:model="folderName" placeholder="Folder Name"
                class="border border-gray-300 rounded p-2 w-full" id="folderInput" x-init="$el.focus()" />
            @error('folderName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <div class="flex items-center justify-end gap-2 text-sm mt-4">
                <button type="button" class="border-2 text-primary border-primary py-2 px-4 rounded-full transition-colors duration-100 ease-in-out
                            hover:bg-primary hover:text-white cursor-pointer" wire:click="closeModal">Cancel</button>
                <button type="submit" class="bg-primary text-white border-2 border-primary py-2 px-4 rounded-full cursor-pointer transition-colors duration-100 
                    ease-in-out hover:bg-primary/90">Create</button>
            </div>
        </form>

        <div class="absolute inset-0 bg-black/20" wire:loading wire:target="createFolder">
            <x-ui.general.spinner />
        </div>
    </div>
</div>