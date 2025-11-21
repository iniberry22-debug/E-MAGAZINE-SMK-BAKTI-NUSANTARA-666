<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KategoriSeeder::class,
            ArtikelSeeder::class,
            KegiatanSeeder::class,
            KaryaSiswaSeeder::class,
            LikeSeeder::class,
            LogAktivitasSeeder::class,
        ]);
    }
}
