<?php

namespace App\Http\Controllers;

use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignupVerifyController extends Controller
{
    public function verify($token)
    {
        $record = EmailVerification::where('token', $token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return redirect()->route('register')->with('error_flash', 'Link expired or invalid.');
        }

        return redirect()->route('register.complete', ['token' => $token]);
        // dd("heyyy");

        // // Create the actual user now
        // $user = User::create([
        //     'email' => $record->email,
        //     'password' => bcrypt(\Str::random(16)), // random placeholder
        //     'email_verified_at' => now(),
        // ]);

        // Auth::login($user);

        // // remove verification record
        // $record->delete();

        // return redirect('/dashboard')->with('success', 'Email verified and account created!');
    }
}
