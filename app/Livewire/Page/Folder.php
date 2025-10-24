<?php

namespace App\Livewire\Page;

use App\Models\Course;
use App\Models\File;
use \App\Models\Folder as FolderModel;
use App\Models\FolderContributors;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Folder extends Component
{
    public $folder;

    public $search;

    public $breadcrumbs = [];

    public $createFolderModalIsOpen = false;

    public $renameModalIsOpen = false;

    public $currentUserIsOwner = false;

    public $currentUserIsEligibleToUpload = false;

    public $detailPanelIsOpen = false;

    #[On('folder-created')] // from CreateFolder
    #[On('file-created')] // from AddNewButton
    #[On('deleted')] // from ConfirmDeleteModal
    public function refresh()
    {
        $this->refreshContents();
    }

    public $folders;
    public $files;

    public function refreshContents(){
        $this->folders = FolderModel::with('user:id,username,profile_picture')
            ->when($this->search, function ($query) {

                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        // WHERE NAME LIKE %search%
    
                        ->orWhereHas('user', function ($q2) {
                            $q2->where('username', 'like', '%' . $this->search . '%');
                            // WHERE USERNAME LIKE %search%
                        });
                });
            })
            ->withCount(['files', 'children'])
            ->where('parent_id', $this->folder->id)
            ->get();

        $this->files = File::when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
                // WHERE NAME LIKE %search%
            })
            ->where('folder_id', $this->folder->id)
            ->get();
    }

    public function updatedSearch()
    {
        $this->render();
    }

    public function clickSearch()
    {
        $this->render();
    }

    public function clearSearch()
    {
        $this->search = '';        
    }

    public function openCreateFolderModal()
    {
        if (!Auth::check()) {
            return redirect()->to(route('login'));
        }

        $this->createFolderModalIsOpen = true;
    }

    public function closeCreateFolderModal()
    {
        $this->createFolderModalIsOpen = false;
    }

    #[On('close-rename-modal')] // from RenameModal
    public function closeRenameModal()
    {
        $this->renameModalIsOpen = false;
    }

    public function openRenameModal()
    {
        if(auth()->id() != $this->folder->user_id){
            return;
        }
        $this->renameModalIsOpen = true;
    }

    public function clickInfoIcon()
    {
        $this->detailPanelIsOpen = !$this->detailPanelIsOpen;
    }

    #[On('close-details-pane')] // from FolderDetailsPane
    public function closeDetailsPane()
    {
        $this->detailPanelIsOpen = false;
    }

    // build up the crumbs from folder to parent folder to course
    public function addFolderCrumbs()
    {
        $currentFolder = $this->folder;

        while ($currentFolder->folder) {
            array_unshift($this->breadcrumbs, ['name' => $currentFolder->name, 'url' => route('folder', ['uuid' => $currentFolder->uuid])]);
            $currentFolder = $currentFolder->folder;
        }
        array_unshift($this->breadcrumbs, ['name' => $currentFolder->name, 'url' => route('folder', ['uuid' => $currentFolder->uuid])]);
        $course = $currentFolder->course;
        array_unshift($this->breadcrumbs, ['name' => $course->abbreviation, 'url' => route('course', ['courseSlug' => $course->slug])]);
    }

    public function mount($uuid)
    {
        $this->folder = FolderModel::where('uuid', $uuid)->firstOrFail();

        // determine if the current user is the owner of the folder
        $currentUser = Auth::user();
        if ($currentUser) {
            $this->currentUserIsOwner = $currentUser->id == $this->folder->user_id;
            $this->currentUserIsEligibleToUpload = $this->currentUserIsOwner;
        }

        // if the current user is signed in and is not the owner,
        // determine if the current user if eligible to upload (contributor / folder is public)     
        if ($currentUser && !$this->currentUserIsOwner) {
            $isAContributor = FolderContributors::where('folder_id', $this->folder->id)
                ->where('user_id', $currentUser->id)
                ->exists();
            $this->currentUserIsEligibleToUpload =
                $this->folder->is_public || $isAContributor;
        }

        $this->addFolderCrumbs();
        $this->refreshContents();
    }    

    public function render()
    {
        $this->refreshContents();

        return view('livewire.page.folder');
    }
}
