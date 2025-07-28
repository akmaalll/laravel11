<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MstJudulPembimbing;
use App\Models\Judul;

class MstJudulPembimbingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil judul yang sudah ada
        $juduls = Judul::all();
        if ($juduls->isEmpty()) {
            $this->command->warn('Tidak ada data judul. Seeder MstJudulPembimbingSeeder dilewati.');
            return;
        }

        $data = [
            // Judul 1: Watermarking (2 pembimbing)
            [
                'id_judul' => 1,
                'dosen_nidn' => '0914117202',
                'peran' => 'pembimbing_1',
                'status_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.75,
                'catatan' => 'Implementasi watermarking berhasil dengan baik'
            ],
            [
                'id_judul' => 1,
                'dosen_nidn' => '0910027401',
                'peran' => 'pembimbing_2',
                'status_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.80,
                'catatan' => 'Keamanan citra digital berhasil diimplementasikan'
            ],
            // Judul 2: Sistem Pakar Tuberkulosis (2 pembimbing)
            [
                'id_judul' => 2,
                'dosen_nidn' => '0914117202',
                'peran' => 'pembimbing_1',
                'status_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.85,
                'catatan' => 'Sistem pakar berhasil dikembangkan dengan akurasi tinggi'
            ],
            [
                'id_judul' => 2,
                'dosen_nidn' => '0910027401',
                'peran' => 'pembimbing_2',
                'status_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.90,
                'catatan' => 'Aplikasi Android berjalan dengan baik'
            ],
            // Judul 3: Sistem Informasi Bantuan Ternak (2 pembimbing)
            [
                'id_judul' => 3,
                'dosen_nidn' => '0914117202',
                'peran' => 'pembimbing_1',
                'status_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.70,
                'catatan' => 'Sistem informasi web berhasil dikembangkan'
            ],
            [
                'id_judul' => 3,
                'dosen_nidn' => '0910027401',
                'peran' => 'pembimbing_2',
                'status_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.75,
                'catatan' => 'Web service terintegrasi dengan baik'
            ],
            // Judul 4: Aplikasi Perkiraan Pajak (2 pembimbing)
            [
                'id_judul' => 4,
                'dosen_nidn' => '0914117202',
                'peran' => 'pembimbing_1',
                'status_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.80,
                'catatan' => 'Implementasi metode ARIMA berhasil'
            ],
            [
                'id_judul' => 4,
                'dosen_nidn' => '0910027401',
                'peran' => 'pembimbing_2',
                'status_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.85,
                'catatan' => 'IoT dan intelligent system berjalan optimal'
            ],
            // Judul 5: Implementasi C4.5 (2 pembimbing)
            [
                'id_judul' => 5,
                'dosen_nidn' => '0914117202',
                'peran' => 'pembimbing_1',
                'status_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.75,
                'catatan' => 'Algoritma C4.5 berhasil diimplementasikan'
            ],
            [
                'id_judul' => 5,
                'dosen_nidn' => '0910027401',
                'peran' => 'pembimbing_2',
                'status_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.80,
                'catatan' => 'Data mining memberikan hasil yang akurat'
            ],
        ];

        foreach ($data as $item) {
            MstJudulPembimbing::create($item);
        }

        $this->command->info('Sample data mst_judul_pembimbings berhasil ditambahkan!');
    }
}
