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

    public bool $createFolderModalIsOpen = false;

    public $breadcrumbs = [];

    #[On('folder-created')] // from CreateFolder
    #[On('file-created')] // from AddNewButton
    #[On('deleted')] // from ConfirmDeleteModal    
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

    public function clearSearch()
    {
        $this->search = '';
    }

    public function goToFolder($folderSlug)
    {
        return redirect()
            ->to(route('folder', ['courseSlug' => $this->course->slug, 'path' => $folderSlug]));
    }

    public function mount($courseSlug)
    {
        $this->course = CourseModel::where('slug', $courseSlug)->firstOrFail();

        $this->breadcrumbs[] = ['name' => $this->course->abbreviation, 'url' => route('course', ['courseSlug' => $this->course->slug])];        
    }

    public function render()
    {
        $folders = Folder::select('id', 'name', 'uuid', 'user_id', 'course_id')
            ->with('user:id,username,profile_picture', 'course', 'folderContributors')
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