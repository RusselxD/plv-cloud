<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ResetPassword extends Component
{
    public $token;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required'
    ];

    protected $messages = [
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'password.required' => 'Please enter a new password.',
        'password.min' => 'Password must be at least 8 characters.',
        'password.confirmed' => 'Password confirmation does not match.',
        'password_confirmation.required' => 'Please confirm your password.',
    ];

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email');

        if (!$this->email) {
            session()->flash('error', 'Invalid password reset link.');
            return redirect()->route('login');
        }

        // Verify token exists and is not expired (24 hours)
        $resetToken = DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->where('token', $this->token)
            ->first();

        if (!$resetToken) {
            session()->flash('error', 'Invalid or expired password reset link.');
            return redirect()->route('login');
        }

        // Check if token is expired (24 hours)
        if (now()->diffInHours($resetToken->created_at) > 24) {
            DB::table('password_reset_tokens')->where('email', $this->email)->delete();
            session()->flash('error', 'Password reset link has expired. Please request a new one.');
            return redirect()->route('password.request');
        }
    }

    public function submit()
    {
        $this->validate();

        // Verify token again
        $resetToken = DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->where('token', $this->token)
            ->first();

        if (!$resetToken) {
            $this->addError('email', 'Invalid or expired password reset link.');
            return;
        }

        // Find user
        $user = User::where('email', $this->email)->first();

        if (!$user) {
            $this->addError('email', 'No account found with this email address.');
            return;
        }

        // Update password
        $user->password = Hash::make($this->password);
        $user->save();

        // Delete the used token
        DB::table('password_reset_tokens')->where('email', $this->email)->delete();

        session()->flash('success', 'Password has been reset successfully! You can now login with your new password.');
        return redirect()->route('login');
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
