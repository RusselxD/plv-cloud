<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    public $userName;
    public $password;
    public $remember = false;

    protected $rules = [
        'userName' => 'required',
        'password' => 'required'
    ];

    public function submit(){

        // dd($this->userName, $this->password, $this->remember);

        $this->validate();

        $credentials = [
            'username' => $this->userName,
            'password' => $this->password
        ];

        if (Auth::attempt($credentials, $this->remember)){
            session()->regenerate();
            return redirect()->intended('home');
        }
        
        session()->flash('error', 'Invalid credentials. Try again.');
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}
