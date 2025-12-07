<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

echo "Testing email send speed with Brevo SMTP...\n\n";

$start = microtime(true);

try {
    Mail::raw('Speed test email', function ($message) {
        $message->to('russelcabigquez8@gmail.com')
                ->subject('Speed Test')
                ->from('plvcloud.noreply@gmail.com', 'PLV Cloud');
    });
    
    $duration = round((microtime(true) - $start), 2);
    
    echo "✅ Email sent successfully\n";
    echo "⏱️  Time taken: {$duration} seconds\n\n";
    
    if ($duration > 5) {
        echo "⚠️  WARNING: Email took more than 5 seconds to send!\n";
        echo "This will cause timeout issues in production.\n";
    } elseif ($duration > 2) {
        echo "⚠️  Email is slow (>2 seconds). Users will notice the delay.\n";
    } else {
        echo "✅ Email speed is acceptable.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
