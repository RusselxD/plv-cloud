<?php

namespace App\Providers;

use App\Mail\BrevoApiTransport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class BrevoApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Mail::extend('brevo-api', function (array $config) {
            return new BrevoApiTransport($config['api_key']);
        });
    }
}
