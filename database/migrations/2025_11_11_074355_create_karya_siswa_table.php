<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karya_siswa', function (Blueprint $table) {
            $table->id('id_karya');
            $table->string('judul');
            $table->text('isi');
            $table->string('penulis');
            $table->string('kelas');
            $table->string('kategori');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karya_siswa');
    }
};