<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $admin = DB::table('user')->where('username', 'admin')->first();
    
    if ($admin) {
        echo "Admin found:\n";
        echo "Username: " . $admin->username . "\n";
        echo "Role: " . $admin->role . "\n";
        echo "Password hash: " . $admin->password . "\n";
        
        // Test password
        $testPassword = 'admin123';
        $isValid = password_verify($testPassword, $admin->password);
        echo "Password 'admin123' valid: " . ($isValid ? 'YES' : 'NO') . "\n";
        
        // Test with Laravel Hash
        $isValidLaravel = \Illuminate\Support\Facades\Hash::check($testPassword, $admin->password);
        echo "Laravel Hash check 'admin123': " . ($isValidLaravel ? 'YES' : 'NO') . "\n";
        
    } else {
        echo "Admin not found\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}