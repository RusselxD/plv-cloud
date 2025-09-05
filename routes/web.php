<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\VerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()){
        return redirect('home');
    }
    return redirect('login');
});

Route::get('/login', Login::class)
    ->middleware('guest')
    ->name('login');

Route::get('/register', VerifyEmail::class)
    ->middleware('guest')
    ->name('register');