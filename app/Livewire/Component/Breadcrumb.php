<?php

namespace App\Livewire\Component;

use App\Models\Course;
use App\Models\Folder;
use Livewire\Component;

class Breadcrumb extends Component
{
    public $breadcrumbs = [];

    public function addCourseUrl($courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        array_unshift($this->breadcrumbs, ['name' => $course->abbreviation, 'url' => route('course', ['courseSlug' => $course->slug])]);
    }

    // build up the crumbs from folder to parent folder to course
    public function addFolderCrumbs($uuid)
    {
        $folder = Folder::with('folder')->where('uuid', $uuid)->firstOrFail();

        while ($folder->folder) {
            array_unshift($this->breadcrumbs, ['name' => $folder->name, 'url' => route('folder', ['uuid' => $folder->uuid])]);
            $folder = $folder->folder;
        }
        array_unshift($this->breadcrumbs, ['name' => $folder->name, 'url' => route('folder', ['uuid' => $folder->uuid])]);
        $this->addCourseUrl($folder->course->slug);
    }

    public function mount($courseSlug = null, $uuid = null)
    {
        if ($courseSlug !== null) {
            // this came from course page
            $this->addCourseUrl($courseSlug);
        } else {
            // this came from folder page
            $this->addFolderCrumbs($uuid);
        }
    }

    public function render()
    {
        return view('livewire.component.breadcrumb');
    }
}