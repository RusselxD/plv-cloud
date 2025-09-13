<?php

namespace App\Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public function goToProfile(){
        return redirect()->route('user', ['username' => auth()->user()->username]);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.component.sidebar');
    }
}
