<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\SignupVerifyController;
use App\Livewire\Auth\AdminLogin;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\RegisterDetails;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Page\AdminDashboard;
use App\Livewire\Page\Banned;
use App\Livewire\Page\Course;
use App\Livewire\Page\Courses;
use App\Livewire\Page\Folder;

// use App\Livewire\Auth\RegisterDetails;
use App\Livewire\Page\Home;
use App\Livewire\Page\Notifications;
use App\Livewire\Page\Saved;
use App\Livewire\Page\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', Login::class)
    ->middleware('guest')
    ->name('home.guest');

Route::get('/banned', Banned::class)
    ->middleware('auth')
    ->name('banned');

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

Route::get('/home', Home::class)
    ->name('home');

Route::get('/courses', Courses::class)
    ->name('courses');

Route::get('/notifications', Notifications::class)
    ->middleware('auth')
    ->name('notifications');

Route::get('/saved', Saved::class)
    ->middleware('auth')
    ->name('saved');

Route::get('/login', Login::class)
    ->middleware('guest')
    ->name('login');

Route::get('/forgot-password', ForgotPassword::class)
    ->middleware('guest')
    ->name('password.request');

Route::get('/reset-password/{token}', ResetPassword::class)
    ->middleware('guest')
    ->name('password.reset');

Route::get('/register', VerifyEmail::class)
    ->middleware('guest')
    ->name('register');

Route::get('/register/{token}', RegisterDetails::class)
    ->middleware('guest')
    ->name('register.complete');

Route::get('/c/{courseSlug}', Course::class)
    ->name('course');

Route::get('/folder/{uuid}', Folder::class)
    ->name('folder');

Route::get('/u/{username}', User::class)
    ->name('user');

Route::get('/file/download/{id}', [FileController::class, 'download'])->name('file.download');
Route::get('/folder/download/{id}', [FileController::class, 'downloadFolder'])->name('folder.download');

Route::get('/admin', AdminLogin::class)->name('admin.login');
Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');

Route::get('/signup/verify/{token}', [SignupVerifyController::class, 'verify'])->name('verify.email');
