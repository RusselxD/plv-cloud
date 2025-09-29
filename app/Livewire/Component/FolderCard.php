<?php

namespace App\Livewire\Component;

use Livewire\Attributes\On;
use Livewire\Component;

class FolderCard extends Component
{
    public $user;
    public $courseSlug;
    public $path;
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
        // If path is empty (meaning this folder card is in the course), just go to the folder
        // Otherwise, append the folder slug to the existing path
        $urlPath = $this->path === '' ? $this->folder->slug : $this->path . '/' . $this->folder->slug;        

        return redirect()
            ->to(route('folder', ['courseSlug' => $this->courseSlug, 'path' => $urlPath]));
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

    public function mount($folder, $path = '', $courseSlug = '')
    {
        $this->folder = $folder;        
        $this->totalContents = $folder->files_count + $folder->children_count;
        
        $this->path = $path;

        $this->user = $folder->user;
    }

    public function render()
    {
        return view('livewire.component.folder-card');
    }
}