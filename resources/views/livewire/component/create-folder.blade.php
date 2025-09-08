<div class="fixed inset-0 bg-black/10 flex justify-center items-center" wire:click.self="closeModalFromCourse">
    <div class="w-96 h-44 border-2 bg-white rounded p-4">
        <h1 class="text-xl mb-3">New Folder</h1>
        <form wire:submit.prevent="createFolder">
            <input type="text" wire:model="folderName" placeholder="Folder Name"
                class="border border-gray-300 rounded p-2 w-full" />
            <div class="flex items-center justify-end">
                <button type="button" class="mr-2" wire:click="closeModalFromCourse">Cancel</button>
                <button type="submit">Create</button>
            </div>

        </form>
    </div>
</div>