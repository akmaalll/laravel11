<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Pembimbing extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_dosen',
        'id_judul',
        'peran',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen', 'nidn');
    }

    public function pengajuanJudul()
    {
        return $this->belongsTo(PengajuanJudul::class, 'id_judul', 'id');
    }
}
