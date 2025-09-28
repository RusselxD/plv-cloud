<?php

namespace App\Livewire\Component;

use App\Models\Folder;
use Livewire\Component;

class FolderDetailsPane extends Component
{
    public $folder;
    public $userIsAContributor = false;

    public $contributorsTabIsActive = true;

    public function setOpenTabToContributors($state)
    {
        $this->contributorsTabIsActive = $state;
    }

    public function closeDetailsPane()
    {
        $this->dispatch('close-details-pane'); // caught by Folder
    }

    public function mount($folder)
    {
        $this->folder = Folder::with('user', 'folderContributors', 'folderRequests', 'folderLogs')->findOrFail($folder->id);

        $this->userIsAContributor =
            $this->folder->user->id === auth()->id() ||
            $this->folder->folderContributors->contains('user_id', auth()->id());
        
    }

    public function render()
    {
        return view('livewire.component.folder-details-pane');
    }
}