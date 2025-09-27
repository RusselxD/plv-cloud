<?php

namespace App\Livewire\Component;

use App\Models\Notification;
use Livewire\Component;

class ProfileWithNotif extends Component
{
    public $isLoggedIn = false;
    public $hasANotif = false;

    public function mount(){
        $this->isLoggedIn = auth()->check();        
    }


    public function render()
    {
        if ($this->isLoggedIn){
            $this->hasANotif = Notification::where('user_id', auth()->id())->where('is_read', false)->exists();
        }
        
        return view('livewire.component.profile-with-notif');
    }
}