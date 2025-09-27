<?php

namespace App\Livewire\Page;

use App\Models\File;
use App\Models\Folder;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Course as CourseModel;

class Course extends Component
{
    public CourseModel $course;

    public string $search = '';

    public bool $isCreateFolderModalOpen = false;

    #[On('folder-created')] // from CreateFolder
    #[On('file-created')] // from AddNewButton
    #[On('folder-deleted')] // from ConfirmDeleteModal
    #[On('file-deleted')] // from ConfirmDeleteModal    
    public function refresh()
    {
        $this->render();
    }

    public function updatedSearch()
    {
        $this->render();
    }

    public function clickSearch()
    {
        $this->render();
    }

    public function goToFolder($folderSlug)
    {
        return redirect()
            ->to(route('folder', ['courseSlug' => $this->course->slug, 'path' => $folderSlug]));
    }

    public function mount($courseSlug)
    {
        $this->course = CourseModel::where('slug', $courseSlug)->firstOrFail();
    }

    public function render()
    {
        $folders = Folder::with('user')
            ->when($this->search, function ($query) {

                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        // WHERE NAME LIKE %search%
    
                        ->orWhereHas('user', function ($q2) {
                            $q2->where('username', 'like', '%' . $this->search . '%');
                            // WHERE USERNAME LIKE %search%
                        });
                });

            })
            ->withCount(['files', 'children'])
            ->where('course_id', $this->course->id)
            ->get();

        $files = File::with('user')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
                // WHERE NAME LIKE %search%
            })
            ->where('course_id', $this->course->id)
            ->get();

        return view('livewire.page.course', ['folders' => $folders, 'files' => $files]);
    }
}