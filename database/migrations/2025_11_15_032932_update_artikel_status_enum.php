<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('artikel', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'published', 'rejected'])->default('pending');
        });
    }

    public function down(): void
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('artikel', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published'])->default('draft');
        });
    }
};