<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    DB::table('artikel')->where('id_artikel', 1)->update(['foto' => 'assets/img/blog/blog-post-1.webp']);
    DB::table('artikel')->where('id_artikel', 2)->update(['foto' => 'assets/img/blog/pahlawan.png']);
    DB::table('artikel')->where('id_artikel', 3)->update(['foto' => 'assets/img/blog/blog-post-2.webp']);
    DB::table('artikel')->where('id_artikel', 4)->update(['foto' => 'assets/img/blog/blog-post-3.webp']);
    DB::table('artikel')->where('id_artikel', 5)->update(['foto' => 'assets/img/blog/blog-post-4.webp']);
    DB::table('artikel')->where('id_artikel', 6)->update(['foto' => 'assets/img/blog/blog-post-5.webp']);
    
    echo "Foto berhasil diupdate!\n";
    
    // Cek hasil
    $artikel = DB::table('artikel')->select('id_artikel', 'judul', 'foto')->get();
    foreach($artikel as $art) {
        echo "ID: " . $art->id_artikel . " - Foto: " . $art->foto . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}