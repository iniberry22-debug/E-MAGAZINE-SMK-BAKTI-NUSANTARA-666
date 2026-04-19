<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Kegiatan Sekolah', 'Peringatan Nasional', 'Ucapan',
            'Prestasi', 'Berita', 'Teknologi', 'Seni & Budaya',
        ];

        foreach ($kategoris as $nama) {
            Kategori::firstOrCreate(['nama_kategori' => $nama]);
        }
    }
}
