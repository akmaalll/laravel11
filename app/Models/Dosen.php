<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'mst_dosens';
    protected $primaryKey = 'nidn';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nidn',
        'nama',
        'email',
    ];

    public function keahlians()
    {
        return $this->belongsToMany(
            Keahlian::class,
            'mst_keahlian_dosens', // Nama pivot table
            'dosen_id',      // FK di pivot table untuk Dosen
            'keahlian_id'    // FK di pivot table untuk Keahlian
        );
    }

    public function mataKuliah()
    {
        return $this->hasMany(DosenMataKuliah::class, 'dosen_nidn', 'nidn');
    }

    public function penelitian()
    {
        return $this->hasMany(DosenPenelitian::class, 'dosen_nidn', 'nidn');
    }

    public function pembimbingan()
    {
        return $this->hasMany(Pembimbing::class, 'id_dosen', 'nidn');
    }

    public function mstJudulPembimbingan()
    {
        return $this->hasMany(MstJudulPembimbing::class, 'dosen_nidn', 'nidn');
    }

    public function trainingData()
    {
        return $this->hasMany(NaiveBayesTrainingData::class, 'dosen_nidn', 'nidn');
    }

    /**
     * Get all attributes for Naive Bayes calculation
     */
    public function getNaiveBayesAttributes()
    {
        return [
            'keahlian' => $this->keahlians()->pluck('nama')->toArray(),
            'mata_kuliah' => $this->mataKuliah()->pluck('mata_kuliah')->toArray(),
            'history_bimbingan' => $this->getHistoryBimbingan(),
            'history_penelitian' => $this->penelitian()->pluck('topik_penelitian')->toArray()
        ];
    }

    /**
     * Get history of supervised thesis topics
     */
    public function getHistoryBimbingan()
    {
        return $this->pembimbingan()
            ->with('pengajuanJudul')
            ->whereHas('pengajuanJudul', function ($query) {
                $query->where('status', 'diterima');
            })
            ->get()
            ->pluck('pengajuanJudul.topik')
            ->toArray();
    }
}
