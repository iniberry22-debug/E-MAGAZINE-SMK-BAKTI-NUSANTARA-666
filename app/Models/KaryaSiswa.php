<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryaSiswa extends Model
{
    use HasFactory;

    protected $table = 'karya_siswa';
    protected $primaryKey = 'id_karya';

    protected $fillable = [
        'judul',
        'isi',
        'penulis',
        'kelas',
        'kategori',
        'foto',
        'tanggal'
    ];
}