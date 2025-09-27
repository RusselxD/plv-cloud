<?php

namespace App\Livewire\Component;

use App\Models\Course;
use App\Models\Folder;
use App\Models\UserActivity;
use Livewire\Component;
use Illuminate\Validation\Rule;

class CreateFolder extends Component
{
    public $parentIsFolder = false;
    public $parentId;

    public $folderName = '';

    public function closeModal()
    {
        $this->dispatch('close-folder-create-modal');
    }

    public function rules()
    {
        return [
            'folderName' => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('folders', 'name')->where(function ($query) {
                    if ($this->parentIsFolder) {
                        return $query->where('parent_id', $this->parentId);
                    } else {
                        return $query->where('course_id', $this->parentId);
                    }
                }),
            ],
        ];
    }

    protected $messages = [
        'folderName.required' => 'Please enter a name.',
        'folderName.string' => 'The name must be text.',
        'folderName.min' => 'The name must be at least 3 characters long.',
        'folderName.max' => 'The name may not be longer than 50 characters.',
        'folderName.unique' => 'A folder with this name already exists here.',
    ];

    public function logActivity()
    {
        $parentName = $this->parentIsFolder ?
            Folder::where('id', $this->parentId)->first()->name :
            Course::where('id', $this->parentId)->first()->abbreviation;

        // Created folder "name" inside folder/course "parent"
        UserActivity::create([
            'user_id' => auth()->id(),
            'details' => 'Created folder "' . trim($this->folderName) . '" in ' .
                ($this->parentIsFolder ? 'folder "' : 'course "') .
                $parentName . '"',
        ]);
    }

    public function createFolder()
    {
        $this->validate();        

        Folder::create([
            'name' => trim($this->folderName),
            'is_public' => false,
            'course_id' => $this->parentIsFolder ? null : $this->parentId,
            'user_id' => auth()->id(),
            'parent_id' => $this->parentIsFolder ? $this->parentId : null
        ]);

        $this->dispatch('folder-created');
        $this->dispatch('success_flash', message: 'Folder successfully created');

        $this->logActivity();
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
