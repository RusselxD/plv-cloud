<?php

namespace App\Livewire\Component;

use App\Models\Folder;
use Livewire\Component;
use Illuminate\Validation\Rule;

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

    public function rules()
    {
        return [
            'folderName' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('folders', 'name')->where(function ($query) {
                    return $query->where('parent_id', $this->parentId)
                        ->orWhere('course_id', $this->parentId);
                }),
            ],
        ];
    }

    protected $messages = [
        'folderName.unique' => 'A folder with this name already exists here.',
    ];

    public function createFolder()
    {
        $this->validate();

        Folder::create([
            'name' => $this->folderName,
            'is_public' => false,
            'course_id' => $this->parentIsFolder ? null : $this->parentId,
            'user_id' => auth()->id(),
            'parent_id' => $this->parentIsFolder ? $this->parentId : null
        ]);

        $this->closeModal();

        $this->dispatch('success_flash', message: 'Folder successfully created');
    }

    public function mount($parentId, $parentIsFolder)
    {
        $this->parentIsFolder = $parentIsFolder;
        $this->parentId = $parentId;
    }

    public function render()
    {
        return view('livewire.component.create-folder');
    }
}
