<?php

namespace App\Livewire\Component;

use App\Models\File;
use Livewire\Attributes\On;
use Livewire\Component;

class FileCard extends Component
{

    public $file;
    public $icon;

    public $optionsAreOpen = false;

    public $renameModalIsOpen = false;
    public $confirmDeleteModalIsOpen = false;

    #[On('close-rename-modal')] // from RenameModal
    public function closeRenameModal()
    {
        $this->renameModalIsOpen = false;
        $this->optionsAreOpen = false;
    }

    #[On('close-delete-modal')] // from ConfirmDeleteModal
    public function closeConfirmDeleteModal()
    {
        $this->confirmDeleteModalIsOpen = false;
    }

    public function downloadFile()
    {
        File::where('id', $this->file->id)->update(['download_count' => $this->file->download_count + 1]);
        $this->dispatch('success_flash', message: 'File downloaded successfully');
        return response()->download(
            storage_path('app/public/' . $this->file->storage_path),
            $this->file->name  // Use the original filename
        );
    }

    public function clickKebab()
    {
        $this->optionsAreOpen = !$this->optionsAreOpen;
    }

    public function closeOptions()
    {
        $this->optionsAreOpen = false;
    }

    public function openRenameModal()
    {
        $this->renameModalIsOpen = true;
    }

    public function openConfirmDeleteModal()
    {
        $this->confirmDeleteModalIsOpen = true;
    }

    public function getFileIcon($mime)
    {
        $extension = pathinfo($this->file->name, PATHINFO_EXTENSION);
        return match (true) {

            // Archives
            str_contains($extension, 'zip'),
            str_contains($extension, 'rar'),
            str_contains($extension, '7z') => 'assets/file-icons/zip.svg',

            // str_contains($mime, 'zip'), str_contains($mime, 'rar'),
            // str_contains($mime, '7z'), str_contains($mime, 'tar'),
            // str_contains($mime, 'gz') => '/assets/file-icons/zip.svg',

            // Documents
            str_contains($mime, 'pdf') => '/assets/file-icons/pdf.svg',
            str_contains($mime, 'word') => '/assets/file-icons/docs.svg',
            str_contains($mime, 'excel'), str_contains($mime, 'spreadsheet') => '/assets/file-icons/excel.svg',
            str_contains($mime, 'powerpoint'), str_contains($mime, 'presentation') => '/assets/file-icons/ppt.svg',
            str_contains($mime, 'text') => '/assets/file-icons/txt-file.svg',
            str_contains($mime, 'csv') => '/assets/file-icons/csv.svg',
            str_contains($mime, 'rtf') => '/assets/file-icons/rtf.svg',
            str_contains($mime, 'markdown') => '/assets/file-icons/md.svg',

            // Images
            str_contains($mime, 'image/svg+xml') => '/assets/file-icons/svg.svg',
            str_contains($mime, 'image') => '/assets/file-icons/photo.svg',

            // Audio
            str_contains($mime, 'audio') => '/assets/file-icons/audio.svg',

            // Video
            str_contains($mime, 'video') => '/assets/file-icons/play.svg',

            // Code
            str_contains($mime, 'javascript'), str_contains($extension, 'js') => 'assets/file-icons/code.svg',
            str_contains($mime, 'json'), str_contains($extension, 'json') => 'assets/file-icons/code.svg',
            str_contains($mime, 'xml'), str_contains($extension, 'xml') => 'assets/file-icons/code.svg',
            str_contains($mime, 'html'), str_contains($extension, 'html') => 'assets/file-icons/code.svg',
            str_contains($mime, 'css'), str_contains($extension, 'css') => 'assets/file-icons/code.svg',
            str_contains($extension, 'php'), str_contains($extension, 'py'),
            str_contains($extension, 'java'), str_contains($extension, 'c'),
            str_contains($extension, 'cpp'), str_contains($extension, 'cs'),
            str_contains($extension, 'rb'), str_contains($extension, 'go'),
            str_contains($extension, 'sh'), str_contains($extension, 'ts'),
            str_contains($extension, 'sql'), str_contains($extension, 'swift'),
            str_contains($extension, 'kt') => 'assets/file-icons/code.svg',

            // Fallback
            default => '/assets/file-icons/file.svg'
        };
    }

    public function mount($file)
    {
        $this->file = $file;
        $this->icon = $this->getFileIcon($file->mime_type);
    }

    public function render()
    {
        // Check if the file still exists in the database before rendering
        if (!File::where('id', $this->file->id)->exists()) {
            // File has been deleted, return empty view to avoid errors
            return '<div style="display: none;"></div>';
        }

        return view('livewire.component.file-card');
    }
}