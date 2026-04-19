<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id_artikel';

    protected $fillable = ['judul', 'isi', 'id_user', 'id_kategori', 'status', 'tanggal', 'foto', 'catatan_review'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_artikel', 'id_artikel');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'id_artikel', 'id_artikel');
    }
}
