<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeahlianDosen extends Model
{
    protected $table = 'mst_keahlian_dosen'; 

    protected $fillable = [
        'id_matkul_dosen',   
        'id_keahlian',   
    ];

}
