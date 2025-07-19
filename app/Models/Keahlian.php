<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keahlian extends Model
{
    use HasFactory;

    protected $table = 'mst_keahlians';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'nama',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $latest = static::orderBy('id', 'desc')->first();
                $nextNumber = $latest ? (int) substr($latest->id, 3) + 1 : 1;
                $model->id = 'KHL' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function dosens()
    {
        return $this->belongsToMany(
            Dosen::class,
            'dosen_keahlian',
            'keahlian_id',
            'dosen_id'
        );
    }
}
