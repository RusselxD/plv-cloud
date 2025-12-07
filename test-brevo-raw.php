<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

echo "Testing Brevo SMTP with raw email...\n\n";

try {
    // Test 1: Simple raw email
    Mail::raw('This is a test email from PLV Cloud using Brevo SMTP.', function ($message) {
        $message->to('russelcabigquez8@gmail.com')
                ->subject('PLV Cloud Test Email')
                ->from('plvcloud.noreply@gmail.com', 'PLV Cloud');
    });
    
    echo "✅ Raw email sent successfully!\n";
    echo "From: plvcloud.noreply@gmail.com\n";
    echo "To: russelcabigquez8@gmail.com\n";
    echo "Subject: PLV Cloud Test Email\n\n";
    
    echo "Check your inbox AND spam folder.\n";
    echo "If you still don't see it, there may be an issue with:\n";
    echo "1. Brevo account verification status\n";
    echo "2. Gmail blocking emails from this sender\n";
    echo "3. The 'from' address not being verified in Brevo\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
    echo "Stack trace:\n";
    echo $e->getTraceAsString();
}
