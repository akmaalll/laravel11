<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Judul extends Model
{
    use HasFactory;
    protected $table = 'mst_juduls';

    protected $fillable = [
        'judul',
        'topik',
        'id_prodi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
