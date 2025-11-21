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
        Schema::table('comments', function (Blueprint $table) {
            $table->string('content_type')->default('artikel'); // 'artikel', 'karya', 'kegiatan'
            $table->integer('content_id')->nullable();
            $table->string('judul')->nullable();
            $table->unsignedBigInteger('artikel_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['content_type', 'content_id', 'judul']);
        });
    }
};
