<?php

namespace App\Http\Controllers;

use App\Models\EmailVerification;

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
    }
}