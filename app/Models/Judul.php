<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Judul extends Model
{
    use HasFactory;
    protected $table = 'mst_judul';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'id_prodi',
        'id_keahlian',
        'judul',
        'konsentrasi',
        'objek_penelitian',
        'latar_belakang',
        'rumusan_masalah',
        'tujuan_penelitian',
        'penelitian_terkait',
        'nim1',
        'nim2',
        'nidn1',
        'nidn2',
        'sk_pembimbing',
        'status',
    ];
}
