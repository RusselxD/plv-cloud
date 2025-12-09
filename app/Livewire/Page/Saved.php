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
        // Search is handled automatically by updatedSearch() via wire:model.live
    }

    public function updatedSearch()
    {
        $this->updateFilteredResults();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->updateFilteredResults();
    }

    public function changeCategory($categoryInt)
    {
        $this->chosenCategory = $categoryInt;
        $this->updateFilteredResults();
    }

    public function updateFilteredResults()
    {
        // Get all folders and files from saves
        $allFolders = $this->saves->pluck('folder')->filter();
        $allFiles = $this->saves->pluck('file')->filter();

        // Apply search filter if search term exists
        if (!empty(trim($this->search ?? ''))) {
            $searchTerm = strtolower(trim($this->search));
            
            $allFolders = $allFolders->filter(function ($folder) use ($searchTerm) {
                return $folder && stripos(strtolower($folder->name), $searchTerm) !== false;
            });

            $allFiles = $allFiles->filter(function ($file) use ($searchTerm) {
                return $file && stripos(strtolower($file->name), $searchTerm) !== false;
            });
        }

        // Apply category filter
        if ($this->chosenCategory == 1) {
            // Only folders
            $this->savedFolders = $allFolders;
            $this->savedFiles = collect([]);
            $this->foldersCount = $allFolders->count();
            $this->filesCount = 0;
        } elseif ($this->chosenCategory == 2) {
            // Only files
            $this->savedFolders = collect([]);
            $this->savedFiles = $allFiles;
            $this->foldersCount = 0;
            $this->filesCount = $allFiles->count();
        } else {
            // All
            $this->savedFolders = $allFolders;
            $this->savedFiles = $allFiles;
            $this->foldersCount = $allFolders->count();
            $this->filesCount = $allFiles->count();
        }
    }

    public function refreshAll()
    {
        $this->saves->load([
            'file',
            'folder'
        ]);

        $this->updateFilteredResults();
    }

    #[On('unsave-folder')] // from FolderCard
    public function refreshFolders()
    {
        $this->saves->load([
            'folder'
        ]);

        $this->updateFilteredResults();
    }

    #[On('unsave-file')] // from FileCard
    public function refreshFiles()
    {
        $this->saves->load([
            'file'
        ]);

        $this->updateFilteredResults();
    }

    public function mount()
    {
        $this->saves = Save::with([
            'folder' => function ($query) {
                $query->withCount(['children', 'files']);
            },
            'file'
        ])->where('user_id', auth()->id())->get();

        $this->updateFilteredResults();
    }

    public function render()
    {
        return view('livewire.page.saved', );
    }
}