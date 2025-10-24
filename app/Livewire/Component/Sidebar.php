<?php

namespace App\Livewire\Component;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Sidebar extends Component
{
    public $userIsAuthenticated;
    public $user;

    #[On('update-notifs')] // from Notifications Page
    public function refresh(){
        if ($this->userIsAuthenticated){
            $this->render();
        }
    }

    public function goToProfile()
    {
        return redirect()->route('user', ['username' => auth()->user()->username]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function mount()
    {
        $this->userIsAuthenticated = Auth::check();
        if ($this->userIsAuthenticated) {
            $this->user = Auth::user();
        }
    }

    public function render()
    {
        if ($this->userIsAuthenticated) {
            $notifs_count = Notification::where('user_id', $this->user->id)->where('is_read', false)->count();
            return view('livewire.component.sidebar', compact('notifs_count'));
        }

        return view('livewire.component.sidebar');
    }
}