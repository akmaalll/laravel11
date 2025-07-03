<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'mst_dosens';

    protected $fillable = [
        'nidn',
        'nama',
        'email',
        'id_keahlian',
    ];

    public function keahlian()
    {
        return $this->hasOne(Keahlian::class, 'id', 'id_keahlian');
    }
}
