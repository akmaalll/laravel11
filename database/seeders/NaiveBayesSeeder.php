<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\DosenMataKuliah;
use App\Models\DosenPenelitian;
use App\Models\NaiveBayesTrainingData;

class NaiveBayesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data untuk testing Naive Bayes

        // 1. Sample Mata Kuliah Dosen
        $mataKuliahData = [
            ['dosen_nidn' => '0914117202', 'mata_kuliah' => 'Pemrograman Web', 'kode_mk' => 'IF101', 'sks' => 3],
            ['dosen_nidn' => '0914117202', 'mata_kuliah' => 'Database Management', 'kode_mk' => 'IF102', 'sks' => 3],
            ['dosen_nidn' => '0910027401', 'mata_kuliah' => 'Machine Learning', 'kode_mk' => 'IF201', 'sks' => 3],
            ['dosen_nidn' => '0910027401', 'mata_kuliah' => 'Artificial Intelligence', 'kode_mk' => 'IF202', 'sks' => 3],
            ['dosen_nidn' => '0920037103', 'mata_kuliah' => 'Mobile Development', 'kode_mk' => 'IF301', 'sks' => 3],
            ['dosen_nidn' => '0920037103', 'mata_kuliah' => 'Software Engineering', 'kode_mk' => 'IF302', 'sks' => 3],
        ];

        foreach ($mataKuliahData as $data) {
            DosenMataKuliah::create($data);
        }

        // 2. Sample Penelitian Dosen
        $penelitianData = [
            [
                'dosen_nidn' => '0914117202',
                'judul_penelitian' => 'Sistem Informasi Akademik Berbasis Web',
                'topik_penelitian' => 'Web Development, Database, Sistem Informasi',
                'jenis_penelitian' => 'Terapan',
                'tahun_penelitian' => 2023,
                'status' => 'selesai'
            ],
            [
                'dosen_nidn' => '0910027401',
                'judul_penelitian' => 'Implementasi Algoritma Naive Bayes untuk Klasifikasi Teks',
                'topik_penelitian' => 'Machine Learning, Natural Language Processing, Naive Bayes',
                'jenis_penelitian' => 'Dasar',
                'tahun_penelitian' => 2023,
                'status' => 'selesai'
            ],
            [
                'dosen_nidn' => '0920037103',
                'judul_penelitian' => 'Pengembangan Aplikasi Mobile untuk E-Commerce',
                'topik_penelitian' => 'Mobile Development, E-Commerce, User Experience',
                'jenis_penelitian' => 'Pengembangan',
                'tahun_penelitian' => 2023,
                'status' => 'selesai'
            ],
        ];

        foreach ($penelitianData as $data) {
            DosenPenelitian::create($data);
        }

        // 3. Sample Training Data - Data dari mst_juduls dengan 2 pembimbing per judul
        $trainingData = [
            // Judul 1: Watermarking (2 pembimbing)
            [
                'judul_id' => 1, // ID dari mst_juduls
                'dosen_nidn' => '0914117202', // Pembimbing 1
                'judul_skripsi' => 'PERANCANGAN APLIKASI WATERMARKING KEPEMILIKAN CITRA MENGGUNAKAN KOMBINASI METODE SHA DAN LEAST SIGNIFICANT BIT (LSB)',
                'topik_skripsi' => 'Keamanan Komputer dan Informasi',
                'keahlian_dosen' => json_encode(['Keamanan Komputer', 'Kriptografi']),
                'mata_kuliah_dosen' => json_encode(['Keamanan Informasi', 'Kriptografi']),
                'history_bimbingan' => json_encode(['Keamanan Komputer', 'Kriptografi']),
                'history_penelitian' => json_encode(['Keamanan Komputer, Kriptografi, Watermarking']),
                'hasil_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.75
            ],
            [
                'judul_id' => 1, // ID dari mst_juduls
                'dosen_nidn' => '0910027401', // Pembimbing 2
                'judul_skripsi' => 'PERANCANGAN APLIKASI WATERMARKING KEPEMILIKAN CITRA MENGGUNAKAN KOMBINASI METODE SHA DAN LEAST SIGNIFICANT BIT (LSB)',
                'topik_skripsi' => 'Keamanan Komputer dan Informasi',
                'keahlian_dosen' => json_encode(['Keamanan Komputer', 'Kriptografi']),
                'mata_kuliah_dosen' => json_encode(['Keamanan Informasi', 'Kriptografi']),
                'history_bimbingan' => json_encode(['Keamanan Komputer', 'Kriptografi']),
                'history_penelitian' => json_encode(['Keamanan Komputer, Kriptografi, Watermarking']),
                'hasil_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.80
            ],
            // Judul 2: Sistem Pakar Tuberkulosis (2 pembimbing)
            [
                'judul_id' => 2, // ID dari mst_juduls
                'dosen_nidn' => '0914117202', // Pembimbing 1
                'judul_skripsi' => 'APLIKASI SISTEM PAKAR MENDIAGNOSA PENYAKIT TUBERKULOSIS MENGGUNAKAN METODE CERTAINTY FACTOR BERBASIS ANDROID',
                'topik_skripsi' => 'Artificial Intelligence',
                'keahlian_dosen' => json_encode(['Artificial Intelligence', 'Sistem Pakar']),
                'mata_kuliah_dosen' => json_encode(['Artificial Intelligence', 'Sistem Pakar']),
                'history_bimbingan' => json_encode(['Artificial Intelligence', 'Sistem Pakar']),
                'history_penelitian' => json_encode(['Artificial Intelligence, Sistem Pakar, Certainty Factor']),
                'hasil_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.85
            ],
            [
                'judul_id' => 2, // ID dari mst_juduls
                'dosen_nidn' => '0910027401', // Pembimbing 2
                'judul_skripsi' => 'APLIKASI SISTEM PAKAR MENDIAGNOSA PENYAKIT TUBERKULOSIS MENGGUNAKAN METODE CERTAINTY FACTOR BERBASIS ANDROID',
                'topik_skripsi' => 'Artificial Intelligence',
                'keahlian_dosen' => json_encode(['Artificial Intelligence', 'Sistem Pakar']),
                'mata_kuliah_dosen' => json_encode(['Artificial Intelligence', 'Sistem Pakar']),
                'history_bimbingan' => json_encode(['Artificial Intelligence', 'Sistem Pakar']),
                'history_penelitian' => json_encode(['Artificial Intelligence, Sistem Pakar, Certainty Factor']),
                'hasil_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.90
            ],
            // Judul 3: Sistem Informasi Bantuan Ternak (2 pembimbing)
            [
                'judul_id' => 3, // ID dari mst_juduls
                'dosen_nidn' => '0914117202', // Pembimbing 1
                'judul_skripsi' => 'PERANCANGAN SISTEM INFORMASI PEMBERIAN BANTUAN TERNAK BERBASIS WEB PADA DINAS PETERNAKAN DAN KESEHATAN HEWAN PRO. SULSEL',
                'topik_skripsi' => 'Sistem Terdistribusi (Web Service)',
                'keahlian_dosen' => json_encode(['Web Development', 'Web Service']),
                'mata_kuliah_dosen' => json_encode(['Pemrograman Web', 'Web Service']),
                'history_bimbingan' => json_encode(['Web Development', 'Web Service']),
                'history_penelitian' => json_encode(['Web Development, Web Service, Sistem Informasi']),
                'hasil_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.70
            ],
            [
                'judul_id' => 3, // ID dari mst_juduls
                'dosen_nidn' => '0910027401', // Pembimbing 2
                'judul_skripsi' => 'PERANCANGAN SISTEM INFORMASI PEMBERIAN BANTUAN TERNAK BERBASIS WEB PADA DINAS PETERNAKAN DAN KESEHATAN HEWAN PRO. SULSEL',
                'topik_skripsi' => 'Sistem Terdistribusi (Web Service)',
                'keahlian_dosen' => json_encode(['Web Development', 'Web Service']),
                'mata_kuliah_dosen' => json_encode(['Pemrograman Web', 'Web Service']),
                'history_bimbingan' => json_encode(['Web Development', 'Web Service']),
                'history_penelitian' => json_encode(['Web Development, Web Service, Sistem Informasi']),
                'hasil_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.75
            ],
        ];

        foreach ($trainingData as $data) {
            NaiveBayesTrainingData::create($data);
        }

        $this->command->info('Sample data for Naive Bayes has been seeded successfully!');
    }
}
