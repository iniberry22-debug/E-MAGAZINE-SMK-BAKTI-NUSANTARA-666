<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('like')->insert([
            ['id_artikel' => 1, 'id_user' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_artikel' => 1, 'id_user' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id_artikel' => 2, 'id_user' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_artikel' => 3, 'id_user' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id_artikel' => 4, 'id_user' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_artikel' => 4, 'id_user' => 5, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}