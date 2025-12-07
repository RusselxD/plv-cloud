<?php

namespace App\Livewire\Component\Modal;

use App\Models\Course;
use App\Models\File;
use App\Models\Folder;
use App\Models\FolderLog;
use App\Models\UserActivity;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary as CloudinaryFacade;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ConfirmDeleteModal extends Component
{
    public $targetId;
    public $isAFolder;

    public function deleteFileFromCloudinary($cloudinaryUrl)
    {
        try {
            // Extract public_id from Cloudinary URL
            // URL format: https://res.cloudinary.com/{cloud_name}/image/upload/v{version}/{public_id}.{extension}
            $urlParts = parse_url($cloudinaryUrl);
            $path = $urlParts['path'] ?? '';
            
            // Extract public_id from path
            if (preg_match('/\/v\d+\/(.+)$/', $path, $matches)) {
                $publicIdWithExtension = $matches[1];
                // Remove extension
                $publicId = preg_replace('/\.[^.]+$/', '', $publicIdWithExtension);
                
                // Delete from Cloudinary
                CloudinaryFacade::uploadApi()->destroy($publicId);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to delete file from Cloudinary: ' . $e->getMessage());
        }
    }

    public function deleteFilesInFolder($folder)
    {
        // Delete all files in this folder
        foreach ($folder->files as $file) {
            $this->deleteFileFromCloudinary($file->storage_path);
        }

        // Recursively delete files in child folders
        foreach ($folder->children as $childFolder) {
            $childFolder->load(['files', 'children']);
            $this->deleteFilesInFolder($childFolder);
        }
    }

    public function closeModal()
    {
        // caught by FolderCard and FileCard
        $this->dispatch('close-delete-modal');
    }

    public function logAction($name, $parent, $parentType)
    {
        $parentName = $parentType == 'course' ? $parent->abbreviation : $parent->name;

        UserActivity::create([
            'user_id' => auth()->id(),
            'details' => 'Deleted ' . ($this->isAFolder ? 'folder "' : 'file "') . $name .
                '" in ' . $parentType . ' "' . $parentName . '"',
            // Deleted file Name in folder Name
            // Deleted folder Name in course ABBRV
        ]);

        if ($parentType == 'folder') {
            FolderLog::create([
                'folder_id' => $parent->id,
                'details' => 'deleted ' . ($this->isAFolder ? 'folder "' : 'file "') . $name . '"',
                'user_id' => auth()->id(),
                // "deleted folder "Name"
                // "deleted file "Name"
            ]);
        }
    }

    public function confirmDeletion()
    {
        $item = $this->isAFolder ?
            Folder::with(['folder', 'course', 'files', 'children'])->where('id', $this->targetId)->firstOrFail() :
            File::with(['folder', 'course'])->where('id', $this->targetId)->firstOrFail();

        $name = $item->name;        
        $parent = $item->folder == null
            ? Course::where('id', $item->course_id)->first()
            : (
                $this->isAFolder
                ? Folder::where('id', $item->parent_id)->first()
                : Folder::where('id', $item->folder_id)->first()
            );

        $parentType = $item->folder == null ? $parentType = 'course' : $parentType = 'folder';

        // Delete from Cloudinary before deleting from database
        if ($this->isAFolder) {
            // Delete all files in folder and subfolders from Cloudinary
            $this->deleteFilesInFolder($item);
        } else {
            // Delete single file from Cloudinary
            $this->deleteFileFromCloudinary($item->storage_path);
        }
        
        $item->delete();
        $this->logAction($name, $parent, $parentType);
        
        $this->dispatch('deleted'); // caught by Course or (Folder and FolderDetailsPane) or Home or Notifications
       
        $this->dispatch('success_flash', message: 'Deleted successfully');
        
    }

    public function mount($targetId, $isAFolder)
    {
        $this->targetId = $targetId;
        $this->isAFolder = $isAFolder;
    }

    public function render()
    {
        return view('livewire.component.modal.confirm-delete-modal');
    }
}
