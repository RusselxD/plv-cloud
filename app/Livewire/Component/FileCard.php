<?php

namespace App\Livewire\Component;

use App\Models\File;
use App\Models\FolderContributors;
use App\Models\Save;
use App\Models\UserActivity;
use Livewire\Attributes\On;
use Livewire\Component;

class FileCard extends Component
{

    public $file;
    public $icon;

    public $optionsAreOpen = false;

    public $renameModalIsOpen = false;

    public $confirmDeleteModalIsOpen = false;

    public $reportModalIsOpen = false;

    public $currentUserCanModify = false;

    public $isSaved;

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
        $this->optionsAreOpen = false;
    }

    #[On('close-report-modal')] // from ReportModal
    public function closeReportModal()
    {
        $this->reportModalIsOpen = false;
        $this->optionsAreOpen = false;
    }

    public function downloadFile()
    {
        // Update the download count in the database
        File::where('id', $this->file->id)->update(['download_count' => $this->file->download_count + 1]);

        // Reload the file to get the updated download_count
        $this->file = File::find($this->file->id);

        // Dispatch event to trigger download via JavaScript
        $this->dispatch('trigger-download', [
            'url' => route('file.download', ['id' => $this->file->id]),
            'filename' => $this->file->name
        ]);

        $this->dispatch('success_flash', message: 'File download started.');
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

    public function openReportModal()
    {
        $this->reportModalIsOpen = true;
    }

    public function determineIfUserCanModify()
    {
        if ($this->file->course_id == null) {

            $contributors = $this->file->folder->folderContributors->pluck('user_id')->toArray();

            $this->currentUserCanModify = in_array(auth()->id(), $contributors) || auth()->id() == $this->file->folder->user_id;
        } else {
            $this->currentUserCanModify = auth()->id() == $this->file->user_id;
        }
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

    public function saveFile()
    {
        if (!auth()->check()) {
            return;
        }

        Save::create(
            ['user_id' => auth()->id(), 'file_id' => $this->file->id]
        );

        UserActivity::create([
            'user_id' => auth()->id(),
            'details' => "Saved file: " . $this->file->name
        ]);

        $this->dispatch('success_flash', message: 'File saved successfully.');
        $this->optionsAreOpen = false;
        $this->isSaved = true;
    }

    public function unsaveFile()
    {
        if (!auth()->check()) {
            return;
        }

        Save::where('user_id', auth()->id())
            ->where('file_id', $this->file->id)
            ->delete();

        UserActivity::create([
            'user_id' => auth()->id(),
            'details' => "Unsaved file: " . $this->file->name
        ]);

        $this->dispatch('unsave-file'); // to Saved Page
        $this->dispatch('success_flash', message: 'File unsaved successfully.');
        $this->optionsAreOpen = false;
        $this->isSaved = false;
    }

    public function mount($file)
    {
        $this->file = $file;
        $this->icon = $this->getFileIcon($file->mime_type);

        $this->determineIfUserCanModify();

        $this->isSaved = Save::where('user_id', auth()->id())
            ->where('file_id', $this->file->id)
            ->exists();
    }

    public function render()
    {
        return view('livewire.component.file-card');
    }
}