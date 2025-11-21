<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kegiatan')->insert([
            [
                'judul' => 'Upacara Bendera Hari Senin',
                'isi' => '<p>Upacara bendera rutin setiap hari Senin diikuti oleh seluruh siswa dan guru SMK Bakti Nusantara 666.</p>',
                'tanggal' => '2024-11-11',
                'id_user' => 2,
                'id_kategori' => 5,
                'foto' => 'upacara.jpg',
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Kegiatan Gotong Royong Sekolah',
                'isi' => '<p>Seluruh warga sekolah bergotong royong membersihkan lingkungan sekolah dalam rangka menyambut bulan kemerdekaan.</p>',
                'tanggal' => '2024-11-12',
                'id_user' => 3,
                'id_kategori' => 5,
                'foto' => 'gotong-royong.jpg',
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Pelatihan Soft Skills Siswa',
                'isi' => '<p>Pelatihan komunikasi dan kepemimpinan untuk meningkatkan soft skills siswa kelas XI dan XII.</p>',
                'tanggal' => '2024-11-13',
                'id_user' => 2,
                'id_kategori' => 6,
                'foto' => 'pelatihan.jpg',
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}