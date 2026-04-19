<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'id_kegiatan';

    protected $fillable = ['judul', 'isi', 'tanggal', 'foto', 'id_user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_kegiatan', 'id_kegiatan');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'id_kegiatan', 'id_kegiatan');
    }
}
