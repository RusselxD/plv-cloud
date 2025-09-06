<?php

namespace App\Livewire\Page;

use App\Models\Folder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Course as CourseModel;
use function PHPUnit\Framework\isEmpty;

class Course extends Component
{
    public CourseModel $course;

    public string $search = '';

    public bool $showCreateFolderModal = false;

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
            ->to(route('folder', ['courseSlug' => $this->course->slug, 'folderSlug' => $folderSlug]));
    }    

    public function openCreateFolderModal()
    {
        if (!Auth::check()) {
            return redirect()->to(route('login'));
        }

        $this->showCreateFolderModal = true;
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

        return view('livewire.page.course', ['folders' => $folders]);
    }
}
