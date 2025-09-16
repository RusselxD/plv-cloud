<?php

namespace App\Livewire\Component;

use Livewire\Component;

class FolderCard extends Component
{
    public $user;
    public $courseSlug;
    public $path;
    public $folder;
    public $totalContents = 0;

    public $openKebabMenu = false;
    public $openRenameModalIsOpen = false;

    protected $listeners = ['closeRenameModal' => 'closeRenameModal'];

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

    public function clickKebab(){
        $this->openKebabMenu = !$this->openKebabMenu;
    }

    public function closeRenameModal(){
        $this->openRenameModalIsOpen = false;
    }

    public function openRenameModal(){
        $this->openRenameModalIsOpen = true;
    }

    public function mount($folder, $courseSlug, $path = '')
    {
        $this->folder = $folder;
        $this->totalContents = $folder->files_count + $folder->children_count;

        $this->courseSlug = $courseSlug;
        $this->path = $path;

        $this->user = $folder->user;
    }

    public function render()
    {
        return view('livewire.component.folder-card');
    }
}
