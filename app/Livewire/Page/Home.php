<?php

namespace App\Livewire\Page;

use App\Models\Course;
use Livewire\Component;

class Home extends Component
{

    public string $searchTerm = "";

    public function submitSearch(){
        dd($this->searchTerm);
    }

    public function render()
    {
        $result = Course::orderBy('abbreviation', 'asc')->get();

        // dd($result->first()->folders);

        return view('livewire.page.home', ['result' => $result]);
    }
}
