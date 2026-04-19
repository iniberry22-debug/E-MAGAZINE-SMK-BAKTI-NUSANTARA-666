<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        BlogPost::create([
            'title' => 'Kegiatan yang seru ada di pramuka',
            'category' => 'Ekstrakurikuler',
            'author' => 'Alya Najla',
            'image' => 'blog-hero-1.webp',
            'excerpt' => 'Pramuka adalah kegiatan ekstrakurikuler yang sangat menyenangkan dan penuh dengan petualangan. Di sini kamu akan belajar tentang kepemimpinan, kerjasama tim, dan berbagai keterampilan hidup yang berguna.',
            'content' => 'Pramuka merupakan salah satu kegiatan ekstrakurikuler yang paling populer di sekolah-sekolah Indonesia. Kegiatan ini tidak hanya mengajarkan kedisiplinan, tetapi juga membangun karakter dan kepribadian yang kuat pada setiap anggotanya.\n\nDalam kegiatan pramuka, siswa akan diajak untuk melakukan berbagai aktivitas menarik seperti berkemah, hiking, permainan outbound, dan berbagai keterampilan kepramukaan lainnya. Semua kegiatan ini dirancang untuk mengembangkan jiwa kepemimpinan, kerjasama tim, dan kemandirian.\n\nSelain itu, pramuka juga mengajarkan nilai-nilai luhur seperti kejujuran, tanggung jawab, dan cinta tanah air. Melalui berbagai kegiatan yang dilakukan, anggota pramuka akan belajar untuk menjadi pribadi yang berkarakter dan siap menghadapi tantangan di masa depan.\n\nAyo bergabung dengan kami dan rasakan pengalaman seru menjadi bagian dari keluarga besar pramuka!',
            'read_time' => 3,
            'views' => '1.9k',
            'published_date' => '2025-08-10',
            'is_featured' => true
        ]);

        BlogPost::create([
            'title' => 'The Future of Remote Work and Digital Transformation',
            'category' => 'Business',
            'author' => 'Mark Johnson',
            'image' => 'blog-hero-2.webp',
            'excerpt' => 'Exploring how remote work is reshaping the business landscape and creating new opportunities for digital transformation.',
            'content' => 'Remote work has fundamentally changed how we approach business operations and employee management. What started as a necessity during the pandemic has evolved into a permanent shift in workplace culture.\n\nCompanies are now investing heavily in digital infrastructure to support distributed teams. This includes cloud-based collaboration tools, project management platforms, and advanced communication systems that enable seamless remote collaboration.\n\nThe benefits of remote work extend beyond just flexibility. Organizations are seeing increased productivity, reduced overhead costs, and access to a global talent pool. However, this transformation also brings challenges such as maintaining company culture, ensuring data security, and managing remote team dynamics.\n\nDigital transformation is no longer optional but essential for businesses to remain competitive in this new landscape. Companies must adapt their processes, technologies, and mindset to thrive in the remote work era.',
            'read_time' => 4,
            'views' => '2.3k',
            'published_date' => '2024-01-12',
            'is_featured' => true
        ]);

        BlogPost::create([
            'title' => 'Artificial Intelligence in Modern Business Applications',
            'category' => 'Technology',
            'author' => 'Sarah Williams',
            'image' => 'blog-hero-3.webp',
            'excerpt' => 'How AI is revolutionizing business operations and decision making.',
            'read_time' => 5,
            'views' => '3.1k',
            'published_date' => '2024-01-10',
            'is_featured' => true
        ]);

        BlogPost::create([
            'title' => 'Building High-Performance Teams in a Digital Age',
            'category' => 'Leadership',
            'author' => 'David Chen',
            'image' => 'blog-hero-4.webp',
            'excerpt' => 'Strategies for creating and managing effective teams in the digital era.',
            'read_time' => 4,
            'views' => '2.7k',
            'published_date' => '2024-01-08',
            'is_featured' => true
        ]);

        BlogPost::create([
            'title' => 'Sustainable Business Practices for the Modern Enterprise',
            'category' => 'Innovation',
            'author' => 'Emma Davis',
            'image' => 'blog-hero-5.webp',
            'excerpt' => 'Implementing eco-friendly practices that benefit both business and environment.',
            'read_time' => 3,
            'views' => '2.5k',
            'published_date' => '2024-01-06',
            'is_featured' => true
        ]);

        BlogPost::create([
            'title' => 'Hari Pahlawan',
            'category' => 'Peringatan Nasional',
            'author' => 'Mading BN 666',
            'image' => 'blog-pahlawan.png',
            'excerpt' => 'Mari kita peringati hari pahlawan yang telah membangun bangsa',
            'content' => 'Hari Pahlawan merupakan hari nasional yang ditetapkan oleh pemerintah Indonesia, yang diperingati tanggal 10 November setiap tahunnya di Indonesia.',
            'read_time' => 4,
            'views' => '2.3k',
            'published_date' => '2025-10-10',
            'is_featured' => true
        ]);

        BlogPost::create([
            'title' => 'Selamat Mengerjakan UJIKOM',
            'category' => 'Ucapan',
            'author' => 'SMK Bakti Nusantara 666',
            'image' => 'blog-hero-3.webp',
            'excerpt' => 'Semangat untuk mengerjakan ujian kompetensi keahlian',
            'content' => 'Ujian Kompetensi Keahlian merupakan bagian dari Ujian Nasional yang bertujuan untuk mengukur pencapaian kompetensi siswa yang setara dengan kualifikasi jenjang 2 atau 3 pada KKNI.',
            'read_time' => 5,
            'views' => '3.1k',
            'published_date' => '2024-01-10',
            'is_featured' => true
        ]);
    }
}