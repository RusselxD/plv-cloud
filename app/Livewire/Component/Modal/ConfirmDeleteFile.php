<?php

namespace App\Livewire\Component\Modal;

use App\Models\File;
use Livewire\Component;

class ConfirmDeleteFile extends Component
{
    public $fileId;

    public function closeModal()
    {
        // caught by FolderCard and FileCard
        $this->dispatch('close-delete-modal');
    }

    public function confirmDeletion()
    {
        File::where('id', $this->fileId)->delete();
        $this->dispatch('file-deleted');

        // $this->closeModal();

        $this->dispatch('success_flash', message: 'Deleted successfully');
    }

    public function mount($fileId)
    {
        $this->fileId = $fileId;
    }

    public function render()
    {
        return view('livewire.component.modal.confirm-delete-file');
    }
}
