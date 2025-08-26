<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenMataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mst_matkul_dosen';
    protected $fillable = [
        'nidn',
        'matkul',
    ];
}
