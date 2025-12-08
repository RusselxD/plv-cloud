<?php

namespace App\Livewire\Component;

use App\Models\Course;
use App\Models\File;
use App\Models\Folder;
use App\Models\FolderContributors;
use App\Models\FolderLog;
use App\Models\UserActivity;
use Cloudinary\Cloudinary;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary as CloudinaryFacade;
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
        $this->openOptions = false;
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

    public function getUniqueFileName($originalName)
    {
        // Build query to check for existing files in the same location
        $query = File::query();
        
        if ($this->parentIsAFolder) {
            $query->where('folder_id', $this->parentId);
        } else {
            $query->where('course_id', $this->parentId);
        }

        // Check if file with this name exists
        $existingFile = $query->where('name', $originalName)->exists();
        
        if (!$existingFile) {
            return $originalName;
        }

        // Parse filename and extension
        $pathInfo = pathinfo($originalName);
        $filename = $pathInfo['filename'];
        $extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';

        // Get all existing files with similar names
        $existingNames = File::query()
            ->when($this->parentIsAFolder, function($q) {
                $q->where('folder_id', $this->parentId);
            }, function($q) {
                $q->where('course_id', $this->parentId);
            })
            ->where('name', 'like', $filename . '%' . $extension)
            ->pluck('name')
            ->toArray();

        // Find the highest number suffix
        $counter = 1;
        $newName = $filename . " ({$counter})" . $extension;
        
        while (in_array($newName, $existingNames)) {
            $counter++;
            $newName = $filename . " ({$counter})" . $extension;
        }

        return $newName;
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

        if ($this->parentIsAFolder) {
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
        \Log::info('Upload started', [
            'user_id' => auth()->id(),
            'file_count' => count($this->uploads ?? []),
            'parent_is_folder' => $this->parentIsAFolder,
            'parent_id' => $this->parentId
        ]);

        if (!$this->uploads || count($this->uploads) === 0) {
            \Log::warning('No uploads received');
            $this->dispatch('error_flash', message: 'No files selected.');
            $this->openOptions = false;
            return;
        }

        // Check file size manually before validation
        foreach ($this->uploads as $index => $file) {
            \Log::info("Checking file {$index}", [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType()
            ]);

            $fileSizeInKB = $file->getSize() / 1024;
            if ($fileSizeInKB > 10240) {
                \Log::error("File too large: {$file->getClientOriginalName()}", [
                    'size_kb' => $fileSizeInKB
                ]);
                $this->dispatch('error_flash', message: 'Each file upload must not exceed 10MB.');                
                $this->reset('uploads');
                $this->openOptions = false;
                return;
            }
        }

        try {
            \Log::info('Starting validation');
            $this->validate([
                'uploads.*' => 'file|max:10240', // 10MB max per file
            ]);
            \Log::info('Validation passed');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', [
                'errors' => $e->errors(),
                'message' => $e->getMessage()
            ]);
            $this->dispatch('error_flash', message: 'File upload failed. Please ensure files are under 10MB.');
            $this->reset('uploads');
            $this->openOptions = false;
            return;
        }

        foreach ($this->uploads as $index => $file) {
            try {
                \Log::info("Starting Cloudinary upload for file {$index}", [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'pathname' => $file->getPathname(),
                    'real_path' => $file->getRealPath()
                ]);
                
                // Use getPathname() which is more reliable than getRealPath() for Livewire temp files
                // Try multiple methods to get the file path
                $filePath = $file->getRealPath() ?: $file->getPathname();
                
                // Verify file exists and is readable
                if (!file_exists($filePath) || !is_readable($filePath)) {
                    \Log::error("File path not accessible", [
                        'path' => $filePath,
                        'real_path' => $file->getRealPath(),
                        'pathname' => $file->getPathname(),
                        'exists' => file_exists($filePath),
                        'readable' => is_readable($filePath),
                        'temp_dir' => sys_get_temp_dir(),
                        'storage_path' => storage_path()
                    ]);
                    throw new \Exception("File is not accessible. Please try uploading again.");
                }
                
                // Upload to Cloudinary using the file path
                // Set access_mode to 'public' so files are downloadable by everyone
                $result = CloudinaryFacade::uploadApi()->upload($filePath, [
                    'folder' => 'plv-cloud-uploads',
                    'resource_type' => 'auto',
                    'access_mode' => 'public'
                ]);
                $url = $result['secure_url'];
                \Log::info("Cloudinary upload successful for file {$index}", [
                    'url' => $url
                ]);
            } catch (\Exception $e) {
                \Log::error('Cloudinary upload error: ' . $e->getMessage(), [
                    'file' => $file->getClientOriginalName(),
                    'pathname' => $file->getPathname(),
                    'trace' => $e->getTraceAsString()
                ]);
                $this->dispatch('error_flash', message: 'Failed to upload file: ' . $e->getMessage());
                $this->reset('uploads');
                $this->openOptions = false;
                return;
            }

            $mime = $file->getMimeType();
            $originalName = $file->getClientOriginalName();
            
            // Get unique filename if duplicate exists
            $uniqueName = $this->getUniqueFileName($originalName);
            
            \Log::info('Creating file record in database', [
                'name' => $uniqueName,
                'size' => $this->humanizeFileSize($file->getSize())
            ]);

            File::create([
                'name' => $uniqueName,
                'storage_path' => $url,
                'file_size' => $this->humanizeFileSize($file->getSize()),
                'mime_type' => $mime,
                'user_id' => auth()->id(),
                'folder_id' => $this->parentIsAFolder ? $this->parentId : null,
                'course_id' => $this->parentIsAFolder ? null : $this->parentId
            ]);
            $this->logFileUpload($uniqueName);
        }

        // If files are uploaded to a public folder, add the current user as a contributor if not already
        if ($this->parentIsAFolder) {
            $folder = Folder::find($this->parentId);
            
            if ($folder && $folder->is_public) {
                $isOwner = $folder->user_id === auth()->id();
                $isAlreadyContributor = FolderContributors::where('folder_id', $this->parentId)
                    ->where('user_id', auth()->id())
                    ->exists();
                
                // Add user as contributor if they're not the owner and not already a contributor
                if (!$isOwner && !$isAlreadyContributor) {
                    FolderContributors::create([
                        'folder_id' => $this->parentId,
                        'user_id' => auth()->id(),
                        'created_at' => now()
                    ]);
                }
            }
        }

        \Log::info('Upload completed successfully', [
            'file_count' => count($this->uploads ?? [])
        ]);

        $this->dispatch('file-created'); // caught by Course or Folder and FolderDetailsPane
        $this->dispatch('success_flash', message: 'File/s uploaded successfully.');
        $this->reset('uploads');
        $this->openOptions = false;
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
