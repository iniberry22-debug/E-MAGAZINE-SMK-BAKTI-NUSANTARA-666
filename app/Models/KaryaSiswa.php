<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KaryaSiswa extends Model
{
    protected $table = 'karya_siswa';
    protected $primaryKey = 'id_karya';

    protected $fillable = ['judul', 'isi', 'penulis', 'kategori', 'tanggal', 'foto', 'id_user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_karya', 'id_karya');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'id_karya', 'id_karya');
    }
}
