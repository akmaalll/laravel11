<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanJudul extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'id_prodi',
        'judul',
        'topik',
        'konsentrasi',
        'objek_penelitian',
        'latar_belakang',
        'rumusan_masalah',
        'tujuan_penelitian',
        'penelitian_terkait',
        'status',
    ];

    public function pengusuls()
    {
        return $this->hasMany(PengusulJudul::class, 'id_judul', 'id');
    }

    public function pembimbings()
    {
        return $this->hasMany(Pembimbing::class, 'id_judul', 'id');
    }

    public function prodi()
    {
        return $this->hasOne(Prodi::class, 'id_prodi', 'id');
    }
}
