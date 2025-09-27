<?php

namespace App\Livewire\Component\Modal;

use App\Models\File;
use App\Models\Folder;
use App\Models\UserActivity;
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

    public function logAction($name, $parentName, $parentType)
    {
        UserActivity::create([
            'user_id' => auth()->id(),
            'details' => 'Deleted ' . ($this->isAFolder ? 'folder "' : 'file "') . $name .
                '" in ' . $parentType . ' "' . $parentName . '"',
            // Deleted file Name in folder Name
            // Deleted folder Name in course ABBRV
        ]);
    }

    public function confirmDeletion()
    {
        $item = $this->isAFolder ?
            Folder::with(['folder', 'course'])->where('id', $this->targetId)->firstOrFail() :
            File::with(['folder', 'course'])->where('id', $this->targetId)->firstOrFail();

        $name = $item->name;
        $parentName = $item->folder == null ? $parentName = $item->course->abbreviation : $parentName = $item->folder->name;
        $parentType = $item->folder == null ? $parentType = 'course' : $parentType = 'folder';

        $item->delete();
        $this->logAction($name, $parentName, $parentType);

        $this->dispatch('deleted'); //caught by Course or Folder
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
