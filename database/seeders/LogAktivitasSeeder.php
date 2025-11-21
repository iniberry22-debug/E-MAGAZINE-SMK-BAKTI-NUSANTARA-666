<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogAktivitasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('log_aktivitas')->insert([
            [
                'id_user' => 1,
                'aksi' => 'Login',
                'waktu' => now()
            ],
            [
                'id_user' => 2,
                'aksi' => 'Membuat artikel baru',
                'waktu' => now()->subHours(2)
            ],
            [
                'id_user' => 4,
                'aksi' => 'Menyukai artikel',
                'waktu' => now()->subHours(1)
            ]
        ]);
    }
}