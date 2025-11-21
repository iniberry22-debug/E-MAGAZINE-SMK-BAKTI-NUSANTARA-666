<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('karya_siswa', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('kategori');
        });
    }

    public function down(): void
    {
        Schema::table('karya_siswa', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};