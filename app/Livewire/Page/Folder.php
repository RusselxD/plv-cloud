<?php

namespace App\Livewire\Page;

use App\Models\Course;
use \App\Models\Folder as FolderModel;
use Livewire\Component;

class Folder extends Component
{
    public $folder;
    public $course;

    public function mount($courseSlug, $folderSlug)
    {
        $this->course = Course::where('slug', $courseSlug)->firstOrFail();
        $this->folder = FolderModel::where('slug', $folderSlug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.page.folder');
    }
}
