<?php

namespace App\Livewire\Page;

use App\Models\Course;
use \App\Models\Folder as FolderModel;
use App\Models\FolderContributors;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Folder extends Component
{
    public $folder;
    public $course;

    public $search;

    public $isCreateFolderModalOpen = false;

    public $path;

    public $currentUserIsOwner = false;
    public $currentUserIsEligibleToUpload = false;

    protected $listeners = ['closeModalInFolder' => 'closeCreateFolderModal'];

    #[On('folder-created')]
    public function refreshFolders()
    {
        $this->render();
    }

    public function updatedSearch()
    {
        $this->render();
    }

    public function clickSearch()
    {
        $this->render();
    }

    public function goToFolder($folderSlug)
    {
        return redirect()
            ->to(route('folder', ['courseSlug' => $this->course->slug, 'path' => $this->path . '/' . $folderSlug]));
    }

    public function openCreateFolderModal()
    {
        if (!Auth::check()) {
            return redirect()->to(route('login'));
        }

        $this->isCreateFolderModalOpen = true;
    }

    public function closeCreateFolderModal()
    {
        $this->isCreateFolderModalOpen = false;
    }

    public function determineUserIsEligible()
    {
    }

    public function mount($courseSlug, $path)
    {
        $this->course = Course::where('slug', $courseSlug)->firstOrFail();

        // the string path: /course/folder1/folder2
        $this->path = $path;

        // assign folder based on last slug in path
        $slugs = explode('/', $path);
        $folderSlug = $slugs[array_key_last($slugs)];
        $folder = FolderModel::where('slug', $folderSlug)->firstOrFail();
        $this->folder = $folder;

        // determine if the current user is the owner of the folder
        $currentUser = Auth::user();
        if ($currentUser) {
            $this->currentUserIsOwner = $currentUser->id == $folder->user_id;
            $this->currentUserIsEligibleToUpload = $this->currentUserIsOwner;

        }

        // if the current user is signed in and is not the owner,
        // determine if the current user if eligible to upload (contributor / folder is public)     
        if ($currentUser && !$this->currentUserIsOwner) {
            $isAContributor = FolderContributors::where('folder_id', $this->folder->id)
                ->where('user_id', $currentUser->id)
                ->exists();
            $this->currentUserIsEligibleToUpload =
                $folder->is_public || $isAContributor;
        }
    }

    public function render()
    {
        $folders = FolderModel::with('user')
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

        return view('livewire.page.folder', ['folders' => $folders]);
    }
}
