<?php

use App\Http\Controllers\SignupVerifyController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\RegisterDetails;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Page\Course;
use App\Livewire\Page\Folder;
use App\Livewire\Page\Home;


// use App\Livewire\Auth\RegisterDetails;
use App\Livewire\Page\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)
    ->name('home');

Route::get('/login', Login::class)
    ->middleware('guest')
    ->name('login');

Route::get('/register', VerifyEmail::class)
    ->middleware('guest')
    ->name('register');

    
Route::get('/register/{token}', RegisterDetails::class)
    ->middleware('guest')
    ->name('register.complete');

Route::get('/c/{courseSlug}', Course::class)
    ->name('course');



Route::get('/c/{courseSlug}/{path?}', Folder::class)
    ->where('path', '.*')
    ->name('folder');




Route::get('/u/{username}', User::class)
    ->name('user');

Route::get('/signup/verify/{token}', [SignupVerifyController::class, 'verify'])->name('verify.email');
