<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;

class VerifyEmail extends Component
{
    public $email;

    protected $rules = [

    ];

    public function submit()
    {
        $this->validate([
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@plv.edu.ph')) {
                        $fail('The ' . $attribute . ' must be a PLV email address.');
                    }
                },
                'unique:users,email'
            ],
        ]);

        // Send verification link logic here
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}
