<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $topikData = [
            // Contoh data untuk jurusan Teknik Informatika (kode: IF)
            [
                'kode' => 1,
                'nama' => 'Sistem Informasi',
            ],
            [
                'kode' => 2,
                'nama' => 'Teknik Informatika',
            ],
            [
                'kode' => 3,
                'nama' => 'Manajemen Informatika',
            ],
            [
                'kode' => 4,
                'nama' => 'Kewirausahaan',
            ],
            [
                'kode' => 5,
                'nama' => 'Rekayasa Perangkat Lunak',
            ],
            [
                'kode' => 6,
                'nama' => 'Bisnis Digital`',
            ],
        ];

        foreach ($topikData as $topik) {
            Prodi::create($topik);
        }
    }
}
