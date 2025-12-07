<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailMail;

try {
    Mail::to('russelcabigquez8@gmail.com')->send(new VerifyEmailMail('russelcabigquez8@gmail.com', 'http://test.com'));
    echo "✅ Email sent successfully to russelcabigquez8@gmail.com\n";
    echo "Check your inbox (including spam folder)\n";
} catch (Exception $e) {
    echo "❌ Error sending email:\n";
    echo $e->getMessage() . "\n";
    echo "\nFull trace:\n";
    echo $e->getTraceAsString();
}
