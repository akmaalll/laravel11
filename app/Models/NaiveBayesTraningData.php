<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NaiveBayesTraningData extends Model
{
    use HasFactory;

    protected $table = 'naive_bayes_training_data';
    protected $fillable = [
        'nidn',
        'nama',
        'jumlah_keahlian',
        'jumlah_penelitian',
        'jumlah_riwayat',
        'rekomendasi',
    ];
}
