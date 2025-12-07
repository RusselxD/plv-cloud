<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailMail;

echo "Testing Brevo API speed and delivery...\n\n";

// Test 1: Speed test with raw email
echo "Test 1: Raw email speed test\n";
echo str_repeat('-', 50) . "\n";
$start = microtime(true);

try {
    Mail::raw('This is a speed test using Brevo API', function ($message) {
        $message->to('russelcabigquez8@gmail.com')
                ->subject('Brevo API Speed Test')
                ->from('plvcloud.noreply@gmail.com', 'PLV Cloud');
    });
    
    $duration = round((microtime(true) - $start), 3);
    
    echo "✅ Email sent successfully\n";
    echo "⏱️  Time taken: {$duration} seconds\n";
    
    if ($duration < 1) {
        echo "🚀 EXCELLENT! API is 10x faster than SMTP!\n";
    } elseif ($duration < 2) {
        echo "✅ Good speed - much better than SMTP\n";
    } else {
        echo "⚠️  Still slow - check API configuration\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n";

// Test 2: Verification email template
echo "Test 2: Verification email template test\n";
echo str_repeat('-', 50) . "\n";
$start = microtime(true);

try {
    Mail::to('russelcabigquez8@gmail.com')->send(
        new VerifyEmailMail('russelcabigquez8@gmail.com', 'http://test.com/verify/123')
    );
    
    $duration = round((microtime(true) - $start), 3);
    
    echo "✅ Verification email sent successfully\n";
    echo "⏱️  Time taken: {$duration} seconds\n\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

echo str_repeat('=', 50) . "\n";
echo "✅ All tests passed! Brevo API is working perfectly.\n";
echo "📧 Check your inbox: russelcabigquez8@gmail.com\n";
echo "   (Don't forget to check spam folder)\n";
