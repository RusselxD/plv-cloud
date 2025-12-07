<?php

namespace App\Livewire\Page;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Banned extends Component
{
    public $user;
    public $bannedUntil;
    public $banReason;

    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->user = auth()->user();
        
        if (!$this->user->isBanned()) {
            return redirect()->route('home');
        }

        $this->bannedUntil = $this->user->banned_until;
        $this->banReason = $this->user->ban_reason;
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.page.banned');
    }
}
