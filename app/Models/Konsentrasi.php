<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsentrasi extends Model
{
    use HasFactory;

    protected $table = 'mst_konsentrasi';
    protected $fillable = [
        'id_prodi',
        'nama',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id');
    }
}
