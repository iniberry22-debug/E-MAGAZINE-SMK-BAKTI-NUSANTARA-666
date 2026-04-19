<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        Artikel::create([
            'judul' => 'Kegiatan yang seru ada di pramuka',
            'kategori' => 'Ekstrakurikuler',
            'penulis' => 'Alya Najla',
            'gambar' => 'blog-hero-1.webp',
            'excerpt' => 'ayoo gabung bersama kami agar kamu bisa merasakan apa itu kekeluargaan',
            'konten' => '<p>Pramuka adalah kegiatan ekstrakurikuler yang sangat menarik dan penuh dengan petualangan. Di dalam pramuka, kamu akan belajar banyak hal mulai dari kepemimpinan, kerjasama tim, hingga survival di alam bebas.</p><p>Kegiatan pramuka tidak hanya sekedar berkemah, tetapi juga mengajarkan nilai-nilai kehidupan yang sangat berharga. Kamu akan belajar mandiri, bertanggung jawab, dan peduli terhadap sesama.</p><p>Bergabunglah dengan pramuka dan rasakan pengalaman yang tak terlupakan bersama teman-teman baru!</p>',
            'waktu_baca' => 3,
            'views' => '1.9k',
            'tanggal_publish' => '2025-08-10'
        ]);

        Artikel::create([
            'judul' => 'Hari Pahlawan',
            'kategori' => 'Peringatan Nasional',
            'penulis' => 'Helga Khoirunnisa',
            'gambar' => 'blog-pahlawan.png',
            'excerpt' => 'Mari kita peringati hari pahlawan yang telah membangun bangsa',
            'konten' => '<p>Hari Pahlawan merupakan hari nasional yang ditetapkan oleh pemerintah Indonesia, yang diperingati  tanggal 10 November setiap tahunnya di Indonesia.</p>',
            'waktu_baca' => 4,
            'views' => '2.3k',
            'tanggal_publish' => '2025-10-10'
        ]);

        Artikel::create([
            'judul' => 'Selamat Mengerjakan UJIKOM',
            'kategori' => 'Ucapan',
            'penulis' => 'Cindy Yuliani',
            'gambar' => 'blog-hero-3.webp',
            'excerpt' => 'How AI is revolutionizing business operations and decision making.',
            'konten' => '<p>Artificial Intelligence is transforming how businesses operate. From customer service chatbots to predictive analytics, AI is everywhere.</p><p>Machine learning algorithms help companies make better decisions by analyzing vast amounts of data. This leads to improved efficiency and customer satisfaction.</p><p>The integration of AI in business processes is no longer optional but essential for staying competitive.</p>',
            'waktu_baca' => 5,
            'views' => '3.1k',
            'tanggal_publish' => '2024-01-10'
        ]);
    }
}