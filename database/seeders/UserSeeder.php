<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::create(['nama' => 'Admin', 'email' => 'admin@emag.com', 'password' => Hash::make('admin123'), 'role' => 'admin']);
        User::create(['nama' => 'Guru Demo', 'email' => 'guru@emag.com', 'password' => Hash::make('guru123'), 'role' => 'guru']);
        User::create(['nama' => 'Siswa Demo', 'email' => 'siswa@emag.com', 'password' => Hash::make('siswa123'), 'role' => 'siswa']);
    }
}
