<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artikel_id');
            $table->string('ip_address');
            $table->timestamps();
            
            $table->foreign('artikel_id')->references('id_artikel')->on('artikel');
            $table->unique(['artikel_id', 'ip_address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};