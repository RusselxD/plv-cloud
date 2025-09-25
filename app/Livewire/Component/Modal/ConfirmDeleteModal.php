<?php

namespace App\Livewire\Component\Modal;

use App\Models\File;
use App\Models\Folder;
use Livewire\Component;

class ConfirmDeleteModal extends Component
{
    public $targetId;
    public $isAFolder;

    public function closeModal()
    {
        // caught by FolderCard and FileCard
        $this->dispatch('close-delete-modal');
    }

    public function confirmDeletion()
    {
        if ($this->isAFolder) {
            Folder::where('id', $this->targetId)->delete();            
            $this->dispatch('folder-deleted');
        } else {
            File::where('id', $this->targetId)->delete();            
            $this->dispatch('file-deleted');
        }

        $this->dispatch('success_flash', message: 'Deleted successfully');
    }

    public function mount($targetId, $isAFolder)
    {
        $this->targetId = $targetId;
        $this->isAFolder = $isAFolder;
    }

    public function render()
    {
        return view('livewire.component.modal.confirm-delete-modal');
    }
}
