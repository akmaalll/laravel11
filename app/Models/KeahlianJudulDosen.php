<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeahlianJudulDosen extends Model
{
    protected $table = 'mst_keahlian_judul_dosen';

    protected $fillable = [
        'id_dosen_penelitian',
        'id_keahlian',
    ];
}
