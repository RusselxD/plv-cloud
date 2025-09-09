<?php

namespace App\Livewire\Component;

use App\Models\Folder;
use Livewire\Component;
use Symfony\Component\CssSelector\Node\FunctionNode;

class CreateFolder extends Component
{
    public $parentIsFolder = false;
    public $parentId;

    public $folderName = '';

    public function closeModal()
    {
        if ($this->parentIsFolder) {
            $this->dispatch('closeModalInFolder');
        } else {
            $this->dispatch('closeModalInCourse');
        }

    }

    public function createFolder()
    {
        // dd('hey');
        // dd($this->parentIsFolder, $this->parentId);

        $this->validate([
            'folderName' => 'required|string|min:3|max:255',
        ]);

        Folder::create([
            'name' => $this->folderName,
            'is_public' => false,
            'course_id' => $this->parentIsFolder ? null : $this->parentId,
            'user_id' => auth()->id(),
            'parent_id' => $this->parentIsFolder ? $this->parentId : null
        ]);

        session()->flash('success', 'Folder successfully created');
    }

    public function mount($parentId, $parentIsFolder)    
    {
        // dd($parentId, $parentIsFolder);
        $this->parentIsFolder = $parentIsFolder;
        $this->parentId = $parentId;
    }

    public function render()
    {
        return view('livewire.component.create-folder');
    }
}
