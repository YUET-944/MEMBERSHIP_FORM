<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Verifying Sessions Table ===\n\n";

try {
    // Check if table exists
    $exists = \Illuminate\Support\Facades\Schema::hasTable('sessions');
    echo "Sessions table exists: " . ($exists ? "✅ YES" : "❌ NO") . "\n";
    
    if ($exists) {
        $count = \Illuminate\Support\Facades\DB::table('sessions')->count();
        echo "Current sessions: $count\n";
        echo "\n✅ Sessions table is ready!\n";
        echo "The application should work now.\n";
    } else {
        echo "\n❌ Sessions table not found. Run: php artisan migrate\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

