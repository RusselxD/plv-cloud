<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;

class AdminLogin extends Component
{
    public $username = '';
    public $password = '';

    protected $rules = [
        'username' => 'required',
        'password' => 'required'
    ];

    protected $messages = [
        'username.required' => 'Please enter your username.',
        'password.required' => 'Please enter your password.',
    ];

    public function submit()
    {
        $this->validate();

        // Check admin credentials from environment variables
        if ($this->username === env('ADMIN_USERNAME') && $this->password === env('ADMIN_PASSWORD')) {
            session(['admin_authenticated' => true]);
            session()->flash('success', 'Welcome to Admin Dashboard!');
            return redirect()->route('admin.dashboard');
        }

        $this->addError('username', 'Invalid admin credentials.');
        $this->reset(['username', 'password']);
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.auth.admin-login');
    }
}
