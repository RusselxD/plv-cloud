<?php

namespace App\Livewire\Component\Modal;

use App\Models\File;
use App\Models\Folder;
use App\Models\FolderLog;
use App\Models\UserActivity;
use Livewire\Component;

class RenameModal extends Component
{
    public $name;

    public $targetId;

    public $isAFolder;

    protected $messages = [
        'name.required' => 'Please enter a name.',
        'name.string' => 'The name must be text.',
        'name.min' => 'The name must be at least 3 characters long.',
        'name.max' => 'The name may not be longer than 255 characters.',
    ];

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
        ];
    }

    public function getExtension($fileName)
    {
        $res = "";
        for ($i = strlen($fileName) - 1; $i >= 0; $i--) {
            $char = $fileName[$i];
            $res .= $char;
            if ($char == ".") {
                break;
            }
        }
        return strrev($res);
    }

    public function logAction($oldName, $item)
    {
        $parent = $item->folder == null ? $parent = $item->course->abbreviation : $parent = $item->folder->name;
        $parentType = $item->folder == null ? $parentType = 'course' : $parentType = 'folder';

        UserActivity::create([
            'user_id' => auth()->id(),
            'details' => 'Renamed ' . ($this->isAFolder ? 'folder "' : 'file "')
                . $oldName . '" to "' . ($this->isAFolder ? $this->name : $this->name . $this->getExtension($oldName))
                . '" in ' . $parentType . ' ' . $parent,
            // Renamed folder "Old Name" to "New Name" in folder/course "Parent Name"
        ]);

        // Log the action in the item's own log if it's a folder
        if ($this->isAFolder) {
            FolderLog::create([
                'folder_id' => $this->targetId,
                'user_id' => auth()->id(),
                'details' => "renamed this folder from \"{$oldName}\" to \"{$this->name}\""
            ]);
        }

        // Log the activity in the parent folder's logs if applicable
        if ($item->folder != null) {
            FolderLog::create([
                'folder_id' => $item->folder->id,
                'user_id' => auth()->id(),
                'details' => 'renamed ' . ($this->isAFolder ? 'folder "' : 'file "')
                    . $oldName . '" to "' . ($this->isAFolder ? $this->name : $this->name . $this->getExtension($oldName)) . '"',
                // renamed folder "Old Name" to "New Name"
            ]);
        }
    }

    public function submitRename()
    {
        $this->validate();

        $item = $this->isAFolder
            ? Folder::with(['folder', 'course'])->findOrFail($this->targetId)
            : File::with(['folder', 'course'])->findOrFail($this->targetId);

        $oldName = $item->name;

        // Early exit if no change
        if ($this->isAFolder && $oldName === trim($this->name)) {
            $this->closeModal();
            return;
        }
        if (!$this->isAFolder && $oldName === $this->name . $this->getExtension($oldName)) {
            $this->closeModal();
            return;
        }

        // Generate unique name
        $newName = $this->isAFolder
            ? $this->generateUniqueFolderName($item, trim($this->name))
            : $this->generateUniqueFileName($item, trim($this->name), $this->getExtension($oldName));

        $item->update(['name' => $newName]);

        $this->logAction($oldName, $item);
        $this->closeModal();
        $this->dispatch('success_flash', message: 'Renamed successfully');
    }

    // thank you chatgpt
    protected function generateUniqueFileName($file, $baseName, $extension)
    {
        $counter = 0;
        $newName = $baseName . $extension;

        while (
            File::where(function ($q) use ($file) {
                $file->folder_id
                    ? $q->where('folder_id', $file->folder_id)
                    : $q->where('course_id', $file->course_id);
            })
                ->where('name', $newName)
                ->where('id', '!=', $file->id)
                ->exists()
        ) {
            $counter++;
            $newName = "{$baseName} ({$counter}){$extension}";
        }

        return $newName;
    }

    // thank you chatgpt
    protected function generateUniqueFolderName($folder, $baseName)
    {
        $counter = 0;
        $newName = $baseName;

        while (
            Folder::where(function ($q) use ($folder) {
                $folder->parent_id
                    ? $q->where('parent_id', $folder->parent_id)
                    : $q->where('course_id', $folder->course_id);
            })
                ->where('name', $newName)
                ->where('id', '!=', $folder->id)
                ->exists()
        ) {
            $counter++;
            $newName = $baseName . " ($counter)";
        }

        return $newName;
    }

    public function closeModal()
    {
        $this->dispatch('close-rename-modal'); // to FolderCard, FileCard, and Folder
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