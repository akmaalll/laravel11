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
        'id_prodi',
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->hasOne(Prodi::class, 'id', 'id_prodi');
    }

    public function pembimbings()
    {
        return $this->hasMany(MstJudulPembimbing::class, 'id_judul', 'id');
    }

    public function pembimbing1()
    {
        return $this->hasOne(MstJudulPembimbing::class, 'id_judul', 'id')
            ->where('peran', 'pembimbing_1');
    }

    public function pembimbing2()
    {
        return $this->hasOne(MstJudulPembimbing::class, 'id_judul', 'id')
            ->where('peran', 'pembimbing_2');
    }
}
