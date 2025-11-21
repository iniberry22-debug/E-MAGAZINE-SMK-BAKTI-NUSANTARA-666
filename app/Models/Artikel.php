<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id_artikel';
    
    protected $fillable = [
        'judul',
        'isi',
        'tanggal',
        'id_user',
        'id_kategori',
        'foto',
        'status',
        'catatan_review',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tanggal' => 'datetime'
    ];

    public $timestamps = true;

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
        return $this->hasMany(Comment::class, 'artikel_id', 'id_artikel');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'artikel_id', 'id_artikel');
    }
}