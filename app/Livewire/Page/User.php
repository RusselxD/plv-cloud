<?php

namespace App\Livewire\Page;

use Livewire\Component;

class User extends Component
{
    public $username;

    public function mount($username)
    {
        $this->username = $username;
    }

    public function render()
    {
        return view('livewire.page.user');
    }
}