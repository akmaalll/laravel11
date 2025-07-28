<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstJudulPembimbing extends Model
{
    use HasFactory;

    protected $table = 'mst_judul_pembimbings';

    protected $fillable = [
        'id_judul',
        'dosen_nidn',
        'peran',
        'status_pembimbingan',
        'nilai_skripsi',
        'catatan',
    ];

    protected $casts = [
        'nilai_skripsi' => 'decimal:2',
    ];

    public function judul()
    {
        return $this->belongsTo(Judul::class, 'id_judul', 'id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nidn', 'nidn');
    }

    /**
     * Get successful supervisions for training data
     */
    public static function getSuccessfulSupervisions()
    {
        return self::where('status_pembimbingan', 'berhasil')
            ->with(['judul', 'dosen'])
            ->get();
    }

    /**
     * Get supervision history for a specific lecturer
     */
    public static function getSupervisionHistory($dosenNidn)
    {
        return self::where('dosen_nidn', $dosenNidn)
            ->where('status_pembimbingan', 'berhasil')
            ->with('judul')
            ->get()
            ->pluck('judul.topik')
            ->toArray();
    }
}
