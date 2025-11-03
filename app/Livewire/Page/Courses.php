<?php

namespace App\Livewire\Page;

use App\Models\Course;
use App\Models\File;
use App\Models\Folder;
use App\Models\User;
use Livewire\Component;

class Courses extends Component
{

    public $search = "";

    public function updatedSearch()
    {
        $this->render();
    }

    public function submitSearch()
    {
        $this->render();
    }

    public function clearSearch()
    {
        $this->search = '';
    }    

    public function render()
    {
        if (empty($this->search)) {

            $defaultCourses = Course::orderBy('abbreviation', 'asc')->get();

            return view('livewire.page.courses', ['result' => $defaultCourses]);

        } else {

            $courses = Course::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('abbreviation', 'like', '%' . $this->search . '%')
                ->orderBy('abbreviation', 'asc')
                ->get();            

            return view('livewire.page.courses', ['result' => $courses]);
        }
    }
}