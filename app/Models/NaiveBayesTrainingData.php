<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NaiveBayesTrainingData extends Model
{
    use HasFactory;

    protected $table = 'naive_bayes_training_data';
    protected $fillable = [
        'judul_id',
        'dosen_nidn',
        'judul_skripsi',
        'topik_skripsi',
        'keahlian_dosen',
        'mata_kuliah_dosen',
        'history_bimbingan',
        'history_penelitian',
        'hasil_pembimbingan',
        'nilai_skripsi',
        'catatan',
        'is_training_data'
    ];

    protected $casts = [
        'keahlian_dosen' => 'array',
        'mata_kuliah_dosen' => 'array',
        'history_bimbingan' => 'array',
        'history_penelitian' => 'array',
        'is_training_data' => 'boolean'
    ];

    public function judul()
    {
        return $this->belongsTo(Judul::class, 'judul_id', 'id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nidn', 'nidn');
    }

    /**
     * Get training data for Naive Bayes
     */
    public static function getTrainingData()
    {
        return self::where('is_training_data', true)
            ->where('hasil_pembimbingan', 'berhasil')
            ->get();
    }

    /**
     * Save new training data
     */
    public static function saveTrainingData($data)
    {
        return self::create($data);
    }

    /**
     * Get successful supervision history
     */
    public static function getSuccessfulSupervisions()
    {
        return self::where('hasil_pembimbingan', 'berhasil')
            ->where('is_training_data', true)
            ->get();
    }
}
