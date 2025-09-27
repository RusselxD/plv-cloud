<?php

namespace App\Livewire\Component;

use App\Models\Course;
use App\Models\Folder;
use Livewire\Component;

class Breadcrumb extends Component
{
    public $breadcrumbs = [];

    public function addHomeUrl()
    {
        array_unshift($this->breadcrumbs, ['name' => 'Home', 'url' => '/']);
    }

    public function addCourseUrl($courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        array_unshift($this->breadcrumbs, ['name' => $course->abbreviation, 'url' => route('course', ['courseSlug' => $course->slug])]);
    }

    public function addFolderCrumbs($courseSlug, $path)
    {
        // [folder1, folder2, folderN]
        $paths = explode('/', $path);

        $prevPath = '';
        foreach ($paths as $pathSlug) {

            $folder = Folder::where('slug', $pathSlug)->firstOrFail();

            $currentPath = $prevPath . $pathSlug . '/';

            array_push($this->breadcrumbs, [
                'name' => $folder->name,
                'url' => route('folder', ['courseSlug' => $courseSlug, 'path' => $currentPath])
            ]);

            $prevPath = $currentPath;
        }
    }

    public function mount($courseSlug = null, $path = null)
    {
        // dump($courseSlug, $path);
        if ($courseSlug !== null && $path !== null) {
            $this->addFolderCrumbs($courseSlug, $path);
        }

        if ($courseSlug !== null) {
            $this->addCourseUrl($courseSlug);
        }

        // $this->addHomeUrl();

        // dd($this->breadcrumbs);
    }

    public function render()
    {
        return view('livewire.component.breadcrumb');
    }
}
