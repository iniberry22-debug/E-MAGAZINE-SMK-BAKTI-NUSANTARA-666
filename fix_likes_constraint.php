<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

echo "=== Fixing Likes Constraint ===\n";

try {
    // Drop the problematic unique constraint
    Schema::table('likes', function (Blueprint $table) {
        $table->dropUnique(['artikel_id', 'ip_address']);
    });
    echo "Dropped artikel_id + ip_address constraint\n";
} catch (Exception $e) {
    echo "Error dropping constraint: " . $e->getMessage() . "\n";
}

try {
    // Add unique constraint for user_id + artikel_id instead
    Schema::table('likes', function (Blueprint $table) {
        $table->unique(['artikel_id', 'user_id'], 'likes_artikel_user_unique');
    });
    echo "Added artikel_id + user_id constraint\n";
} catch (Exception $e) {
    echo "Error adding constraint: " . $e->getMessage() . "\n";
}

echo "=== Fix Complete ===\n";