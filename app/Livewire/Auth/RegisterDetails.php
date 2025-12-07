<?php

namespace App\Livewire\Auth;

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
    public $firstName;
    public $lastName;
    public $courseId;

    public function rules()
    {
        return [
            'username' => ['required', 'unique:users,username', 'min:3', 'max:20', 'regex:/^[a-zA-Z0-9._-]+$/'],
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
            'firstName' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'lastName' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'courseId' => ['required', 'exists:courses,id'],
        ];
    }

    protected $messages = [
        'username.required' => 'Please choose a username.',
        'username.unique' => 'This username is already taken.',
        'username.min' => 'Username must be at least 3 characters.',
        'username.max' => 'Username can\'t be longer than 20 characters.',
        'username.regex' => 'Usernames may only contain letters, numbers, underscores, dashes, and dots.',

        'password.required' => 'Please enter a password.',
        'password.min' => 'Password must be at least 8 characters.',
        'password.mixedCase' => 'Password must include both uppercase and lowercase letters.',
        'password.letters' => 'Password must include at least one letter.',
        'password.numbers' => 'Password must include at least one number.',
        'password.symbols' => 'Password must include at least one symbol.',
        'password.confirmed' => 'Passwords do not match.',

        'password_confirmation.required' => 'Please confirm your password.',

        'firstName.required' => 'Please enter your first name.',
        'firstName.min' => 'First name must have at least 1 character.',
        'firstName.max' => 'First name cannot be longer than 50 characters.',
        'firstName.regex' => 'First name may only contain letters, spaces, hyphens, and apostrophes.',

        'lastName.required' => 'Please enter your last name.',
        'lastName.min' => 'Last name must have at least 1 character.',
        'lastName.max' => 'Last name cannot be longer than 50 characters.',
        'lastName.regex' => 'Last name may only contain letters, spaces, hyphens, and apostrophes.',

        'courseId.required' => 'Please select your course.',
        'courseId.exists' => 'Selected course does not exist.',
    ];

    public function register()
    {        
        $this->validate($this->rules());

        $user = User::create([
            'email' => trim($this->email),
            'username' => $this->username,
            'password' => bcrypt($this->password),            
            'first_name' => ucwords(strtolower($this->firstName)),
            'last_name' => ucwords(strtolower($this->lastName)),
            'course_id' => $this->courseId,
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        $this->verificationRecord->delete();

        return redirect()->route('home')->with('register_success');
    }

    public function mount($token)
    {
        $record = EmailVerification::where('token', $token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return redirect()->route('register')->with('error_flash', 'Link expired or invalid.');
        }

        $this->verificationRecord = $record;
        
        $this->email = $record->email;
        $this->courses = Course::all();
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.auth.register-details');
    }
}
