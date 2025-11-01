<?php

namespace App\Livewire\Component;

use App\Models\Folder;
use App\Models\Save;
use App\Models\UserActivity;
use Livewire\Attributes\On;
use Livewire\Component;

class FolderCard extends Component
{
    public $user;

    public $folder;

    public $totalContents = 0;

    public $openKebabMenu = false;

    public $renameModalIsOpen = false;

    public $confirmDeleteModalIsOpen = false;

    public $reportModalIsOpen = false;

    public $currentUserCanModify = false;

    public $showBottom;

    public $isSaved;

    #[On('close-rename-modal')] // from RenameModal
    public function closeRenameModal()
    {
        $this->renameModalIsOpen = false;
        $this->openKebabMenu = false;
    }

    #[On('close-delete-modal')] // from ConfirmDeleteModal
    public function closeConfirmDeleteModal()
    {
        $this->confirmDeleteModalIsOpen = false;
        $this->openKebabMenu = false;
    }

    #[On('close-report-modal')] // from ReportModal
    public function closeReportModal()
    {
        $this->reportModalIsOpen = false;
        $this->openKebabMenu = false;
    }

    public function goToFolder()
    {
        return redirect()->to(route('folder', ['uuid' => $this->folder->uuid]));
    }

    public function goToProfile()
    {
        redirect()->to(route('user', ['username' => $this->folder->user->username]));
    }

    public function clickKebab()
    {
        $this->openKebabMenu = !$this->openKebabMenu;
    }

    public function closeKebabMenu()
    {
        $this->openKebabMenu = false;
    }

    public function openRenameModal()
    {
        $this->renameModalIsOpen = true;
    }

    public function openConfirmDeleteModal()
    {
        $this->confirmDeleteModalIsOpen = true;
    }

    public function openReportModal()
    {
        $this->reportModalIsOpen = true;
    }

    public function determineIfUserCanModify()
    {
        $currentUserId = auth()->id();

        if ($currentUserId === null) {
            $this->currentUserCanModify = false;
            return;
        }

        // early out if the current user is the owner of this folder
        if ($this->folder->user_id == $currentUserId) {
            $this->currentUserCanModify = true;
            return;
        }

        // dump($this->folder);
        if ($this->folder->course_id === null) {
            // this means that this folder is under a folder 

            $this->currentUserCanModify = $this->folder->folder->user_id == $currentUserId // owner of parent folder
                || $this->folder->folder->folderContributors->contains('user_id', $currentUserId); // contributor in parent folder
        }
    }

    public function downloadFolder()
    {
        // Dispatch event to trigger download via JavaScript
        $this->dispatch('trigger-folder-download', [
            'url' => route('folder.download', ['id' => $this->folder->id]),
            'foldername' => $this->folder->name
        ]);
    }

    public function saveFolder()
    {
        if (!auth()->check()) {
            return;
        }

        Save::create(
            ['user_id' => auth()->id(), 'folder_id' => $this->folder->id]
        );

        UserActivity::create([
            'user_id' => auth()->id(),
            'details' => "Saved folder: " . $this->folder->name
        ]);

        $this->dispatch('success_flash', message: 'Folder saved successfully.');
        $this->openKebabMenu = false;
        $this->isSaved = true;
    }

    public function unsaveFolder()
    {
        if (!auth()->check()) {
            return;
        }

        Save::where('user_id', auth()->id())
            ->where('folder_id', $this->folder->id)
            ->delete();

        UserActivity::create([
            'user_id' => auth()->id(),
            'details' => "Unsaved folder: " . $this->folder->name
        ]);

        $this->dispatch('unsave-folder'); // to Saved Page
        $this->dispatch('success_flash', message: 'Folder unsaved successfully.');
        $this->openKebabMenu = false;
        $this->isSaved = false;
    }



    public function mount($folder, $showBottom = true)
    {
        $this->showBottom = $showBottom;
        $this->folder = $folder;

        $this->totalContents = $this->folder->files_count + $this->folder->children_count;

        $this->user = $this->folder->user;

        $this->determineIfUserCanModify();

        $this->isSaved = Save::where('user_id', auth()->id())
            ->where('folder_id', $this->folder->id)
            ->exists();
    }

    public function render()
    {
        return view('livewire.component.folder-card');
    }
}