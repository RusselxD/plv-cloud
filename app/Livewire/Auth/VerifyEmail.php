<?php

namespace App\Livewire\Auth;

use App\Mail\VerifyEmailMail;
use App\Models\EmailVerification;
use App\Models\User;
use Exception;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Symfony\Component\Mailer\Exception\TransportException;

class VerifyEmail extends Component
{
    public $email;

    protected $listeners = ['resendEmail' => 'sendAnotherEmail'];

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

        session(['user_email' => $this->email]);

        $sendEmail = $this->sendEmail();

        if ($sendEmail == 0) {
            session()->flash('verification_sent', $this->email);
            return $this->redirect(route('register'), navigate: true);
        } else {
            $this->errorSendingMail($sendEmail);
        }
    }

    // 0 = success
    // 1 = Internet / network connectivity issues
    // 2 = Specific network connection failures
    // 3 = General errors
    public function sendEmail()
    {
        $token = Str::random(64);

        EmailVerification::updateOrCreate(
            ['email' => $this->email],
            [
                'token' => $token,
                'expires_at' => Carbon::now()->addMinutes(30),
            ]
        );

        $link = route('verify.email', ['token' => $token]);

        try {
            // Send email synchronously with Brevo (testing)
            Mail::to($this->email)->send(new VerifyEmailMail($this->email, $link));
            
            \Log::info('Email sent successfully to: ' . $this->email);

            return 0;

        } catch (TransportException $e) {
            \Log::error('TransportException: ' . $e->getMessage());
            return 1;
        } catch (ConnectException $e) {
            \Log::error('ConnectException: ' . $e->getMessage());
            return 2;
        } catch (Exception $e) {
            \Log::error('General Exception: ' . $e->getMessage());
            return 3;
        }
    }

    public function sendAnotherEmail()
    {
        $this->email = session('user_email');
        $resendEmail = $this->sendEmail();
        if ($resendEmail == 0) {
            $this->dispatch('success_flash', message: 'New verification link sent.');
        } else {
            $this->errorSendingMail($resendEmail);
        }
    }

    public function errorSendingMail($code)
    {
        switch ($code) {
            case 1:
                $this->dispatch('error_flash', message: 'No internet connection. Please check your connection and try again.');
                break;
            case 2:
                $this->dispatch('error_flash', message: 'Connection failed. Please check your internet and try again.');
                break;
            case 3:
                $this->dispatch('error_flash', message: 'Something went wrong. Please try again.');
                break;
        }
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}