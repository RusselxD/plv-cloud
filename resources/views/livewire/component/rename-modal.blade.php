<div class="fixed inset-0 bg-black/15 flex justify-center items-center z-100 cursor-auto" wire:click.self="closeModal">
    <div class="w-96 h-44 border-2 bg-white rounded p-4">
        <h1 class="text-xl mb-3">Rename</h1>
        <form wire:submit.prevent="submitRename">
            <input type="text" wire:model="name" placeholder="New Name"
                class="border border-gray-300 rounded p-2 w-full" x-init="$el.focus()" />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <div class="flex items-center justify-end">
                <button type="button" class="mr-2" wire:click="closeModal">Cancel</button>
                <button type="submit">Ok</button>
            </div>
        </form>

    </div>
</div>