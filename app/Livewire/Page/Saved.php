<?php

namespace App\Livewire\Page;

use App\Models\Save;
use Livewire\Attributes\On;
use Livewire\Component;

class Saved extends Component
{
    public $search;

    public $chosenCategory = 0;
    // 0 = All
    // 1 = Folders
    // 2 = Files

    public $saves;

    public $savedFolders = [];
    public $savedFiles = [];

    public $foldersCount = 0;
    public $filesCount = 0;

    public function submitSearch()
    {
    }

    public function changeCategory($categoryInt)
    {
        $this->chosenCategory = $categoryInt;
    }

    public function refreshAll()
    {
        $this->saves->load([
            'file',
            'folder'
        ]);

        $this->foldersCount = $this->saves->whereNotNull('folder')->count();
        $this->filesCount = $this->saves->whereNotNull('file')->count();

        $this->savedFolders = $this->saves->pluck('folder')->filter();
        $this->savedFiles = $this->saves->pluck('file')->filter();
    }

    #[On('unsave-folder')] // from FolderCard
    public function refreshFolders()
    {
        $this->saves->load([
            'folder'
        ]);

        $this->foldersCount = $this->saves->whereNotNull('folder')->count();
        $this->savedFolders = $this->saves->pluck('folder')->filter();
    }

    #[On('unsave-file')] // from FileCard
    public function refreshFiles()
    {
        $this->saves->load([
            'file'
        ]);

        $this->filesCount = $this->saves->whereNotNull('file')->count();
        $this->savedFiles = $this->saves->pluck('file')->filter();
    }

    public function mount()
    {
        $this->saves = Save::with([
            'folder' => function ($query) {
                $query->withCount(['children', 'files']);
            },
            'file'
        ])->where('user_id', auth()->id())->get();

        $this->foldersCount = $this->saves->whereNotNull('folder')->count();
        $this->filesCount = $this->saves->whereNotNull('file')->count();

        $this->savedFolders = $this->saves->pluck('folder')->filter();
        $this->savedFiles = $this->saves->pluck('file')->filter();
    }

    public function render()
    {
        return view('livewire.page.saved', );
    }
}