<?php

namespace App\Livewire\Page;

use App\Models\Course;
use App\Models\File;
use App\Models\Folder;
use App\Models\User;
use Livewire\Component;

class Home extends Component
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

    public function queryUsers()
    {
        return User::where(function ($query) {
            $query->where('is_private', false)
                // if a user is not a private account, show if any of these fields match
                ->where(function ($q) {
                    $q->where('username', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('student_number', 'like', '%' . $this->search . '%')
                        ->orWhere('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
        })
            ->orWhere(function ($query) {
                // if a user is a private account, only show if the username matches
                $query->where('is_private', true)
                    ->where('username', 'like', '%' . $this->search . '%');
            })
            ->orderBy('username', 'asc')
            ->get(['username', 'student_number', 'first_name', 'last_name', 'profile_picture']);
    }

    public function render()
    {
        if (empty($this->search)) {

            $defaultCourses = Course::orderBy('abbreviation', 'asc')->get();

            return view('livewire.page.home', ['result' => $defaultCourses]);

        } else {

            $courses = Course::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('abbreviation', 'like', '%' . $this->search . '%')
                ->orderBy('abbreviation', 'asc')
                ->get();

            $folders = Folder::where('name', 'like', '%' . $this->search . '%')
                ->orderBy('name', 'asc')
                ->get();

            $files = File::where('name', 'like', '%' . $this->search . '%')
                ->orderBy('download_count', 'asc')
                ->get();

            $users = $this->queryUsers();

            dd($courses, $folders, $files, $users);

            return view('livewire.page.home');
        }

    }
}