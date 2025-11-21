<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'artikel_id',
        'content_type',
        'content_id',
        'judul',
        'name',
        'email',
        'comment',
        'user_id',
        'isi_komentar'
    ];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'artikel_id', 'id_artikel');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}