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
    #[On('close-rename-modal')] // from RenameModal
    public function refresh()
    {
        // $this->folder = Folder::withCount(['files', 'children'])
        //     ->findOrFail($this->folder->id);
        $this->render();
    }

    public $folderId;

    public function mount($uuid)
    {
        $this->folder = Folder::where('uuid', $uuid)
            ->firstOrFail();
        // $this->folderId = $folder->id;
        // $this->folder = Folder::withCount(['files', 'children'])
        //     ->findOrFail($folder->id);

        // dd( $this->folder );

        $this->userIsAContributor =
            $this->folder->user->id === auth()->id() ||
            $this->folder->folderContributors->contains('user_id', auth()->id());
    }

    public $children_count = 0;
    public $files_count = 0;

    public function render()
    {
        // $this->folder->load([
        //     'user:id,username,profile_picture',
        //     'folderContributors.user:id,username,profile_picture',
        //     'folderRequests.user:id,username,profile_picture',
        //     'folderLogs.user:id,username,profile_picture',
        // ]);

        // $this->children_count = $this->folder->children_count ?? 0;
        // $this->files_count = $this->folder->files_count ?? 0;
        $this->folder->load([
            'user:id,username,profile_picture',
            'folderContributors.user:id,username,profile_picture',
            'folderRequests.user:id,username,profile_picture',
            'folderLogs.user:id,username,profile_picture',
        ]);
        $this->folder->loadCount(['files', 'children']);

        return view('livewire.component.folder-details-pane', ['folder' => $this->folder]);
    }
}