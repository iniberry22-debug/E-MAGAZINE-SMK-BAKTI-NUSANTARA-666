<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosterSekolah extends Model
{
    protected $table = 'poster_sekolah';
    
    protected $fillable = [
        'judul',
        'foto',
        'kategori',
        'user_id',
        'status'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
