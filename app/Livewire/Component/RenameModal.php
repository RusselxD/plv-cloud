<?php

namespace App\Livewire\Component;

use App\Models\Folder;
use Livewire\Component;
use Illuminate\Validation\Rule;

class RenameModal extends Component
{

    public $name;

    public $id;
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

    public function submitRename()
    {
        $this->validate();
        
        if ($this->isAFolder){
            Folder::where('id', $this->id)->update(['name' => trim($this->name)]);
        } else {
            // for file
        }
        
        $this->closeModal();
        $this->dispatch('success_flash', message: 'Renamed successfully');
    }

    public function closeModal(){
        // caught by FolderCard
        $this->dispatch('close-rename-modal');
    }

    public function mount($isAFolder = true, $id){
        $this->isAFolder = $isAFolder;
        $this->id = $id;
    }

    public function render()
    {
        return view('livewire.component.rename-modal');
    }
}
