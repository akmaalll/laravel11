<?php

namespace Database\Seeders;

use App\Models\Keahlian;
use App\Models\Mahasiswa;
use App\Models\Mst_keahlian;
use Illuminate\Database\Seeder;

class KeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Keahlian::create([
            'id' =>'KHL001',
            'nama' => 'Pemrograman Web'
        ]);
    }
}
