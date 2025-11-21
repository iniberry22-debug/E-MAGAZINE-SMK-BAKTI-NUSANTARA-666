<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('user')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        DB::table('user')->insert([
            [
                'nama' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Pembina Mading',
                'username' => 'PembinaMading666',
                'password' => Hash::make('madingbn666'),
                'role' => 'guru',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Siswa Mading',
                'username' => 'SiswaMading',
                'password' => Hash::make('madingbn666'),
                'role' => 'siswa',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}