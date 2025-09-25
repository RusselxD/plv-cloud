<?php

namespace App\Livewire\Component\Modal;

use App\Models\File;
use App\Models\Folder;
use Livewire\Component;
use Illuminate\Validation\Rule;

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

    public function submitRename()
    {
        $this->validate();

        if ($this->isAFolder) {
            Folder::where('id', $this->targetId)->update(['name' => trim($this->name)]);
        } else {
            $file = File::where('id', $this->targetId)->firstOrFail();
            $file->update(['name' => $this->name . $this->getExtension($file->name)]);            
        }

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
