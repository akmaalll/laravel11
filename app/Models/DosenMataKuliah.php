<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenMataKuliah extends Model
{
    use HasFactory;

    protected $table = 'dosen_mata_kuliah';
    protected $fillable = [
        'dosen_nidn',
        'mata_kuliah',
        'kode_mk',
        'semester',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nidn', 'nidn');
    }

    /**
     * Get all courses taught by a lecturer
     */
    public static function getMataKuliahByDosen($dosenNidn)
    {
        return self::where('dosen_nidn', $dosenNidn)
            ->pluck('mata_kuliah')
            ->toArray();
    }

    /**
     * Get unique courses for text processing
     */
    public static function getAllMataKuliah()
    {
        return self::distinct()
            ->pluck('mata_kuliah')
            ->toArray();
    }
}
