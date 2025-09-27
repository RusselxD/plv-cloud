<?php

namespace App\Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public $userIsAuthenticated;
    public $user;
    

    public function goToProfile(){
        return redirect()->route('user', ['username' => auth()->user()->username]);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }

    public function mount()
    {
        $this->userIsAuthenticated = Auth::check();
        if ($this->userIsAuthenticated){
            $this->user = Auth::user();
        }
    }

    public function render()
    {
        return view('livewire.component.sidebar');
    }
}