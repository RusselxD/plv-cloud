<?php

namespace App\Livewire\Page;

use App\Models\Course;
use \App\Models\Folder as FolderModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Folder extends Component
{
    public $folder;
    public $course;

    public $search;    

    public $isCreateFolderModalOpen = false;

    public $path;

    protected $listeners = ['closeModalInFolder' => 'closeCreateFolderModal'];

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

    // bac/foldera
    // path = foldera
    // foldera

    public function mount($courseSlug, $path)
    {        
        $this->course = Course::where('slug', $courseSlug)->firstOrFail();

        // the string path: /course/folder1/folder2
        $this->path = $path;

        // $folderSlug = end(explode('/', $path));
        $slugs = explode('/', $path);
        $folderSlug = $slugs[array_key_last($slugs)];
        $this->folder = FolderModel::where('slug', $folderSlug)->firstOrFail();        
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
