<?php

namespace App\Livewire\Component\Modal;

use App\Models\File;
use App\Models\Folder;
use App\Models\UserActivity;
use Livewire\Component;

class RenameModal extends Component
{

    public $name;

    public $targetId;

    public $isAFolder;

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                // Rule::unique('folders', 'name')->where(function ($query) {
                //     return $query->where('parent_id', $this->parentId)
                //         ->orWhere('course_id', $this->parentId);
                // }),
            ],
        ];
    }

    protected $messages = [
        'name.required' => 'Please enter a name.',
        'name.string' => 'The name must be text.',
        'name.min' => 'The name must be at least 3 characters long.',
        'name.max' => 'The name may not be longer than 255 characters.',
        'name.unique' => 'Name already exists here',
    ];

    public function getExtension($fileName)
    {
        $res = "";
        for ($i = strlen($fileName) - 1; $i >= 0; $i--) {
            $char = $fileName[$i];
            $res = $res . $char;
            if ($char == ".") {
                break;
            }
        }
        return strrev($res);
    }

    public function logAction($oldName)
    {
        UserActivity::create([
            'user_id' => auth()->id(),
            'details' => 'Renamed ' . ($this->isAFolder ? 'folder "' : 'file "')
                . $oldName . '" to "' . ($this->isAFolder ? $this->name : $this->name . $this->getExtension($oldName)) . '". ID: ' . $this->targetId,
            // Renamed folder "OldName" to "NewName". ID: 1
            // Renamed file "OldName.txt" to "NewName.txt". ID: 1
        ]);
    }

    public function submitRename()
    {
        $this->validate();

        $oldName = '';

        $item = $this->isAFolder ? Folder::where('id', $this->targetId)->firstOrFail() :
            File::where('id', $this->targetId)->firstOrFail();

        $oldName = $item->name;

        // if name is same as old name, close modal and return
        if ($oldName == trim($this->name) || (!$this->isAFolder && $oldName == $this->name . $this->getExtension($oldName))) {
            $this->closeModal();
            return;
        }

        $item->update(['name' => $this->isAFolder ? trim($this->name) : trim($this->name) . $this->getExtension($oldName)]);

        $this->logAction($oldName);
        $this->closeModal();
        $this->dispatch('success_flash', message: 'Renamed successfully');
    }

    public function closeModal()
    {
        // caught by FolderCard
        $this->dispatch('close-rename-modal');
    }

    public function mount($isAFolder = true, $targetId, $oldName)
    {
        $this->isAFolder = $isAFolder;
        $this->targetId = $targetId;
        $this->name = $isAFolder ? $oldName : str_replace($this->getExtension($oldName), '', $oldName);
    }

    public function render()
    {
        return view('livewire.component.modal.rename-modal');
    }
}