<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Like;
use App\Models\Artikel;

echo "=== Test Sistem Like ===\n";

// Cek artikel yang ada
$artikel = Artikel::first();
if (!$artikel) {
    echo "Tidak ada artikel untuk test\n";
    exit;
}

echo "Testing artikel: " . $artikel->judul . "\n";
echo "ID Artikel: " . $artikel->id_artikel . "\n";

// Simulasi user 1 like
$like1 = Like::create([
    'artikel_id' => $artikel->id_artikel,
    'user_id' => 1,
    'ip_address' => '192.168.1.1'
]);
echo "User 1 like artikel - ID: " . $like1->id . "\n";

// Simulasi user 2 like
$like2 = Like::create([
    'artikel_id' => $artikel->id_artikel,
    'user_id' => 2,
    'ip_address' => '192.168.1.2'
]);
echo "User 2 like artikel - ID: " . $like2->id . "\n";

// Hitung total likes
$totalLikes = Like::where('artikel_id', $artikel->id_artikel)->count();
echo "Total likes untuk artikel ini: " . $totalLikes . "\n";

// Cek apakah user 1 sudah like
$user1Liked = Like::where('artikel_id', $artikel->id_artikel)
                  ->where('user_id', 1)
                  ->exists();
echo "User 1 sudah like: " . ($user1Liked ? 'Ya' : 'Tidak') . "\n";

// Cek apakah user 2 sudah like
$user2Liked = Like::where('artikel_id', $artikel->id_artikel)
                  ->where('user_id', 2)
                  ->exists();
echo "User 2 sudah like: " . ($user2Liked ? 'Ya' : 'Tidak') . "\n";

echo "=== Test Selesai ===\n";