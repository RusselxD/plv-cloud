<?php

namespace App\Livewire\Page;

use \App\Models\Folder as FolderModel;
use Livewire\Component;

class Folder extends Component
{
    // public $folder;

    // public function mount($abbrv, FolderModel $folder){
    //     $this->folder = $folder;
    // }

    public function render()
    {
        return view('livewire.page.folder');
    }
}
