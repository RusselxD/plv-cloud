<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    public $login;
    public $password;
    public $remember = false;

    protected $rules = [
        'login' => 'required',
        'password' => 'required'
    ];

    protected $messages = [
        'login.required' => 'Email or username is required.',
        'password.required' => 'Password is required.',
    ];

    public function submit()
    {
        $this->validate();

        $field = filter_var($this->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($field, $this->login)->first();

        // Check if username or email exists
        if (!$user) {
            $this->addError('login', ucfirst($field) . ' not found.');
            $this->reset(['login', 'password']);
            return;
        }

        // Check if password is correct
        if (!Hash::check($this->password, $user->password)) {
            $this->addError('password', 'Incorrect password.');
            $this->reset(['password']);
            return;
        }

        // Login the user
        Auth::login($user, $this->remember);
        session()->regenerate();
        return redirect()->intended('home');
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}
