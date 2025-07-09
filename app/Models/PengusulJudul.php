<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengusulJudul extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_judul',
        'nim',
        'nama',
    ];

    public function judul()
    {
        return $this->belongsTo(PengajuanJudul::class, 'id_judul', 'id');
    }
}
