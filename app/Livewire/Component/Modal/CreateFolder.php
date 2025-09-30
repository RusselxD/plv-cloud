<?php

namespace App\Livewire\Component\Modal;

use App\Models\Course;
use App\Models\Folder;
use App\Models\FolderLog;
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

    public function logActivity($folderId)
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

        // Log the activity in the new folder's logs
        FolderLog::create([
            'folder_id' => $folderId,
            'user_id' => auth()->id(),
            'details' => 'created this folder.'
        ]);

        // Log the activity in the parent folder's logs if applicable
        if ($this->parentIsFolder) {
            FolderLog::create([
                'folder_id' => $this->parentId,
                'user_id' => auth()->id(),
                'details' => 'created folder "' . trim($this->folderName) . '"'
            ]);
        }
    }

    public function createFolder()
    {
        $this->validate();

        $newFolder = Folder::create([
            'name' => trim($this->folderName),
            'is_public' => false,
            'course_id' => $this->parentIsFolder ? null : $this->parentId,
            'user_id' => auth()->id(),
            'parent_id' => $this->parentIsFolder ? $this->parentId : null
        ]);

        $this->dispatch('folder-created'); // caught by Course or Folder and FolderDetailsPane

        $this->logActivity($newFolder->id);
                
        $this->dispatch('success_flash', message: 'Folder successfully created');
    }

    public function mount($parentId, $parentIsFolder)
    {
        $this->parentIsFolder = $parentIsFolder;
        $this->parentId = $parentId;
    }

    public function render()
    {
        return view('livewire.component.modal.create-folder');
    }
}
