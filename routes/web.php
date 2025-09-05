<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Page\Course;
use App\Livewire\Page\Folder;
use App\Livewire\Page\Home;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class);

Route::get('/login', Login::class)
    ->middleware('guest')
    ->name('login');

Route::get('/register', VerifyEmail::class)
    ->middleware('guest')
    ->name('register');

Route::get('/course/{abbrv}', Course::class)
    ->name('course');

Route::get('/course/{abbrv}/{folder}', Folder::class)
    ->name('folder');