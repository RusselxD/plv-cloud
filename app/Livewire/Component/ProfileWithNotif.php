<?php

namespace App\Livewire\Component;

use App\Models\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class ProfileWithNotif extends Component
{
    public $isLoggedIn = false;
    public $hasANotif = false;
    public $hasBackground = false;

    #[On('update-notifs')] // from Notifications Page
    public function refresh(){
        if ($this->isLoggedIn){
            $this->render();
        }
    }

    public function mount($hasBackground = false){
        $this->isLoggedIn = auth()->check();
        $this->hasBackground = $hasBackground;
    }

    public function render()
    {
        if ($this->isLoggedIn){
            $this->hasANotif = Notification::where('user_id', auth()->id())->where('is_read', false)->exists();
        }
        
        return view('livewire.component.profile-with-notif');
    }
}