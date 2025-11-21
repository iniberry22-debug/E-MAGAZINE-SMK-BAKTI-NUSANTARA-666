<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('like', function (Blueprint $table) {
            $table->id('id_like');
            $table->unsignedBigInteger('id_artikel');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();
            
            $table->foreign('id_artikel')->references('id_artikel')->on('artikel');
            $table->foreign('id_user')->references('id_user')->on('user');
            
            $table->unique(['id_artikel', 'id_user']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('like');
    }
};