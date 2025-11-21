<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test database connection
try {
    $artikel = DB::table('artikel')->count();
    $karya = DB::table('karya_siswa')->count();
    
    echo "Total artikel: " . $artikel . "\n";
    echo "Total karya siswa: " . $karya . "\n";
    
    // Show actual data
    $artikelData = DB::table('artikel')
        ->select('judul', 'status')
        ->limit(5)
        ->get();
    
    echo "\nData artikel:\n";
    foreach($artikelData as $artikel) {
        echo "- " . $artikel->judul . " (status: " . $artikel->status . ")\n";
    }
    
    $karyaData = DB::table('karya_siswa')
        ->select('judul')
        ->limit(5)
        ->get();
    
    echo "\nData karya siswa:\n";
    foreach($karyaData as $karya) {
        echo "- " . $karya->judul . "\n";
    }
    
    // Test search with actual keyword
    $query = 'pramuka';
    $searchResults = DB::table('artikel')
        ->select('id_artikel as id', 'judul', 'status')
        ->where('status', 'published')
        ->where(function($q) use ($query) {
            $q->where('judul', 'like', '%' . $query . '%')
              ->orWhere('isi', 'like', '%' . $query . '%');
        })
        ->get();
    
    echo "\nHasil pencarian untuk '$query': " . $searchResults->count() . " hasil\n";
    foreach($searchResults as $result) {
        echo "- " . $result->judul . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}