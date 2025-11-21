<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('artikel')->insert([
            [
                'judul' => 'Kegiatan Pramuka Penggalang',
                'isi' => '<p>Pramuka adalah kegiatan ekstrakurikuler yang sangat menarik dan penuh dengan petualangan. Di dalam pramuka, kamu akan belajar banyak hal mulai dari kepemimpinan, kerjasama tim, hingga survival di alam bebas.</p>',
                'tanggal' => '2024-11-01',
                'id_user' => 2,
                'id_kategori' => 1,
                'foto' => 'pramuka.jpg',
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Peringatan Hari Pahlawan',
                'isi' => '<p>Hari Pahlawan merupakan hari nasional yang diperingati tanggal 10 November setiap tahunnya di Indonesia untuk mengenang jasa para pahlawan.</p>',
                'tanggal' => '2024-11-10',
                'id_user' => 2,
                'id_kategori' => 2,
                'foto' => 'pahlawan.jpg',
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Lomba Futsal Antar Kelas',
                'isi' => '<p>Turnamen futsal antar kelas telah dimulai. Semua kelas dari X hingga XII berpartisipasi dalam kompetisi yang seru ini.</p>',
                'tanggal' => '2024-11-15',
                'id_user' => 3,
                'id_kategori' => 7,
                'foto' => 'futsal.jpg',
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Prestasi Siswa di Olimpiade Matematika',
                'isi' => '<p>Siswa SMK Bakti Nusantara 666 meraih juara 2 dalam Olimpiade Matematika tingkat provinsi. Selamat untuk Ahmad Rizki!</p>',
                'tanggal' => '2024-11-20',
                'id_user' => 1,
                'id_kategori' => 4,
                'foto' => 'olimpiade.jpg',
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Workshop Robotika',
                'isi' => '<p>Kegiatan workshop robotika untuk siswa jurusan TKJ dan RPL. Peserta akan belajar membuat robot sederhana menggunakan Arduino.</p>',
                'tanggal' => '2024-11-25',
                'id_user' => 2,
                'id_kategori' => 6,
                'foto' => 'robotika.jpg',
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Pentas Seni Budaya Nusantara',
                'isi' => '<p>Acara pentas seni budaya menampilkan berbagai tarian tradisional dan musik daerah dari seluruh Indonesia.</p>',
                'tanggal' => '2024-12-01',
                'id_user' => 3,
                'id_kategori' => 8,
                'foto' => 'pentas.jpg',
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}