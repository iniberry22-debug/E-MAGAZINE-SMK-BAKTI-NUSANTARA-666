<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori')->insert([
            ['nama_kategori' => 'Ekstrakurikuler', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Peringatan Nasional', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Ucapan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Prestasi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Kegiatan Sekolah', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Pembelajaran', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Olahraga', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Seni Budaya', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}