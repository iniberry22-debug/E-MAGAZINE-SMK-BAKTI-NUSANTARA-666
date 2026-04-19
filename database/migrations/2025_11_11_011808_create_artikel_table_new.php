<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->id('id_artikel');
            $table->string('judul');
            $table->longText('isi');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->enum('status', ['draft', 'pending', 'approved', 'published', 'rejected'])->default('draft');
            $table->date('tanggal')->nullable();
            $table->string('foto')->nullable();
            $table->text('catatan_review')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('set null');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};
