<?php

namespace App\Livewire\Page;

use App\Models\Folder;
use Livewire\Component;
use App\Models\Course as CourseModel;
use function PHPUnit\Framework\isEmpty;

class Course extends Component
{
    public CourseModel $course;

    public string $search = '';

    public function updatedSearch()
    {
        $this->render();
    }

    public function clickSearch(){
        $this->render();
    }

    public function mount($abbrv)
    {
        $this->course = CourseModel::where('abbreviation', $abbrv)->firstOrFail();
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
