<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_DATABASE'] ?? 'e_magazine';
$username = $_ENV['DB_USERNAME'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Disable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    
    // Clear tables
    $pdo->exec("TRUNCATE TABLE comments");
    $pdo->exec("TRUNCATE TABLE likes");
    $pdo->exec("TRUNCATE TABLE artikel");
    $pdo->exec("TRUNCATE TABLE karya_siswa");
    $pdo->exec("TRUNCATE TABLE kegiatan");
    $pdo->exec("TRUNCATE TABLE komentar");
    $pdo->exec("TRUNCATE TABLE karya_comments");
    $pdo->exec("TRUNCATE TABLE log_aktivitas");
    
    // Re-enable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    
    echo "Semua artikel dan karya siswa berhasil dihapus!";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>