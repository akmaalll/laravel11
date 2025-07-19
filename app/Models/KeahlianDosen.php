<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeahlianDosen extends Model
{
    protected $table = 'mst_keahlian_dosens'; // Nama pivot table
    public $incrementing = false; // Non-aktifkan auto-increment
    public $timestamps = false; // Non-aktifkan timestamps

    protected $fillable = [
        'dosen_id',   // FK ke tabel dosens (sesuai migrasi)
        'keahlian_id',   // FK ke tabel keahlians
        // Tambahkan kolom lain jika ada di pivot table
    ];

    // Relasi ke Dosen
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'nidn');
    }

    // Relasi ke Keahlian
    public function keahlian()
    {
        return $this->belongsTo(Keahlian::class, 'keahlian_id', 'id');
    }
}
