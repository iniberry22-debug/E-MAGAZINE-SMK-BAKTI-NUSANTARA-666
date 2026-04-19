<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeaturedPost;

class FeaturedPostSeeder extends Seeder
{
    public function run(): void
    {
        FeaturedPost::create([
            'title' => 'Lomba Karya Tulis Ilmiah Tingkat SMA',
            'category' => 'Akademik',
            'author' => 'Siti Nurhaliza',
            'image' => 'blog-post-square-3.webp',
            'excerpt' => 'Kompetisi menulis karya ilmiah untuk siswa SMA se-Indonesia.',
            'read_time' => 5,
            'published_date' => '2025-02-08'
        ]);

        FeaturedPost::create([
            'title' => 'Workshop Desain Grafis untuk Pemula',
            'category' => 'Kreatif',
            'author' => 'Alexander Thompson',
            'image' => 'blog-post-square-7.webp',
            'excerpt' => 'Belajar dasar-dasar desain grafis dengan software profesional.',
            'read_time' => 8,
            'published_date' => '2025-02-12'
        ]);

        FeaturedPost::create([
            'title' => 'Seminar Kewirausahaan Muda',
            'category' => 'Bisnis',
            'author' => 'Sophia Williams',
            'image' => 'blog-post-square-1.webp',
            'excerpt' => 'Tips memulai bisnis di usia muda dari para entrepreneur sukses.',
            'read_time' => 3,
            'published_date' => '2025-02-15'
        ]);
    }
}