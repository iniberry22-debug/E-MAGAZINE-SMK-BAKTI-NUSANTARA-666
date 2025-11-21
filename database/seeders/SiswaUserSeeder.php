<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SiswaUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Ahmad Siswa',
            'username' => 'siswa1',
            'password' => Hash::make('password'),
            'role' => 'siswa'
        ]);

        User::create([
            'nama' => 'Siti Siswi',
            'username' => 'siswa2',
            'password' => Hash::make('password'),
            'role' => 'siswa'
        ]);
    }
}