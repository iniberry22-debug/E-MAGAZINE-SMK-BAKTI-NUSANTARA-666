<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karya_comments', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'comment' atau 'like'
            $table->string('content_type'); // 'artikel', 'karya', 'kegiatan'
            $table->integer('content_id');
            $table->string('judul'); // judul artikel/karya/kegiatan
            $table->string('name')->nullable(); // untuk komentar
            $table->string('email')->nullable(); // untuk komentar
            $table->text('comment')->nullable(); // untuk komentar
            $table->string('ip_address')->nullable(); // untuk like
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karya_comments');
    }
};
