<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPenelitian extends Model
{
    use HasFactory;

    protected $table = 'dosen_penelitian';
    protected $fillable = [
        'dosen_nidn',
        'judul_penelitian',
        'topik_penelitian',
        'jenis_penelitian',
        'skema_penelitian',
        'tahun_penelitian',
        'status',
        'abstrak',
        'file_penelitian'
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nidn', 'nidn');
    }

    /**
     * Get all research topics by a lecturer
     */
    public static function getTopikPenelitianByDosen($dosenNidn)
    {
        return self::where('dosen_nidn', $dosenNidn)
            ->where('status', 'selesai')
            ->pluck('topik_penelitian')
            ->toArray();
    }

    /**
     * Get research history for text processing
     */
    public static function getPenelitianHistory($dosenNidn, $limit = 10)
    {
        return self::where('dosen_nidn', $dosenNidn)
            ->where('status', 'selesai')
            ->orderBy('tahun_penelitian', 'desc')
            ->limit($limit)
            ->get();
    }
}
