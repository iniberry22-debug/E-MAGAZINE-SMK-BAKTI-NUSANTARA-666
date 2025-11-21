<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $artikel = DB::table('artikel')->select('id_artikel', 'judul', 'foto')->get();
    
    echo "Data foto artikel:\n";
    foreach($artikel as $art) {
        echo "ID: " . $art->id_artikel . " - " . $art->judul . "\n";
        echo "Foto: " . ($art->foto ?? 'NULL') . "\n";
        echo "---\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}