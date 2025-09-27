<div class="fixed inset-0 bg-black/20 flex justify-center items-center z-150 cursor-auto" wire:click.self="closeModal"
    wire:keydown.enter="confirmDeletion" wire:keydown.escape="closeModal" tabindex="0" x-data x-init="$el.focus()">
    <div class="w-96 h-fit bg-white rounded-lg p-4 flex flex-col items-center relative">
        <img src="{{ asset('/assets/x.svg') }}" wire:click=closeModal
            class="absolute right-3 top-3 cursor-pointer hover:bg-gray-200 rounded-full p-2 w-9 transition-colors duration-100 ease-in-out" />
        <img src="{{ asset('/assets/delete-red.svg') }}" class="w-12 p-3 rounded-full bg-red-100 mb-3" />
        <h1 class="font-bold mb-2">Delete Confirmation</h1>
        <span class="text-sm text-gray-600">
            <span>Are you sure you want to delete this</span>
            @if ($isAFolder)
                <span>folder?</span>
            @else
                <span>file?</span>
            @endif
        </span>
        <div class="flex items-stretch justify-between w-full gap-3 mt-3 text-sm font-medium">
            <button wire:click="closeModal"
                class="transition-colors duration-100 ease-in-out hover:bg-gray-400 hover:text-white cursor-pointer border border-gray-400 w-full rounded-md py-2">Cancel</button>
            <button wire:click="confirmDeletion"
                class="transition-colors duration-100 ease-in-out hover:bg-red-500 cursor-pointer border text-white border-red-600 bg-red-600 w-full rounded-md py-2">Delete</button>
        </div>
    </div>
</div>