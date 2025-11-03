<?php

namespace App\Livewire\Page;

use App\Models\File;
use App\Models\Folder;
use Livewire\Attributes\On;
use Livewire\Component;

class Home extends Component
{
    public $highlightFiles = [];

    public $highlightFolders = [];

    #[On('deleted')] // from ConfirmDeleteModal
    public function refresh()
    {
        $this->refreshContents();
    }

    public function refreshContents()
    {
        $this->highlightFiles = File::orderBy('download_count', 'desc')
            ->limit(5)
            ->get();

        $this->highlightFolders = Folder::withCount(['children', 'files'])
            ->orderByRaw('(children_count + files_count) DESC')
            ->limit(5)
            ->get();
    }

    public function mount()
    {
        $this->refreshContents();   
    }

    public function render()
    {
        return view('livewire.page.home');
    }
}