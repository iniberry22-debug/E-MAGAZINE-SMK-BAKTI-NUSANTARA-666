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
            $table->longText('isi');
            $table->string('penulis')->nullable();
            $table->string('kategori')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karya_siswa');
    }
};
