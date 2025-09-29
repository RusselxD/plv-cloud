<?php

namespace App\Livewire\Component;

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

    public function mount($folder)
    {
        $this->folder = $folder;
        $this->totalContents = $folder->files_count + $folder->children_count;

        $this->user = $folder->user;
    }

    public function render()
    {
        return view('livewire.component.folder-card');
    }
}