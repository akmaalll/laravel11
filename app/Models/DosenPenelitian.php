<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPenelitian extends Model
{
    use HasFactory;

    protected $table = 'mst_dosen_penelitian';
    protected $fillable = [
        'nidn',
        'judul_penelitian',
    ];
}
