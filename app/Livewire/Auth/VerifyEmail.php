<?php

namespace App\Livewire\Auth;

use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

class VerifyEmail extends Component
{
    public $email;

    protected function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                // function ($attribute, $value, $fail) {
                //     if (!str_ends_with($value, '@plv.edu.ph')) {
                //         $fail('The ' . $attribute . ' must be a PLV email address.');
                //     }
                // },
                'unique:users,email'
            ],
        ];
    }

    protected $messages = [
        'email.required' => 'Please enter your PLV email.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already taken.',
    ];

    public function submit()
    {
        $this->validate();

        $token = Str::random(64);

        EmailVerification::updateOrCreate(
            ['email' => $this->email],
            [
                'token' => $token,
                'expires_at' => Carbon::now()->addMinutes(30),
            ]
        );

        $link = route('verify.email', ['token' => $token]);

        Mail::send('components.emails.verify', ['link' => $link], function ($message) {
            $message->to($this->email)
                ->subject('Verify your email to sign up');
        });

        session()->flash('verification_sent', $this->email);
        
        return $this->redirect(route('register'), navigate: true);
    }

    public function mount()
    {
        // Error flash is now handled in the blade template
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}
