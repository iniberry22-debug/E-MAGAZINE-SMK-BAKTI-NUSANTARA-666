<?php
require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Hash;

// Test data
$users = [
    ['username' => 'admin', 'password' => 'admin123', 'role' => 'admin'],
    ['username' => 'guru1', 'password' => 'guru123', 'role' => 'guru'],
    ['username' => 'siswa1', 'password' => 'siswa123', 'role' => 'siswa']
];

echo "Testing password hashing:\n";
foreach ($users as $user) {
    $hashed = Hash::make($user['password']);
    $check = Hash::check($user['password'], $hashed);
    echo "User: {$user['username']}, Password: {$user['password']}, Hash works: " . ($check ? 'YES' : 'NO') . "\n";
}