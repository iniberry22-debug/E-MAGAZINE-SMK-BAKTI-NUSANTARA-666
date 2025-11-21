<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $pdo = new PDO(
        "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE'],
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== STATUS HALAMAN UTAMA ===\n\n";
    
    // Cek artikel
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM artikel WHERE status = 'published'");
    $artikelCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    echo "📰 Artikel Published: {$artikelCount}\n";
    
    // Cek karya siswa
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM karya_siswa");
    $karyaCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    echo "✍️  Karya Siswa: {$karyaCount}\n\n";
    
    if ($artikelCount == 0) {
        echo "ℹ️  Karena artikel kosong, halaman utama akan menampilkan:\n";
        echo "   - Hero section dengan foto default (blog-hero-1.webp)\n";
        echo "   - Section karya siswa (jika ada)\n\n";
    }
    
    if ($karyaCount > 0) {
        echo "✅ Karya siswa tersedia, akan tampil di halaman utama\n";
        
        // Tampilkan beberapa karya siswa
        $stmt = $pdo->query("SELECT judul, foto FROM karya_siswa LIMIT 3");
        $karya = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($karya as $k) {
            echo "   - {$k['judul']} (foto: {$k['foto']})\n";
        }
    } else {
        echo "❌ Tidak ada karya siswa\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>