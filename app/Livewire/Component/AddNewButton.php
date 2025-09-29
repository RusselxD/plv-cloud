<?php

namespace App\Livewire\Component;

use App\Models\Course;
use App\Models\File;
use App\Models\Folder;
use App\Models\FolderLog;
use App\Models\UserActivity;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddNewButton extends Component
{
    use WithFileUploads;

    public $parentIsAFolder;
    public $parentId;
    public $openOptions = false;

    public $openCreateFolderModal = false;

    public $uploads;
    public $uploadProgress = 0;
    public $isUploading = false;
    public $uploadedFiles = [];

    // from CreateFolder
    #[On('folder-created')]
    #[On('close-folder-create-modal')]
    public function closeModal()
    {
        $this->openCreateFolderModal = false;
    }

    public function clickAddNew()
    {
        $this->openOptions = !$this->openOptions;
    }

    public function closeOptions()
    {
        $this->openOptions = false;
    }

    public function openNewFolder()
    {
        $this->openCreateFolderModal = true;
    }

    // Thank you copilot.
    public function humanizeFileSize($bytes, $decimals = 2)
    {
        if ($bytes === 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        // Calculate the correct factor using logarithm
        $factor = min(floor(log($bytes, 1024)), count($units) - 1);
        $value = $bytes / pow(1024, $factor);

        // Determine decimal places based on value size
        if ($value >= 100) {
            $decimals = 0; // 156 MB, not 156.00 MB
        } elseif ($value >= 10) {
            $decimals = 1; // 15.6 MB, not 15.60 MB
        } else {
            $decimals = 2; // 1.56 MB
        }

        // Show no decimals if the value is a whole number
        if (abs($value - round($value)) < 0.01) {
            $decimals = 0;
        }

        return number_format($value, $decimals) . ' ' . $units[$factor];
    }

    public function logFileUpload($name)
    {
        $parentName = $this->parentIsAFolder ?
            Folder::where('id', $this->parentId)->first()->name :
            Course::where('id', $this->parentId)->first()->abbreviation;

        // Log the file upload activity in UserActivity
        UserActivity::create([
            'user_id' => auth()->id(),
            'details' => 'Uploaded file "' . $name . '" in ' .
                ($this->parentIsAFolder ? 'folder "' : 'course "') . $parentName . '"',
        ]);

        if($this->parentIsAFolder){
            FolderLog::create([
                'folder_id' => $this->parentId,
                'user_id' => auth()->id(),
                'details' => "uploaded file \"{$name}\""
            ]);
        }
    }

    // automatically runs when user insert file/s
    public function updatedUploads()
    {
        // $this->validate([
        //     'uploads.*' => 'required|file|mimes:zip',
        // ]);

        foreach ($this->uploads as $file) {
            $path = $file->store('uploads', 'public');
            $mime = $file->getMimeType();
            $name = $file->getClientOriginalName();
            File::create([
                'name' => $name,
                'storage_path' => $path,
                'file_size' => $this->humanizeFileSize($file->getSize()),
                'mime_type' => $mime,
                'user_id' => auth()->id(),
                'folder_id' => $this->parentIsAFolder ? $this->parentId : null,
                'course_id' => $this->parentIsAFolder ? null : $this->parentId
            ]);
            $this->logFileUpload($name);
        }

        $this->dispatch('file-created'); // caught by Course or Folder and FolderDetailsPane
    }

    public function mount($parentIsAFolder, $parentId)
    {
        $this->parentIsAFolder = $parentIsAFolder;
        $this->parentId = $parentId;
    }

    public function render()
    {
        return view('livewire.component.add-new-button');
    }
}
