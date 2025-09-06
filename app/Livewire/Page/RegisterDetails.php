<?php

namespace App\Livewire\Page;

use App\Models\Course;
use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RegisterDetails extends Component
{
    public $verificationRecord;

    public $courses;

    public $email;
    public $username;
    public $password;
    public $password_confirmation;
    public $studentNumber;
    public $firstName;
    public $lastName;
    public $courseId;

    public function rules()
    {
        return [
            'username' => ['required', 'alpha_dash', 'unique:users,username', 'min:3', 'max:20'],
            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
                'confirmed',
            ],
            'password_confirmation' => ['required'],
            'studentNumber' => ['required', 'numeric', 'digits:8', 'unique:users,student_number', 'regex:/^\d{2}-\d{4}$/'],
            'firstName' => ['required', 'string', 'min:1', 'max:50'],
            'lastName' => ['required', 'string', 'min:1', 'max:50'],
            'courseId' => ['required', 'exists:courses,id'],
        ];
    }

    public function register()
    {
        $this->validate($this->rules());

        $user = User::create([
            'email' => $this->email,
            'username' => $this->username,
            'password' => bcrypt($this->password),
            'student_number' => $this->studentNumber,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'course_id' => $this->courseId,
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        $this->verificationRecord->delete();

        return redirect()->route('home')->with('register_success');
    }

    public function mount($token)
    {
        $this->verificationRecord = EmailVerification::where('token', $token)->firstOrFail();
        $this->email = $this->verificationRecord->email;
        $this->courses = Course::all();
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.page.register-details');
    }
}
