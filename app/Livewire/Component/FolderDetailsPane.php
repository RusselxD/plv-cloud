<?php

namespace App\Livewire\Component;

use App\Models\Folder;
use Livewire\Attributes\On;
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

    #[On('folder-created')] // from CreateFolder
    #[On('file-created')] // from AddNewButton
    #[On('deleted')] // from ConfirmDeleteModal
    public function refresh()
    {
        $this->folder = Folder::with(
            'user:id,username,profile_picture',
            'folderContributors.user:id,username,profile_picture',
            'folderRequests.user:id,username,profile_picture',
            'folderLogs.user:id,username,profile_picture'
        )
            ->withCount(['files', 'children'])
            ->findOrFail($this->folder->id);
    }

    public function mount($folder)
    {
        $this->folder = Folder::with(
            'user:id,username,profile_picture',
            'folderContributors.user:id,username,profile_picture',
            'folderRequests.user:id,username,profile_picture',
            'folderLogs.user:id,username,profile_picture'
        )
            ->withCount(['files', 'children'])
            ->findOrFail($folder->id);

        $this->userIsAContributor =
            $this->folder->user->id === auth()->id() ||
            $this->folder->folderContributors->contains('user_id', auth()->id());
    }

    public function render()
    {
        return view('livewire.component.folder-details-pane');
    }
}