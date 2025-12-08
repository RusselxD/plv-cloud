<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ForgotPassword extends Component
{
    public $email;
    public $emailSent = false;

    protected $rules = [
        'email' => 'required|email'
    ];

    protected $messages = [
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
    ];

    public function submit()
    {
        $this->validate();

        // Check if user exists
        $user = User::where('email', $this->email)->first();

        if (!$user) {
            $this->addError('email', 'No account found with this email address.');
            return;
        }

        // Generate token
        $token = Str::random(64);

        // Delete any existing tokens for this email
        DB::table('password_reset_tokens')->where('email', $this->email)->delete();

        // Store the new token
        DB::table('password_reset_tokens')->insert([
            'email' => $this->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Send email with reset link
        $resetLink = route('password.reset', ['token' => $token, 'email' => $this->email]);

        try {
            Mail::send('emails.password-reset', ['resetLink' => $resetLink, 'user' => $user], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Reset Password Request')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            $this->emailSent = true;
            session()->flash('success', 'Password reset link has been sent to your email.');
            
            \Log::info('Password reset email sent to: ' . $this->email);
            
        } catch (\Exception $e) {
            \Log::error('Failed to send password reset email: ' . $e->getMessage());
            $this->addError('email', 'Failed to send email. Please try again later.');
        }
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
