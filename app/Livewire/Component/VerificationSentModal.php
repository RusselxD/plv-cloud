<?php

namespace App\Livewire\Component;

use Livewire\Component;

class VerificationSentModal extends Component
{
    public $email;

    public function resend()
    {
        $this->dispatch('resendEmail');        
    }

    public function mount($email)
    {        
        $this->email = $email;
    }

    public function render()
    {
        return view('livewire.component.verification-sent-modal');
    }
}
