<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "Checking users in database:\n";
echo "==========================\n";

$users = User::all();

if ($users->count() == 0) {
    echo "No users found in database!\n";
    echo "Please run: php artisan db:seed --class=UserSeeder\n";
} else {
    foreach ($users as $user) {
        echo "ID: {$user->id_user}\n";
        echo "Name: {$user->nama}\n";
        echo "Username: {$user->username}\n";
        echo "Role: {$user->role}\n";
        echo "Password Hash: " . substr($user->password, 0, 20) . "...\n";
        
        // Test password
        $testPasswords = [
            'admin123' => Hash::check('admin123', $user->password),
            'guru123' => Hash::check('guru123', $user->password),
            'siswa123' => Hash::check('siswa123', $user->password)
        ];
        
        foreach ($testPasswords as $pass => $result) {
            if ($result) {
                echo "Password '{$pass}' works: YES\n";
            }
        }
        
        echo "---\n";
    }
}