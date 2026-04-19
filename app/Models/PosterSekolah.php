<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosterSekolah extends Model
{
    protected $table = 'poster_sekolah';

    protected $fillable = ['judul', 'foto', 'id_user', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
